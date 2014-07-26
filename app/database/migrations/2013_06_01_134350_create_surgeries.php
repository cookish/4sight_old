<?php

use Illuminate\Database\Migrations\Migration;

class CreateSurgeries extends Migration {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('surgerytypes', function($table) {
            // auto incremental id (PK)
            $table->increments('id');

            $table->string('name', 32);

            // created_at | updated_at DATETIME
            $table->timestamps();
        });

        Schema::create('surgeries', function($table) {
            // auto incremental id (PK)
            $table->increments('id');
            $table->integer('person_id')->unsigned()->references('id')->on('people');
//            $table->integer('surgerytype_id')->unsigned()->references('id')->on('surgerytypes');

//            $table->date('date')->nullable();
            $table->enum('status', ['awaiting', 'completed', 'cancelled']);
            $table->enum('eye', ['L', 'R']);


            $table->text('notes')->nullable();


            // created_at | updated_at DATETIME
            $table->timestamps();
        });

        Schema::create('procedure_data_types', function($table) {
            // auto incremental id (PK)
            $table->increments('id');
            $table->string('name', 32);
            $table->string('label', 32);

            //whether the data field is only needed post surgery
            $table->boolean('post_surgery');

            // created_at | updated_at DATETIME
            $table->timestamps();
        });

        //pivot table for many-to-many relationship between surgerytypes and surgerydatatypes
        Schema::create('procedure_data_type_procedure_type', function($table) {
            // auto incremental id (PK)
            $table->increments('id');
            $table->integer('procedure_data_type_id')->unsigned()->references('id')->on('procedure_data_types');
            $table->integer('procedure_type_id')->unsigned()->references('id')->on('procedure_types');

            // created_at | updated_at DATETIME
//            $table->timestamps();
        });

        //pivot table for many-to-many relationship between surgerydatatypes and surgeries
        Schema::create('procedure_procedure_data_type', function($table) {
            // auto incremental id (PK)
            $table->increments('id');
            $table->integer('procedure_id')->unsigned()->references('id')->on('procedures');
            $table->integer('procedure_data_type_id')->unsigned()->references('id')->on('procedure_data_types');
            $table->string('value', 128);

            // created_at | updated_at DATETIME
            $table->timestamps();
        });

		//options for surgerydatatypes
//	    Schema::create('surgerydatatypeoptions', function($table) {
	    Schema::create('procedure_data_type_options', function($table) {
		    // auto incremental id (PK)
		    $table->increments('id');
		    $table->integer('procedure_data_type_id')->unsigned()->references('id')->on('procedure_data_types');
		    $table->string('value', 32);
		    $table->integer('listorder');


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
	    Schema::drop('procedure_data_type_options');
	    Schema::drop('procedure_procedure_data_type');
        Schema::drop('procedure_data_type_procedure_type');
        Schema::drop('procedure_data_types');
	    Schema::drop('surgeries');
        Schema::drop('surgerytypes');

    }

}