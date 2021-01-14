<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repo_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('repo_name');
            $table->string('owner');
            $table->boolean('is_progress')->default(false);
            $table->string('repo_fork_url')->nullable();
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
        Schema::dropIfExists('repo_user');
    }
}
