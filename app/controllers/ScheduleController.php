<?php
class ScheduleController extends BaseController {

    function getSchedule($surgerytype_id, $date = null) {

        $people_booked = Person::priorityList($surgerytype_id, 'today');
        return View::make('schedule')
            ->with('people', $people->paginate(20))
            ->with('surgeryTypeArray', DB::table('surgerytypes')->lists('name','id'))
            ->with('current_surgerytype', $surgerytype_id)
            ->with('current_date', $date);
    }
}