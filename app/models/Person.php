<?php
use Carbon\Carbon;

class Person extends Eloquent
{

    //relationship info
    public function bookings() {
        return $this->hasMany('Booking');
    }

    public function surgeries() {
        return $this->hasMany('Surgery');
    }

	public function getAge() {
		if (!$this->date_of_birth) {
			return NULL;
		} else {
			$tz  = new DateTimeZone('Africa/Johannesburg');
			$age = DateTime::createFromFormat('Y-m-d', $this->date_of_birth, $tz)
				->diff(new DateTime('now', $tz))
				->y;
			return intval($age);
		}

	}

    //info for displaying a person form
    public static $formFields = array(
        'first_name',
        'surname',
        'hospital_number',
        'gender',
        'grade',
        'date_booked',
        'date_of_birth',
        'phone_1',
        'phone_2',
        'contact_history',
        'short_notice',
        'cancellation_notes',
    );



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
        return $ret;
    }




	public static function getSurgeryList($date, $theatre) {

		$start = Carbon::parse($date)->hour(0)->minute(0)->second(0);
		$end = Carbon::parse($date)->hour(23)->minute(59)->second(59);

		if ($theatre == 'All') {
			return Person::with('surgeries')
				->whereHas('surgeries',function($query) use ($date, $start, $end)
				{
					$query->whereBetween('date', [$start, $end]);
				});
		} else {
			return Person::with('surgeries')
				->whereHas('surgeries',function($query) use ($theatre, $date, $start, $end)
				{
				$query->whereBetween('date', [$start, $end])
						->where('theatre', '=', $theatre);
				});
		}
//		return Person::with($withArray);
//		return Person::where('person_id', '=', 1);
	}

	public static function getBookingList($booking_type_id, $date = NULL) {
		if (is_null($date)) {
			$date = new DateTime();
		}

		return Person::with(array('surgeries','appointments'))
			->whereHas('bookings', function($query) use ($booking_type_id, $date)
			{
				$query->where('date', '=', $date)->where('booking_type_id', '=', $booking_type_id);
			});
	}


	/**
	 * @param Person $people
	 */
	public static function orderByPriority($people) {
		return $people
			->orderBy('grade', 'ASC NULLS LAST')
			->orderBy('date_booked', 'asc');
	}

    public static function getValidateRules() {
        $rules = array(
            'first_name' => 'required',
            'surname' => 'required',
            'hospital_number' => 'required',
            'grade' => 'integer|min:0|max:4',
            'date_booked' => 'required',
            'gender' => 'in:male,female|required',
            'short_notice' => 'in:yes,no,0',
        );
        return $rules;
    }

    public static function validate($input) {
        $rules = Person::getValidateRules();
        return Validator::make($input, $rules);
    }

    public static function validateNew($input) {
        $rules = array_merge(Person::getValidateRules(), Surgery::getValidateRules($input, false));
//        print_r($rules);
//        die();
        $v = Validator::make($input, $rules);

        return $v;
    }

    public static function updateOrInsert($person, $input) {

        foreach (Person::$formFields as $field) {
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