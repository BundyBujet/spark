<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ItemSource;
use App\Enums\ItemStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemListRequest;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Models\Item;
use App\Repositories\ItemRepository;
use App\Repositories\TagRepository;
use App\Repositories\TelegramFileRepository;
use App\Services\ItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function __construct(
        protected ItemService $service,
        protected ItemRepository $repository,
        protected TagRepository $tagRepository,
        protected TelegramFileRepository $telegramFileRepository
    ) {}

    public function index(ItemListRequest $request): View
    {
        $filters = array_merge($request->validated(), ['expiring_soon' => $request->boolean('expiring_soon')]);
        $perPage = (int) (defined('COUNT') ? COUNT : 30);
        $items = $this->repository->list($filters, $perPage);
        $tags = $this->tagRepository->list();

        return view('admin.items.index', compact('items', 'tags'));
    }

    public function create(): View
    {
        $tags = $this->tagRepository->list();
        $telegramFiles = $this->telegramFileRepository->list();

        return view('admin.items.create', compact('tags', 'telegramFiles'));
    }

    public function store(ItemStoreRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $itemData = $this->buildItemData($data);
            $itemData['status'] = $itemData['status'] ?? ItemStatus::Active->value;
            $itemData['source'] = ! empty($itemData['source']) ? $itemData['source'] : ItemSource::Web->value;
            $taskData = $this->buildTaskData($data);
            $tagIds = $request->input('tags', []);

            $this->service->createItem($itemData, $tagIds, $taskData);

            return redirect()->route('items.index')
                ->with('success', __('ITEMS_CREATED'));
        } catch (\Throwable $e) {
            Log::error('Item store failed', ['exception' => $e->getMessage()]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('ITEMS_ERROR'));
        }
    }

    public function show(Item $item): View
    {
        $item->load(['tags', 'task', 'telegramFile']);

        return view('admin.items.show', compact('item'));
    }

    public function edit(Item $item): View
    {
        $item->load(['tags', 'task']);
        $tags = $this->tagRepository->list();
        $telegramFiles = $this->telegramFileRepository->list();

        return view('admin.items.edit', compact('item', 'tags', 'telegramFiles'));
    }

    public function update(ItemUpdateRequest $request, Item $item): RedirectResponse
    {
        try {
            $data = $request->validated();
            $itemData = $this->buildItemData($data);
            if (array_key_exists('source', $itemData) && $itemData['source'] === '') {
                $itemData['source'] = ItemSource::Web->value;
            }
            $taskData = $this->buildTaskData($data);
            $tagIds = $request->input('tags', []);

            $this->service->updateItem($item, $itemData, $tagIds, $taskData);

            return redirect()->route('items.index')
                ->with('success', __('ITEMS_UPDATED'));
        } catch (\Throwable $e) {
            Log::error('Item update failed', ['exception' => $e->getMessage()]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('ITEMS_ERROR'));
        }
    }

    public function destroy(Item $item): RedirectResponse
    {
        $this->repository->delete($item);

        return redirect()->route('items.index')
            ->with('success', __('SUCCESS'));
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function buildItemData(array $data): array
    {
        $keys = ['type', 'title', 'content', 'status', 'expires_at', 'source', 'telegram_file_id'];
        $itemData = [];
        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                $itemData[$key] = $data[$key];
            }
        }

        return $itemData;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>|null
     */
    private function buildTaskData(array $data): ?array
    {
        $taskKeys = ['priority', 'due_date', 'task_status'];
        $taskData = [];
        foreach ($taskKeys as $key) {
            if (array_key_exists($key, $data) && $data[$key] !== null && $data[$key] !== '') {
                $taskData[$key] = $data[$key];
            }
        }
        if ($taskData === []) {
            return null;
        }

        return $taskData;
    }
}
