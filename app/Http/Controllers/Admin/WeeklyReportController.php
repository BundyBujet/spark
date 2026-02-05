<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\WeeklyReportRepository;
use Illuminate\View\View;

class WeeklyReportController extends Controller
{
    public function __construct(
        protected WeeklyReportRepository $repository
    ) {}

    public function index(): View
    {
        $perPage = (int) (defined('COUNT') ? COUNT : 30);
        $reports = $this->repository->listPaginated($perPage);

        return view('admin.weekly-reports.index', compact('reports'));
    }
}
