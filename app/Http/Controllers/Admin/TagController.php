<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Models\Tag;
use App\Repositories\TagRepository;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TagController extends Controller
{
    public function __construct(
        protected TagService $service,
        protected TagRepository $repository
    ) {}

    public function index(): View
    {
        $tags = $this->repository->list();

        return view('admin.tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('admin.tags.create');
    }

    public function store(TagStoreRequest $request): RedirectResponse
    {
        try {
            $this->service->createTag($request->validated());

            return redirect()->route('tags.index')
                ->with('success', __('TAGS_CREATED'));
        } catch (\Throwable $e) {
            Log::error('Tag store failed', ['exception' => $e->getMessage()]);

            return redirect()->back()
                ->withInput()
                ->with('error', __('TAGS_ERROR'));
        }
    }

    public function show(Tag $tag): View
    {
        $tag->load('items');

        return view('admin.tags.show', compact('tag'));
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(TagUpdateRequest $request, Tag $tag): RedirectResponse
    {
        try {
            $this->service->updateTag($tag, $request->validated());

            return redirect()->route('tags.index')
                ->with('success', __('TAGS_UPDATED'));
        } catch (\Throwable $e) {
            Log::error('Tag update failed', ['exception' => $e->getMessage()]);

            return redirect()->back()
                ->withInput()
                ->with('error', __('TAGS_ERROR'));
        }
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $this->service->deleteTag($tag);

        return redirect()->route('tags.index')
            ->with('success', __('SUCCESS'));
    }
}
