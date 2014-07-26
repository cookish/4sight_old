<?php

class Booking extends Eloquent {

    public function booking_type() {
        return $this->belongsTo('BookingType');
    }

	public function surgery() {
		return $this->belongsTo('Surgery');
	}

	public function theatre() {
		return $this->belongsTo('Theatre');
	}

	public function person() {
        return $this->belongsTo('Person');
    }


    public static function validate($input) {
        $rules = array(
            'date' => 'required'
        );

        return Validator::make($input, $rules);

    }

    public static function updateOrInsert($appointment, $input) {

        $appointment->notes = $input['notes'];
        $appointment->date = $input['date'];
        $appointment->appointmenttype_id = $input['appointmenttype_id'];
        $appointment->person_id = $input['person_id'];
        $appointment->save();
    }

}