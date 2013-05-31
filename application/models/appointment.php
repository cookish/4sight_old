<?php

class Appointment extends Eloquent {

    public function appointmenttype() {
        return $this->belongs_to('Appointmenttype');
    }

    public function person() {
        return $this->belongs_to('Person');
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