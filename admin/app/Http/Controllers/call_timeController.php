<?php

namespace App\Http\Controllers;

use App\DataTables\call_timeDataTable;
use App\Http\Requests;
use App\Http\Requests\Createcall_timeRequest;
use App\Http\Requests\Updatecall_timeRequest;
use App\Repositories\call_timeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class call_timeController extends AppBaseController
{
    /** @var  call_timeRepository */
    private $callTimeRepository;

    public function __construct(call_timeRepository $callTimeRepo)
    {
        $this->callTimeRepository = $callTimeRepo;
    }

    /**
     * Display a listing of the call_time.
     *
     * @param call_timeDataTable $callTimeDataTable
     * @return Response
     */
    public function index(call_timeDataTable $callTimeDataTable)
    {
        return $callTimeDataTable->render('call_times.index');
    }

    /**
     * Show the form for creating a new call_time.
     *
     * @return Response
     */
    public function create()
    {
        return view('call_times.create');
    }

    /**
     * Store a newly created call_time in storage.
     *
     * @param Createcall_timeRequest $request
     *
     * @return Response
     */
    public function store(Createcall_timeRequest $request)
    {
        $input = $request->all();

        $callTime = $this->callTimeRepository->create($input);

        Flash::success('Call Time saved successfully.');

        return redirect(route('callTimes.index'));
    }

    /**
     * Display the specified call_time.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $callTime = $this->callTimeRepository->find($id);

        if (empty($callTime)) {
            Flash::error('Call Time not found');

            return redirect(route('callTimes.index'));
        }

        return view('call_times.show')->with('callTime', $callTime);
    }

    /**
     * Show the form for editing the specified call_time.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $callTime = $this->callTimeRepository->find($id);

        if (empty($callTime)) {
            Flash::error('Call Time not found');

            return redirect(route('callTimes.index'));
        }

        return view('call_times.edit')->with('callTime', $callTime);
    }

    /**
     * Update the specified call_time in storage.
     *
     * @param  int              $id
     * @param Updatecall_timeRequest $request
     *
     * @return Response
     */
    public function update($id, Updatecall_timeRequest $request)
    {
        $callTime = $this->callTimeRepository->find($id);

        if (empty($callTime)) {
            Flash::error('Call Time not found');

            return redirect(route('callTimes.index'));
        }

        $callTime = $this->callTimeRepository->update($request->all(), $id);

        Flash::success('Call Time updated successfully.');

        return redirect(route('callTimes.index'));
    }

    /**
     * Remove the specified call_time from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $callTime = $this->callTimeRepository->find($id);

        if (empty($callTime)) {
            Flash::error('Call Time not found');

            return redirect(route('callTimes.index'));
        }

        $this->callTimeRepository->delete($id);

        Flash::success('Call Time deleted successfully.');

        return redirect(route('callTimes.index'));
    }
}
