<?php

use Illuminate\Database\Migrations\Migration;

class CreateAppointments extends Migration {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {

	    Schema::create('booking_types', function($table) {
		    $table->increments('id');
		    $table->string('name', 64);
	    });

        Schema::create('bookings', function($table) {
            // auto incremental id (PK)
            $table->increments('id');

	        $table->integer('booking_type_id')->unsigned()->references('id')->on('booking_types');
            $table->integer('person_id')->unsigned()->references('id')->on('people');
	        $table->integer('surgery_id')->unsigned()->references('id')->on('surgeries');
	        $table->date('date');
	        $table->string('doctor', 64)->nullable();
            $table->text('notes')->nullable();
	        $table->boolean('concluded')->default(false);

            // created_at | updated_at DATETIME
            $table->timestamps();
        });

    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bookings');
	    Schema::drop('bookings_types');
    }

}