<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('fullname');
            $table->date('dob');
            $table->boolean('gender');
            $table->string('phone')->unique();
            $table->string('avatar')->default('assets/images/avatar_default.png');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_name');
            $table->timestamps();
        });

        Schema::create('majors', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('major_name');

            $table->timestamps();
        });

        Schema::create('course_major', function (Blueprint $table) {
            $table->integer('course_id')->unsigned();
            $table->string('major_id');

            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
        });

        Schema::create('classes', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('class_name');

            $table->integer('course_id')->unsigned();
            $table->string('major_id');

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('subject_name');
            $table->integer('total_time');
            $table->tinyInteger('test_type');
            $table->timestamps();
        });

        Schema::create('major_subject', function (Blueprint $table) {
            $table->string('major_id');
            $table->string('subject_id');

            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

            $table->primary(array('subject_id', 'major_id'));
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('fullname');
            $table->date('dob');
            $table->boolean('gender');
            $table->string('phone');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('status');
            $table->string('classes_id')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('classes_id')->references('id')->on('classes')->onDelete('cascade');
        });

        Schema::create('assignments', function (Blueprint $table) {
            $table->string('class_id');
            $table->string('subject_id');
            $table->string('lecturer_id');

            $table->foreign('lecturer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

            $table->timestamps();

            $table->primary(array('class_id', 'subject_id'));
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('lecturer_id');
            $table->string('subject_id');
            $table->string('class_id');
            $table->date('date');
            $table->time('time_start');
            $table->time('time_end');

            $table->foreign('lecturer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('attendance_details', function (Blueprint $table) {
            $table->string('attendance_id');
            $table->string('student_id');
            $table->tinyInteger('status');

            $table->foreign('attendance_id')->references('id')->on('attendances')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->timestamps();

            $table->primary(array('attendance_id', 'student_id'));
        });

        Schema::create('_sequence', function (Blueprint $table) {
            $table->text('seq_name');
            $table->text('seq_group');
            $table->unsignedBigInteger('seq_val');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('testing_schedules', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('class_id');
            $table->string('subject_id');
            $table->date('test_date');
            $table->tinyInteger('test_type');
            $table->time('time_start');
            $table->time('time_end');
            $table->string('lecturer_id');
            $table->tinyInteger('test_times');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('lecturer_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('test_results', function (Blueprint $table) {
            $table->string('subject_id');
            $table->string('student_id');
            $table->float('grade');
            $table->tinyInteger('test_type');
            $table->tinyInteger('test_times');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('majors');
        Schema::dropIfExists('coure_major');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('major_subject');
        Schema::dropIfExists('students');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('attendance_details');
        Schema::dropIfExists('_sequence');
        Schema::dropIfExists('testing_schedules');
        Schema::dropIfExists('test_result');
    }
}
