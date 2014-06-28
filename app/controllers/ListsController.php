<?php
class ListsController extends BaseController {

	function getList($type = 'surgery') {
		$people = NULL;
		$appointmentTypes = DB::table('appointmenttypes')->lists('id');
		if ($type == 'surgery') {
			$people = Person::getSurgeryList();
		} elseif (in_array($type, $appointmentTypes)) {
			$people = Person::getAppointmentList($type);
		} else {
			App::abort(404);
		}
		return View::make('lists')
			->with('people', $people->paginate(20))
			->with('currentList', $type);
	}
}