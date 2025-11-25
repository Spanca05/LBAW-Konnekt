<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('application', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_seeker_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jobpost_id')->constrained('jobpost')->onDelete('cascade');
            $table->text('motivation')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->unique(['jobpost_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('application');
    }
};
