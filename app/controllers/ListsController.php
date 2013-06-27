<?php
class ListsController extends BaseController {

     function getList($surgerytype_id) {
        return View::make('lists')
            ->with('surgeryTypeArray', array('All') + DB::table('surgerytypes')->lists('name','id'))
            ->with('people', Person::priorityList($surgerytype_id));
    }

}