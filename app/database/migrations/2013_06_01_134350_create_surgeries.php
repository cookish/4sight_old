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
            // determines which information is required for the surgery
            //group 1 requires a certain set, group 2 another. Null has no required info
            $table->integer('group')->nullable();

            // created_at | updated_at DATETIME
            $table->timestamps();
        });

        Schema::create('surgeries', function($table) {
            // auto incremental id (PK)
            $table->increments('id');
            $table->integer('person_id');
            $table->foreign('person_id')->references('id')->on('people')->on_update('cascade');
            $table->integer('surgerytype_id')->unsigned();
            $table->foreign('surgerytype_id')->references('id')->on('surgerytypes')->on_update('cascade');

            $table->string('date', 20)->nullable();
            $table->boolean('completed')->default(false);
            $table->string('eyes', 5)->nullable();

            $table->string('pre_op_va_left', 256)->nullable();
            $table->string('pre_op_va_right', 256)->nullable();
            $table->string('post_op_va_right', 256)->nullable();
            $table->string('post_op_va_left', 256)->nullable();
            $table->string('biometry_left', 256)->nullable();
            $table->string('biometry_right', 256)->nullable();
            $table->string('histological_outcome_left', 256)->nullable();
            $table->string('histological_outcome_right', 256)->nullable();
            $table->string('surgery_notes', 512)->nullable();
            $table->string('ward', 20)->nullable();
            $table->string('outcome', 12)->nullable();

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
        Schema::drop('surgeries');
        Schema::drop('surgerytypes');
    }

}