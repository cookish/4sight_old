<?php
// application/controllers/account.php
class People_Controller extends Base_Controller {

    public function action_list() {

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
            $typeahead[] = $person->id_number;
        }

        $orderby = array(array('surname', 'asc'), array('first_name', 'asc'));
        return View::make('people_list')
            ->with('people', Person::all_search($search, $orderby))
            ->with('typeahead', $typeahead);

    }

    public function action_details($person_id) {
        $update = Input::get();
        if (sizeof($update) > 0) {
//            print_r($update);
//            die();
            Person::update($person_id, $update);
        }
        return View::make('people_details')
            ->with('person', Person::find($person_id));
    }
}