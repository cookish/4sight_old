<?php

class SurgeryDataTypeOption extends Eloquent
{

	public $table = 'surgerydatatypeoptions';

	//relationship info
	public function person() {
		return $this->belongsTo('SurgeryDataType');
	}
}