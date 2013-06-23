<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();


		$this->call('PeopleTableSeeder');
        $this->command->info('People table seeded!');
    }


}

class PeopleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('people')->delete();
        $firstnames = array('Fred', 'Joe', 'Bob', 'Jordan', 'Precious', 'Lindi', 'Samuel');
        $surnames = array('Brown', 'Smith', 'Mavundla', 'Bloggs', 'Dlamini', 'Jackson', 'Fredericks');
        $hospitalnumbers = array('12345432', '4546532', '3426562', '3246', '348264', '7469301', '38523');
        $grades = array('1', '4', NULL, '3', NULL, '1', '1');
        $date_booked = array('21 June 2012', '23 July 2012', '3 May 2012', '29 December 2012', '23 April 2013',
            '16 June 2015', '2 Feb 2014');
        foreach ($firstnames as $key=>$name) {
            People::create(array('firstname' => $firstnames[$key], 'surname' => $surnames[$key],
                'hospital_number' => $hospitalnumbers[$key], 'grade' => $grades[$key],
                'date_booked' => $date_booked[$key]));
        }

    }

}
