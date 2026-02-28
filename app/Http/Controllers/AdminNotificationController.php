<?php

namespace App\Http\Controllers;

use App\DataTables\AdminNotificationDataTable;
use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Repositories\NotificationRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;

class AdminNotificationController extends AppBaseController
{
    /** @var NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
        $this->middleware('adminfCheckAdmin');
    }

    /**
     * Display a listing of the Notification.
     */
    public function index(AdminNotificationDataTable $notificationDataTable)
    {
        return $notificationDataTable->render('admin_notifications.index');
    }

    /**
     * Show the form for creating a new Notification.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        return view('admin_notifications.create', compact('users'));
    }

    /**
     * Store a newly created Notification in storage.
     */
    public function store(CreateNotificationRequest $request)
    {
        $users = User::select('id', 'name')->get();

        if ($request->type == 1) {
            foreach ($users as $use) {
                $request->merge(['user_id' => $use->id]);
                $this->notificationRepository->create($request->all());
            }
        } else {
            $this->notificationRepository->create($request->all());
        }

        Flash::success('تم حفظ الإشعار بنجاح.');

        return redirect(route('sitemanagement.notifications.index'));
    }

    /**
     * Display the specified Notification.
     */
    public function show($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('الإشعار غير موجود');
            return redirect(route('sitemanagement.notifications.index'));
        }

        $users = User::pluck('name', 'id');
        return view('admin_notifications.show', compact('users'))->with('notification', $notification);
    }

    /**
     * Show the form for editing the specified Notification.
     */
    public function edit($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('الإشعار غير موجود');
            return redirect(route('sitemanagement.notifications.index'));
        }

        $users = User::pluck('name', 'id');
        return view('admin_notifications.edit', compact('users'))->with('notification', $notification);
    }

    /**
     * Update the specified Notification in storage.
     */
    public function update($id, UpdateNotificationRequest $request)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('الإشعار غير موجود');
            return redirect(route('sitemanagement.notifications.index'));
        }

        $notification = $this->notificationRepository->update($request->all(), $id);

        Flash::success('تم تحديث الإشعار بنجاح.');

        return redirect(route('sitemanagement.notifications.index'));
    }

    /**
     * Remove the specified Notification from storage.
     */
    public function destroy($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('الإشعار غير موجود');
            return redirect(route('sitemanagement.notifications.index'));
        }

        $this->notificationRepository->delete($id);

        Flash::success('تم حذف الإشعار بنجاح.');

        return redirect(route('sitemanagement.notifications.index'));
    }
}
