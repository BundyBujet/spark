<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ItemRepository
{
    public function list(array $filters = [], int $perPage = 30): LengthAwarePaginator
    {
        $query = Item::query()->orderByDesc('created_at');

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }

        if (! empty($filters['tag_id'])) {
            $query->whereHas('tags', fn ($q) => $q->where('tags.id', $filters['tag_id']));
        }

        if (isset($filters['expired'])) {
            if ($filters['expired']) {
                $query->whereNotNull('expires_at')->where('expires_at', '<', now());
            } else {
                $query->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()));
            }
        }

        if (isset($filters['expiring_soon']) && $filters['expiring_soon']) {
            $query->whereNotNull('expires_at')
                ->where('expires_at', '>=', now())
                ->where('expires_at', '<=', now()->addDays(7));
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): ?Item
    {
        return Item::find($id);
    }

    public function create(array $data): Item
    {
        return Item::create($data);
    }

    public function update(Item $item, array $data): Item
    {
        $item->update($data);

        return $item->fresh();
    }

    public function delete(Item $item): bool
    {
        return $item->delete();
    }

    /**
     * Items that have already passed their expiration date.
     *
     * @return Collection<int, Item>
     */
    public function getExpiredItems(): Collection
    {
        return Item::query()
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->get();
    }

    /**
     * Items that expire within the next N days (configurable).
     *
     * @return Collection<int, Item>
     */
    public function getExpiringSoonItems(int $days = 7): Collection
    {
        return Item::query()
            ->whereNotNull('expires_at')
            ->where('expires_at', '>=', now())
            ->where('expires_at', '<=', now()->addDays($days))
            ->get();
    }
}
