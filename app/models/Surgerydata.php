<?php

class SurgeryData extends Eloquent
{
    public $table = 'surgerydata';

    public function surgerydatatype() {
        return $this->belongsTo('Surgerydatatype');
    }
}