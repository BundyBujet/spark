<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemNotificationListRequest;
use App\Repositories\ItemNotificationRepository;
use Illuminate\View\View;

class ItemNotificationController extends Controller
{
    public function __construct(
        protected ItemNotificationRepository $repository
    ) {}

    public function index(ItemNotificationListRequest $request): View
    {
        $filters = $request->validated();
        $perPage = (int) (defined('COUNT') ? COUNT : 30);
        $notifications = $this->repository->list($filters, $perPage);

        return view('admin.item-notifications.index', compact('notifications'));
    }
}
