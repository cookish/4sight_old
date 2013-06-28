<?php
class ListsController extends BaseController {

     function getList($surgerytype_id, $scheduled) {
        if ($scheduled == 'today') {
            $people = Person::priorityList($surgerytype_id, 'today');
        }
        elseif ($scheduled == 'scheduled') {
            $people = Person::priorityList($surgerytype_id, 'scheduled');
        } elseif ($scheduled == 'notscheduled') {
            $people = Person::priorityList($surgerytype_id, 'notscheduled');
        }
        return View::make('lists')
            ->with('surgeryTypeArray', array('All') + DB::table('surgerytypes')->lists('name','id'))
            ->with('people', $people->paginate(20))
            ->with('current_surgerytype', $surgerytype_id)
            ->with('current_list',$scheduled);
    }

}