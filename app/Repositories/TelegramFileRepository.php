<?php

namespace App\Repositories;

use App\Models\TelegramFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TelegramFileRepository
{
    public function list(array $filters = [], int $perPage = 30): LengthAwarePaginator
    {
        $query = TelegramFile::query()->orderByDesc('created_at');

        if (! empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): ?TelegramFile
    {
        return TelegramFile::find($id);
    }

    public function create(array $data): TelegramFile
    {
        return TelegramFile::create($data);
    }

    public function delete(TelegramFile $model): bool
    {
        return $model->delete();
    }
}
