<?php

class ProcedureData extends Eloquent
{
    public function procedure_data_type() {
        return $this->belongsTo('ProcedureDataType');
    }
}