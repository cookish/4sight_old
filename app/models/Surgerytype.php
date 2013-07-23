<?php

class SurgeryType extends Eloquent
{
    public $table = 'surgerytypes';

    public function surgerydatatypes() {
        return $this->belongsToMany('Surgerydatatype', 'surgerydataneeded');
    }
}