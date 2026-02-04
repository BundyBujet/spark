<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TelegramFileDownloadRequest;
use App\Http\Requests\TelegramFileListRequest;
use App\Http\Requests\TelegramFileUploadRequest;
use App\Models\TelegramFile;
use App\Repositories\TelegramFileRepository;
use App\Services\TelegramStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TelegramStorageController extends Controller
{
    public function __construct(
        protected TelegramStorageService $service,
        protected TelegramFileRepository $repository
    ) {
        $this->middleware('permission:Manage Telegram Storage');
    }

    public function index(TelegramFileListRequest $request): View
    {
        $filters = $request->validated();
        $perPage = (int) (defined('COUNT') ? COUNT : 30);
        $telegramFiles = $this->repository->list($filters, $perPage);

        return view('admin.telegram-storage.index', compact('telegramFiles'));
    }

    public function create(): View
    {
        return view('admin.telegram-storage.create');
    }

    public function store(TelegramFileUploadRequest $request): RedirectResponse
    {
        try {
            $this->service->uploadToStorageChannel(
                $request->file('file'),
                auth()->id()
            );
            return redirect()->route('telegram-storage.index')
                ->with('success', __('TELEGRAM_UPLOAD_SUCCESS'));
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Telegram storage upload failed', ['exception' => $e->getMessage()]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('TELEGRAM_UPLOAD_ERROR'));
        }
    }

    public function show(TelegramFile $telegramFile): View
    {
        return view('admin.telegram-storage.show', compact('telegramFile'));
    }

    public function download(TelegramFileDownloadRequest $request, TelegramFile $telegramFile): RedirectResponse
    {
        try {
            $url = $this->service->getSignedFileDownloadUrl($telegramFile);
            return redirect()->away($url);
        } catch (\Throwable $e) {
            Log::error('Telegram storage download failed', ['exception' => $e->getMessage()]);
            return redirect()->route('telegram-storage.index')
                ->with('error', __('TELEGRAM_UPLOAD_ERROR'));
        }
    }

    public function destroy(TelegramFile $telegramFile): RedirectResponse
    {
        $this->repository->delete($telegramFile);
        return redirect()->route('telegram-storage.index')
            ->with('success', __('SUCCESS'));
    }
}
