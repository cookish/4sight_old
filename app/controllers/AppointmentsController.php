<?php
class AppointmentsController extends BaseController {

    function getCreate() {
        $orderby = array();
        return View::make('appointments_create')
            ->with('people', Person::personSearch(null, $orderby));
    }

}