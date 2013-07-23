<?php

class Surgery extends Eloquent
{
    //relationship info
    public function person() {
        return $this->belongsTo('Person');
    }

    public function surgerytype() {
        return $this->belongsTo('Surgerytype');
    }

    public function surgerydata() {
        return $this->hasMany('Surgerydata');
    }

    public static $formFields = array(
        'surgerytype_id',
        'date',
        'completed',
        'eyes',
        'ward',
        'surgery_notes',
        'outcome'
    );

    public static $outcomes = array(
        'completed'=>'Completed',
        'cancelled'=>'Cancelled',
        'complicated'=>'Complicated'
    );


    //validation rules required from Person::validateNew. $surgeryComplete means post-op data is needed
    public static function getValidateRules($input, $surgeryComplete=false) {
        $rules = array();
        $surgeryType = SurgeryType::find($input['surgerytype_id'])->first();

        //set up blank rules array
        foreach ($surgeryType->surgerydatatypes as $surgeryDataType) {
            $rules[$surgeryDataType->name.'_left'] = '';
            $rules[$surgeryDataType->name.'_right'] = '';
        }

        $rules['surgerytype_id'] = 'required';
        $rules['biometry_left'] = 'numeric';
        $rules['biometry_right'] = 'numeric';
        $rules['outcome'] = 'in:' . implode(',',array_keys(Surgery::$outcomes));
        $rules['eyes'] = 'in:L,R,L&R|required';

        // if surgeryComplete set, then the outcome field is required
        if (isset($input['surgeryComplete'])) {
            $rules['outcome'] .= '|required';
        }
        if (isset($input['surgerytype_id']) && isset($input['eyes'])) {
            if ($input['surgerytype_id']) {
                foreach ($surgeryType->surgerydatatypes as $surgeryDataType) {
                    if ($surgeryComplete || !$surgeryDataType->post_surgery) {
                        if ($input['eyes'] == 'L') {
                            $rules[$surgeryDataType->name . '_left'].= '|required';
                        }
                        if ($input['eyes'] == 'R') {
                            $rules[$surgeryDataType->name . '_right'].= '|required';
                        }
                        if ($input['eyes'] == 'L&R') {
                            $rules[$surgeryDataType->name . '_left'].= '|required';
                            $rules[$surgeryDataType->name . '_right'].= '|required';
                        }

                    }
                }
            }
        }
        return $rules;
    }


    public static function validate($input) {
        $rules = Surgery::getValidateRules($input);
        return Validator::make($input, $rules);
    }


    /**
     * @param $person_id
     * @param $input
     * @return integer
     *
     * Updates surgery details. Creates a new surgery record if none is found for person_id
     */
    public static function updateSurgery($person_id, $input) {

        //create a new surgery if none exists
        $surgery_id = false;
        $surgery = null;
        if (isset($input['surgerySave'])) $surgery_id = $input['surgerySave'];
        elseif (isset($input['surgeryComplete'])) $surgery_id = $input['surgeryComplete'];
        if ($surgery_id) $surgery = Surgery::find($surgery_id);
        if (!$surgery) {
            $surgery = new Surgery();
        }
        foreach (Surgery::$formFields as $field) {
            if (isset($input[$field])) {
                $surgery->{$field} = (($input[$field]) ? $input[$field] : null);
            }
        }
        if (isset($input['surgeryComplete'])) {
            $surgery->completed = true;
        }
        $surgery->person_id = $person_id;
        $surgery->save();

        //now, update the surgery data
        foreach (Surgerydatatype::all() as $surgeryDataType) {
            if (isset($input[$surgeryDataType->name.'_left'])) {
                $surgeryData = new SurgeryData();
                $surgeryData->eye = 'L';
                $surgeryData->value = $input[$surgeryDataType->name.'_left'];
                $surgeryData->surgery_data_type_id = $surgeryDataType->id;
                $surgery->surgerydata()->save($surgeryData);
            }
            if (isset($input[$surgeryDataType->name.'_right'])) {
                $surgeryData = new SurgeryData();
                $surgeryData->eye = 'R';
                $surgeryData->value = $input[$surgeryDataType->name.'_right'];
                $surgeryData->surgery_data_type_id = $surgeryDataType->id;
                $surgery->surgerydata()->save($surgeryData);
            }
        }

        return $surgery->id;
    }


    /**
     * Returns a list of patients without operations scheduled,
     * in order of grade then "date booked"
     *
     */

    public static function patientsToSchedule() {
        $ret = Person::all();

        return $ret->get();
    }

}