<?php
use Carbon\Carbon;

class ListsController extends BaseController {


	function listsGetPost($type = 'surgery') {
		$date = Input::get('listDate', $date = Carbon::parse('now')->toDateString());
		$theatre = Input::get('theatre', 'All');
		$people = $this->getListPeople($type, $date, $theatre);

		$currentListName = '';
		if ($type == 'surgery') {
			$currentListName = 'Surgery';
		} else {
			$currentListName = ucfirst(Appointmenttype::find($type)->name);
		}

		return View::make('lists')
			->with('people', $people->paginate(20))
			->with('currentList', $type)
			->with('currentListName', $currentListName)
			->with('theatre', $theatre)
			->with('listDate', $date)
			->with('theatres', array_merge(array('All'), Surgery::$theatres));
	}


	function getListPeople($type, $date, $theatre) {
		$people = NULL;
		$appointmentTypes = DB::table('appointmenttypes')->lists('id');
		if ($type == 'surgery') {
			$people = Person::getSurgeryList($date, $theatre);
		} elseif (in_array($type, $appointmentTypes)) {
			$people = Person::getAppointmentList($type, $date);
		} else {
			App::abort(404);
		}
		return $people;
	}


}