<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingStoreRequest;
use App\Models\Meeting;
use App\Models\User;
use App\Services\MeetingService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;


class MeetingController extends Controller
{
    public $meetingService;

    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $meetings = Meeting::with('userOne:id,name', 'userTwo:id,name')->latest('id')->get();

        return view('meetings.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $users = User::get(['id', 'name']);
        return view('meetings.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MeetingStoreRequest $request
     * @return RedirectResponse
     */
    public function store(MeetingStoreRequest $request): RedirectResponse
    {
        $output = false;
        try {
            DB::beginTransaction();

            $meeting = Meeting::create($request->validated() + [
                'user_id' => auth()->id()
            ]);

            $this->meetingService->createMeetingOnGoogleCalender($meeting);

            DB::commit();
            $output = true;
        } catch (\Exception|\error $error) {
            DB::rollBack();
        }

        if ($output) {
            alert()->success('Created', 'Meeting Created Successfully');
            return redirect()->route('meetings.index');
        }
        alert()->success('Error', 'Something Went Wrong, Please Try Again');
        return redirect()->route('meetings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id): View
    {
        $meeting = Meeting::with('userOne:id,name', 'userTwo:id,name', 'user:id,name')->whereId($id)->firstOrFail();
        return view('meetings.show', compact('meeting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id): View
    {
        $meeting = Meeting::whereId($id)->firstOrFail();
        $users = User::get(['id', 'name']);
        return view('meetings.edit', compact('meeting', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MeetingStoreRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(MeetingStoreRequest $request, $id): RedirectResponse
    {
        $meeting = Meeting::whereId($id)->firstOrFail();

        $meeting->update($request->validated());

        alert()->success('Updated', 'Meeting Updated Successfully');
        return redirect()->route('meetings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $meeting = Meeting::whereId($id)->firstOrFail();

        $output = false;
        try {
            DB::beginTransaction();

            $meeting->delete();

            DB::commit();
            $output = true;
        } catch (\Exception|\error $error) {
            DB::rollBack();
        }

        if ($output) {
            alert()->success('added', 'Meeting Deleted Successfully');
            return redirect()->route('meetings.index');
        }
        alert()->error('error', 'Something went wrong');
        return redirect()->route('meetings.index');
    }
}
