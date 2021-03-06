<?php

use App\Enums\TrainingStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('tutor');
            $table->text('overview');
            $table->timestamp('start_time')->index();
            $table->timestamp('attendance_time')->nullable();
            $table->tinyInteger('status')->default(TrainingStatus::Pending)->index();
            $table->string('batch')->nullable()->index();
            $table->string('live_video')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

//            $table->unsignedBigInteger('trainer_id')->nullable();
//            $table->foreign('trainer_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainings');
    }
}
