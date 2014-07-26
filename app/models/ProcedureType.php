<?php

class ProcedureType extends Eloquent
{
    public function procedure_data_type() {
        return $this->belongsToMany('ProcedureDataType', 'procedure_data_type_procedure_type');
    }
}