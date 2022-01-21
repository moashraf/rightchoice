<?php

namespace App\Http\Controllers;

use App\DataTables\NotificationDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Repositories\NotificationRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;
class NotificationController extends AppBaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the Notification.
     *
     * @param NotificationDataTable $notificationDataTable
     * @return Response
     */
    public function index(NotificationDataTable $notificationDataTable)
    {
        return $notificationDataTable->render('notifications.index');
    }

    /**
     * Show the form for creating a new Notification.
     *
     * @return Response
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        return view('notifications.create',compact('users'));
    }

    /**
     * Store a newly created Notification in storage.
     *
     * @param CreateNotificationRequest $request
     *
     * @return Response
     */
    public function store(CreateNotificationRequest $request)
    {
        $input = $request->all();

        $users = User::select('id' ,'name')->get();
          
        if($request->type == 1){
            foreach($users as $use){
                
             $request->merge(['user_id' => $use->id]);
             $notification = $this->notificationRepository->create($request->all());

            }
         }else{
            $notification = $this->notificationRepository->create($request->all());
         }

       

        Flash::success('Notification saved successfully.');

        return redirect(route('notifications.index'));
    }

    /**
     * Display the specified Notification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }
        $users = User::pluck('name', 'id');
        return view('notifications.show',compact('users'))->with('notification', $notification);
    }

    /**
     * Show the form for editing the specified Notification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        $users = User::pluck('name', 'id');
        return view('notifications.edit',compact('users'))->with('notification', $notification);
    }

    /**
     * Update the specified Notification in storage.
     *
     * @param  int              $id
     * @param UpdateNotificationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotificationRequest $request)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        if($request->type == 1){
            foreach($users as $use){
                
             $request->merge(['user_id' => $use->id]);
             $notification = $this->notificationRepository->update($request->all(), $id);

            }
         }else{
            $notification = $this->notificationRepository->update($request->all(), $id);
         }

        Flash::success('Notification updated successfully.');

        return redirect(route('notifications.index'));
    }

    /**
     * Remove the specified Notification from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        $this->notificationRepository->delete($id);

        Flash::success('Notification deleted successfully.');

        return redirect(route('notifications.index'));
    }
}
