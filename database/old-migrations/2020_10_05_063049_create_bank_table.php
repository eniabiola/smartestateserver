<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateBankTable extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('banks', function (Blueprint $table) {
              $table->bigIncrements('id');
              $table->string('name', 191)->unique();
              $table->string('bank_code', 5)->unique();
              $table->string('sort_code', 10)->nullable();
              $table->timestamps();
              $table->softDeletes();
          });
      }

      /**
       * Reverse the migrations.
       *
       * @return void
       */
      public function down()
      {
          Schema::dropIfExists('banks');
      }
  }
