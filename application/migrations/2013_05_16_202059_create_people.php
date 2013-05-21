<?php

class Create_People {

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
            $table->integer('priority');
            $table->date('waiting_since');
            $table->string('middle_names', 64)->nullable();
            $table->string('email', 320)->nullable();
            $table->string('cell_phone', 15)->nullable();
            $table->string('work_phone', 15)->nullable();
            $table->string('home_phone', 128)->nullable();
            $table->string('address', 128)->nullable();
            $table->string('id_number', 128)->nullable();
            $table->string('passport_number', 128)->nullable();

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