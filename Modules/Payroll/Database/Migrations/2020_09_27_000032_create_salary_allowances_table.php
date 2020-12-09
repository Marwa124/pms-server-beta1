<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAllowancesTable extends Migration
{
    public function up()
    {
        Schema::create('salary_allowances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('value');
        });
    }
}
