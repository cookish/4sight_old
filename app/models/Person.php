<?php
use Carbon\Carbon;

class Person extends Eloquent
{

    //relationship info
    public function appointments() {
        return $this->hasMany('Appointment');
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

    /**
     * @param null $surgerytype The name of the surgery
     */
    public static function priorityList($surgerytype_id = null, $scheduled = 'today') {
        $ret = DB::table('people')
                ->select(DB::raw("*,
                        (select date from appointments
                            join appointmenttypes on (appointments.appointmenttype_id = appointmenttypes.id)
                            where person_id = people.id and appointmenttypes.name = 'Pre-op' order by date asc limit 1)
                        as preop_date,
                        (select date from appointments
                            join appointmenttypes on (appointments.appointmenttype_id = appointmenttypes.id)
                            where person_id = people.id and appointmenttypes.name = 'Post-op' order by date asc limit 1)
                        as postop_date"))
//                ->select(DB::raw("(select date from appointments
//                        join appointmenttypes on (appointments.appointmenttype_id = appointmenttypes.id)
//                        where person_id = people.id and appointmenttypes.name = 'preop' order by date asc limit 1) as
//                        preop_date"))
                ->join('surgeries', 'surgeries.person_id', '=', 'people.id')
                ->whereNull('outcome');
        if ($surgerytype_id) {
            $ret = $ret->where('surgerytype_id', '=', $surgerytype_id);
        }
        if ($scheduled == 'today') {
            $ret = $ret->where('surgeries.date', '=', DB::raw('now()::date'));
        } elseif ($scheduled == 'scheduled') {
            $ret = $ret->whereNotNull('surgeries.date')
                    ->orderBy('date');  //order by date of op, then priority
        } elseif ($scheduled == 'notscheduled') {
            $ret = $ret->whereNull('surgeries.date');
        }

        //order by priority
        $ret = $ret
                ->orderBy('grade', 'ASC NULLS LAST')
                ->orderBy('date_booked', 'asc');
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

	public static function getAppointmentList($appointmenttype_id, $date = NULL) {
		if (is_null($date)) {
			$date = new DateTime();
		}

		return Person::with(array('surgeries','appointments'))
			->whereHas('appointments', function($query) use ($appointmenttype_id, $date)
			{
				$query->where('date', '=', $date)->where('appointmenttype_id', '=', $appointmenttype_id);
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