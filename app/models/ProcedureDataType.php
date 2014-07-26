<?php

class ProcedureDataType extends Eloquent
{
    public function procedure_data_type_option() {
		return $this->hasMany('ProcedureDataTypeOption');
	}
}