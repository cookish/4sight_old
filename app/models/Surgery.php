<?php

class Surgery extends Eloquent
{

    public static $formFields = array(
        'surgerytype_id',
        'date',
        'completed',
        'eyes',
        'ward',
        'pre_op_va_left',
        'pre_op_va_right',
        'post_op_va_right',
        'post_op_va_left',
        'biometry_left',
        'biometry_right',
        'histological_outcome_left',
        'histological_outcome_right',
        'surgery_notes'
    );


    public function person() {
        return $this->belongsTo('Person');
    }

    public function surgerytype() {
        return $this->belongsTo('Surgerytype');
    }

    public static function validate($input) {
        $rules = array(
            'eyes' => 'required',
            'surgerytype_id' => 'required',
            'date' => 'required',
            'biometry_left' => 'numeric',
            'biometry_right' => 'numeric',
        );
        if (isset($input['surgerytype_id']) && isset($input['eyes'])) {
            if ($input['surgerytype_id']) {
                $surgeryType = SurgeryType::find($input['surgerytype_id']);
                if ($surgeryType->group == '1' && ($input['eyes'] == 'L' || $input['eyes'] == 'L&R')) {
                    $rules['pre_op_va_left'] = 'required';
                    $rules['post_op_va_left'] = 'required';
                    $rules['biometry_left'] .= '|required';
                }
                if ($surgeryType->group == '1' && ($input['eyes'] == 'R' || $input['eyes'] == 'L&R')) {
                    $rules['pre_op_va_right'] = 'required';
                    $rules['post_op_va_right'] = 'required';
                    $rules['biometry_right'] .= '|required';
                }
                if ($surgeryType->group == '2' && ($input['eyes'] == 'L' || $input['eyes'] == 'L&R')) {
                    $rules['histological_outcome_left'] = 'required';
                }
                if ($surgeryType->group == '2' && ($input['eyes'] == 'R' || $input['eyes'] == 'L&R')) {
                    $rules['histological_outcome_right'] = 'required';
                }
            }
        }
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
        $surgery = Person::find($person_id)->surgery;
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