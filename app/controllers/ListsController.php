<?php
class ListsController extends BaseController {

     function getList($list) {
        return View::make('lists')
            ->with('list', $list)
            ->with('listArray', array('All') + DB::table('surgerytypes')->lists('name'));
    }

}