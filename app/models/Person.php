<?php

class Person extends Eloquent
{


    public static $formInfo = array(
        'first_name' => array('type'=>'text', 'label' => 'First name', 'required'=> true),
        'surname' => array('type'=>'text', 'label' => 'Surname', 'required'=> true),
        'hospital_number' => array('type'=>'text', 'label' => 'Hospital number', 'required'=> true),
        'gender' => array('type'=>'dropdown', 'label' => 'Gender',
            'options' => array('male' => 'Male','female' => 'Female')),
        'grade' => array('type'=>'dropdown', 'label' => 'Grade',
            'options' => array(1 => '1', 2 => '2', 3 => '3', 4 => '4')),
        'date_booked' => array('type'=>'timestamp', 'label' => 'Date Booked', 'required'=> true),
        'date_of_birth' => array('type'=>'timestamp', 'label' => 'Date of birth'),
        'phone_1' => array('type'=>'text', 'label' => 'Phone 1'),
        'phone_2' => array('type'=>'text', 'label' => 'Phone 2'),
        'contact_history' => array('type'=>'textarea', 'label' => 'Contact history'),
        'short_notice' => array('type'=>'dropdown', 'label' => 'Short notice',
            'options' => array('yes' => 'Yes', 'no'=> 'No')),
        'cancellation_notes' => array('type'=>'textarea', 'label' => 'Cancellation notes')
    );




    public function appointments() {
        return $this->hasMany('Appointment');
    }

    public function surgery() {
        return $this->hasOne('Surgery');
    }

    /**
     * Returns people matching name, surname or hospital number
     */
    public static function personSearch($search_string = null, $orderby = null) {

        if ($search_string) {
            $ret = Person::where('first_name', 'ilike', "%$search_string%")
                ->orWhere('surname', 'ilike', "%$search_string%")
                ->orWhere('hospital_number', 'ilike', "%$search_string%");
        } else {
            $ret = Person::select();
        }

        foreach ($orderby as $order) {
            $ret->orderBy($order[0], $order[1]);
        }
        return $ret->get();
    }


    public static function validate($input) {
        $rules = array(
            'first_name' => 'required',
            'surname' => 'required',
            'hospital_number' => 'required',
            'grade' => 'integer|min:0|max:4',
            'date_booked' => 'required',
            'gender' => 'in:male,female,0',
            'short_notice' => 'in:yes,no,0',
        );

        return Validator::make($input, $rules);

    }

    public static function updateOrInsert($person, $input) {

        foreach (Person::$formInfo as $field => $notUsed) {
            if (isset($input[$field])) {
                $person->{$field} = (($input[$field] !== '') ? $input[$field] : null);
            }
        }

        $person->save();

        return $person->id;


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