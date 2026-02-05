<?php

namespace App\Services;

use App\Enums\ItemType;
use App\Models\Item;
use App\Repositories\ItemRepository;
use App\Repositories\TagRepository;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\DB;

class ItemService
{
    public function __construct(
        protected ItemRepository $itemRepository,
        protected TagRepository $tagRepository,
        protected TaskRepository $taskRepository
    ) {}

    /**
     * Create an item with optional tags and task data (when type is task).
     */
    public function createItem(array $itemData, array $tagIds = [], ?array $taskData = null): Item
    {
        return DB::transaction(function () use ($itemData, $tagIds, $taskData) {
            $itemData['status'] = $itemData['status'] ?? 'active';
            $itemData['source'] = $itemData['source'] ?? 'web';
            $item = $this->itemRepository->create($itemData);

            if (! empty($tagIds)) {
                $this->tagRepository->syncToItem($item, $tagIds);
            }

            if ($taskData !== null && isset($itemData['type']) && $itemData['type'] === ItemType::Task->value) {
                $this->taskRepository->create(array_merge($taskData, ['item_id' => $item->id]));
            }

            return $item->load(['tags', 'task']);
        });
    }

    /**
     * Update an item and optionally sync tags and task data.
     */
    public function updateItem(Item $item, array $itemData, array $tagIds = [], ?array $taskData = null): Item
    {
        return DB::transaction(function () use ($item, $itemData, $tagIds, $taskData) {
            $itemData['status'] = $itemData['status'] ?? 'active';
            $itemData['source'] = $itemData['source'] ?? 'web';
            $this->itemRepository->update($item, $itemData);

            if (array_key_exists('tags', $itemData) || $tagIds !== []) {
                $ids = $tagIds !== [] ? $tagIds : ($itemData['tags'] ?? []);
                $this->tagRepository->syncToItem($item, $ids);
            }

            if ($taskData !== null) {
                $task = $this->taskRepository->findByItemId($item->id);
                if ($task) {
                    $this->taskRepository->update($task, $taskData);
                } else {
                    $this->taskRepository->create(array_merge($taskData, ['item_id' => $item->id]));
                }
            }

            return $item->fresh(['tags', 'task']);
        });
    }

    /**
     * Mark an item as expired (status = expired).
     */
    public function expireItem(Item $item): Item
    {
        return $this->itemRepository->update($item, ['status' => 'expired']);
    }
}
