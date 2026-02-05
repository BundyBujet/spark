<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\TagRepository;

class TagService
{
    public function __construct(
        protected TagRepository $repository
    ) {}

    public function createTag(array $data): Tag
    {
        return $this->repository->create($data);
    }

    public function updateTag(Tag $tag, array $data): Tag
    {
        return $this->repository->update($tag, $data);
    }

    public function deleteTag(Tag $tag): bool
    {
        return $this->repository->delete($tag);
    }
}
