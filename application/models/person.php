<?php

class Person extends Eloquent
{
    public function appointments() {
        return $this->has_many('Appointment');
    }

    public function surgery() {
        return $this->has_one('Surgery');
    }

    public static function all_search($search_string = null, $orderby = null) {

        if ($search_string) {
            $ret = Person::where('first_name', 'ilike', "%$search_string%")
                ->or_where('surname', 'ilike', "%$search_string%")
                ->or_where('hospital_number', 'ilike', "%$search_string%");
        } else {
            $ret = Person::select();
        }

        foreach ($orderby as $order) {
            $ret->order_by($order[0], $order[1]);
        }
        return $ret->get();
    }


    public static function validate($input) {
        $rules = array(
            'first_name' => 'required',
            'surname' => 'required',
            'hospital_number' => 'required',
            'grade' => 'required|integer|min:1|max:4'
//            'date_booked' => 'required'
        );

        return Validator::make($input, $rules);

    }

    public static function updateOrInsert($person, $input) {

        foreach ($input as $key => $value) {
            if ($key != 'save') {
                $person->{$key} = (($value) ? $value : null);
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