<?php

class Condition extends Eloquent {

    public function person() {
        return $this->hasManyAndBelongsTo('Person');
    }

}