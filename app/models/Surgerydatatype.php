<?php

class SurgeryDataType extends Eloquent
{
    public $table = 'surgerydatatypes';

	public function surgerydatatypeoptions() {
		return $this->hasMany('SurgeryDataTypeOption');
	}
}