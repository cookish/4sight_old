<?php

class Person extends Eloquent
{
    public static $fieldList = array(
        "column_name",
        "id",
        "first_name",
        "surname",
        "hospital_number",
        "grade",
        "date_booked",
        "date_of_birth",
        "phone_1",
        "phone_2",
        "contact_history",
        "short_notice",
        "created_at",
        "updated_at"
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
            'grade' => 'required|integer|min:1|max:4',
            'date_booked' => 'required'
        );

        return Validator::make($input, $rules);

    }

    public static function updateOrInsert($person, $input) {

        foreach (Person::$fieldList as $field) {
            if (isset($input[$field])) {
                $person->{$field} = (($input[$field]) ? $input[$field] : null);
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