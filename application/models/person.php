<?php

class Person extends Eloquent
{
    public function appointments() {
        return $this->has_many_and_belongs_to('Appointmenttype', 'appointments')
            ->with('date')
            ->with('notes');
    }

    public function conditions() {
        return $this->has_many_and_belongs_to('Condition');
    }

    public static function all_search($search_string = null, $orderby = null) {

        if ($search_string) {
            $ret = Person::where('first_name', 'ilike', "%$search_string%")
                ->or_where('surname', 'ilike', "%$search_string%")
                ->or_where('id_number', 'ilike', "%$search_string%");
        } else {
            $ret = Person::select();
        }

        foreach ($orderby as $order) {
            $ret->order_by($order[0], $order[1]);
        }
        return $ret->get();
    }

    public static function update($person_id, $update = null) {

        if ($update) {
//            die( $person_id);
            $person = Person::find($person_id);
            foreach ($update as $key => $value) {
                if ($key != 'save')
                    $person->{$key} = $value;
            }
        }
        $person->save();
    }
}