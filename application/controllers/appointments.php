<?php
// application/controllers/account.php
class Appointments_Controller extends Base_Controller {

    function action_create() {
        $orderby = array();
        return View::make('appointments_create')
            ->with('people', Person::all_search(null, $orderby));
    }

}