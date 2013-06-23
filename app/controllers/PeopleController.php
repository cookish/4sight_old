<?php

class PeopleController extends BaseController {

    /**
     * Form has been submitted
     *
     * @return mixed
     */
    public function addPost() {
        $v = Person::validate(Input::all());
        if ($v->passes()) {

            $person_id = Person::updateOrInsert(new Person, Input::all());
            return Redirect::to('people/' . $person_id)
                    ->with('alert_details', 'Patient created');
        } else {
            return Redirect::to('people/add')->withInput()->withErrors($v);
        }
    }

    /**
     * Form has not yet been submitted
     *
     * @return mixed
     */
    public function addGet() {
        return View::make('people_add')
            ->nest('person_form', 'people_form', array('saveText' => 'Add patient', 'formTarget' => null));
    }

    public function listPeople() {

//        var_dump(Person::all());
//        die('moo');

        //if the user has entered a search term
        $search = Input::all('search');
        if (array_key_exists('search', $search)) {
            $search = $search['search'];
        } else {
            $search = null;
        }

        //array of words to include in the typeahead property of the search bar
        $typeahead = array();
        $people = Person::all();
        foreach ($people as $person) {
            $typeahead[] = $person->first_name;
            $typeahead[] = $person->surname;
            $typeahead[] = $person->hospital_number;
        }

        $orderby = array(array('surname', 'asc'), array('first_name', 'asc'));
        $view = View::make('people_list')
            ->with('people', Person::personSearch($search, $orderby))
            ->with('typeahead', $typeahead);
        if ($search) {
            return $view->with('search', $search);
        } else {
            return $view;
        }

    }

    public function detailsPost($person_id) {
        $input = Input::all();

        // the details have been updated
        if (isset($input['save'])) {
            $v = Person::validate(Input::all());
            if ($v->passes()) {
                Person::updateOrInsert(Person::find($person_id), Input::all());
                return Redirect::to('people/' . $person_id)
                    ->with('alert_details', 'Details saved');
            } else {
                return Redirect::to('people/' . $person_id)->withInput()->withErrors($v);
            }
        // saved surgery
        } elseif (isset($input['surgerySave']) || isset($input['surgeryComplete'])) {
            $input['person_id'] = $person_id;   // we know the person_id from routes
            $v = Surgery::validate($input);
            if ($v->passes()) {
                Surgery::updateSurgery($person_id, $input);
                return Redirect::to('people/' . $person_id)
                    ->with('alert_surgery', 'Details saved');
            } else {
                return Redirect::to('people/' . $person_id)->withInput()->withErrors($v);
            }
        // saved an appointment
        } elseif (isset($input['appointmentSave'])) {
            $input['person_id'] = $person_id;   // we know the person_id from routes
            $v = Appointment::validate($input);
            if ($v->passes()) {
                Appointment::updateOrInsert(Appointment::find($input['appointmentSave']), $input);
                return Redirect::to('people/' . $person_id);
            } else {
                return Redirect::to('people/' . $person_id)->withInput()->withErrors($v);
            }
         // added an appointment
        } elseif (isset($input['appointmentAdd'])) {
            $input['person_id'] = $person_id;   // we know the person_id from routes
            $v = Appointment::validate($input);
            if ($v->passes()) {
                Appointment::updateOrInsert(new Appointment(), $input);
                return Redirect::to('people/' . $person_id);
            } else {
                return Redirect::to('people/' . $person_id)->withInput()->withErrors($v);
            }
        //deleted an appointment
        } elseif (isset($input['appointmentDelete'])) {
            Appointment::find($input['appointmentDelete'])->delete();
            return Redirect::to('people/' . $person_id);
        }
    }



    public function detailsGet($person_id) {
        $person = Person::find($person_id);
        if ($person) {
            $surgery = $person->surgery;
        }
        if (!isset($surgery)) {
            $surgery = new Surgery();
        }
        return View::make('people_details')
            ->with('person', $person)
            ->with('surgery', $surgery)
            ->nest('person_form', 'people_form', array(
                'saveText' => 'Save changes',
                'formTarget' => null,
                'personData' => Person::find($person_id),
            ));
    }
}