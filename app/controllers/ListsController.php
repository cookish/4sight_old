<?php
class ListsController extends BaseController {

    function getList($list) {
        return View::make('lists')
            ->with('list', $list);
    }

}