<?php

class ProcedureDataTypeOption extends Eloquent
{

	//relationship info
	public function procedure_data_type() {
		return $this->belongsTo('ProcedureDataType');
	}
}