<?php

namespace App\Repositories;

use App\Models\WeeklyReport;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class WeeklyReportRepository
{
    public function create(array $data): WeeklyReport
    {
        return WeeklyReport::create($data);
    }

    /**
     * @return Collection<int, WeeklyReport>
     */
    public function list(): Collection
    {
        return WeeklyReport::query()->orderByDesc('period_start')->get();
    }

    public function listPaginated(int $perPage = 30): LengthAwarePaginator
    {
        return WeeklyReport::query()->orderByDesc('period_start')->paginate($perPage);
    }

    public function forPeriod(string $periodStart, string $periodEnd): ?WeeklyReport
    {
        return WeeklyReport::query()
            ->where('period_start', $periodStart)
            ->where('period_end', $periodEnd)
            ->first();
    }
}
