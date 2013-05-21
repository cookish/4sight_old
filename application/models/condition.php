<?php

class Condition extends Eloquent {

    public function person() {
        return $this->has_many_and_belongs_to('Person');
    }

}