<?php

namespace App\Services;

use App\Models\Meeting;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;


class MeetingService {
    public function createMeetingOnGoogleCalender(Meeting $meeting)
    {
        $meeting->load([
            'user:id,name',
            'userTwo:id,name,email',
            'userOne:id,name,email'
        ]);

        $event = new Event;

        $startDateTime = Carbon::parse($meeting->meeting_date . ' ' . $meeting->meeting_time, 'UTC');


        $event->name = 'New Meeting';
        $event->description = $meeting->subject;
        $event->startDateTime = $startDateTime;
        $event->endDateTime = $startDateTime->addDay();
//
//        $event->addAttendee([
//            'email' => $meeting->userOne->email,
//            'name' => $meeting->userOne->name,
//            'comment' => 'Attendee One',
//            'responseStatus' => 'needsAction',
//        ]);
//
//        $event->addAttendee([
//            'email' => $meeting->userTwo->email,
//            'name' => $meeting->userTwo->name,
//            'comment' => 'Attendee Two',
//            'responseStatus' => 'needsAction',
//        ]);

        //$event->addMeetLink();
        $event->save();

    }


}
