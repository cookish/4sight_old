<?php

class Appointmenttype extends Eloquent {


    public function person() {
        return $this->has_many_and_belongs_to('Person', 'appointments');
    }

}