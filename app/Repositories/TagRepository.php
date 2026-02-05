<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagRepository
{
    /**
     * @return Collection<int, Tag>
     */
    public function list(): Collection
    {
        return Tag::query()->withCount('items')->orderBy('name')->get();
    }

    public function find(int $id): ?Tag
    {
        return Tag::find($id);
    }

    public function findByName(string $name): ?Tag
    {
        return Tag::query()->where('name', $name)->first();
    }

    public function create(array $data): Tag
    {
        return Tag::create($data);
    }

    public function update(Tag $tag, array $data): Tag
    {
        $tag->update($data);

        return $tag->fresh();
    }

    public function delete(Tag $tag): bool
    {
        return $tag->delete();
    }

    /**
     * Sync tags for an item by tag IDs. Replaces existing pivot.
     */
    public function syncToItem(Item $item, array $tagIds): void
    {
        $item->tags()->sync($tagIds);
    }
}
