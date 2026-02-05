<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskListRequest;
use App\Repositories\TaskRepository;
use Illuminate\View\View;

class TasksController extends Controller
{
    public function __construct(
        protected TaskRepository $repository
    ) {}

    public function index(TaskListRequest $request): View
    {
        $filters = $request->validated();
        $perPage = (int) (defined('COUNT') ? COUNT : 30);
        $items = $this->repository->listTaskItems($filters, $perPage);

        return view('admin.tasks.index', compact('items'));
    }
}
