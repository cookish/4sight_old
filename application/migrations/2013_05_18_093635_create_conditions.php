<?php

class Create_Conditions {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('conditions', function($table) {
            // auto incremental id (PK)
            $table->increments('id');
            // varchar 32
            $table->string('name', 64);
            $table->string('abbreviation', 12)->nullable();
            $table->integer('default_priority')->nullable();

            // created_at | updated_at DATETIME
            $table->timestamps();
	    });

        Schema::create('conditions_people', function($table) {
            // auto incremental id (PK)
            $table->increments('id');

            $table->integer('condition_id')->unsigned();
            $table->foreign('condition_id')->references('id')->on('conditions')->on_update('cascade');
            $table->integer('person_id')->unsigned();
            $table->foreign('person_id')->references('id')->on('people')->on_update('cascade');

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
        Schema::drop('conditions_people');
        Schema::drop('conditions');
	}

}