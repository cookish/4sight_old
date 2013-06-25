<?php

use Illuminate\Database\Migrations\Migration;

class CreatePeople extends Migration {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function($table) {
            // auto incremental id (PK)
            $table->increments('id');
            // varchar 32
            $table->string('first_name', 64);
            $table->string('surname', 64);
            $table->string('hospital_number', 64);
            $table->string('gender', 6)->nullable();
            $table->integer('grade')->nullable();
            $table->string('date_booked', 20);
            $table->timestamp('date_of_birth')->nullable();

            $table->string('phone_1', 20)->nullable();
            $table->string('phone_2', 20)->nullable();
            $table->boolean('short_notice')->nullable();
            $table->string('contact_history', 512)->nullable();
            $table->string('cancellation_notes', 512)->nullable();


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
        Schema::drop('people');
    }

}