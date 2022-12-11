<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Movies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('movies')) {
            Schema::create('movies', function (Blueprint $table) {
                $table->integer("id");
                $table->string('title',100);
                $table->string('description',255);
                $table->float('rating', 3, 1); 	
                $table->text('image')->default("");
                $table->dateTime('created_at');
                $table->dateTime('updated_at')->nullable();

                $table->primary('id');	
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
