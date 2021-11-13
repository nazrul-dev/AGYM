<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->json('customers')->nullable();
            $table->json('orders')->nullable();
            $table->foreignId('user_id');
            $table->integer('member_id')->unsigned()->nullable();
            $table->string('invoice');
            $table->double('change')->default(0);
            $table->double('amount');
            $table->double('discount')->nullable();
            $table->double('total');
            $table->double('paid');
            $table->enum('paid_status', ['fullypaid', 'paylater', 'lunas']);
            $table->timestamp('due_date')->nullable();
            $table->enum('type', ['renew_member', 'new_member', 'sale', 'cashout', 'cashin', 'rent']);
            $table->text('notice')->nullable();
            $table->enum('cashflow', ['in', 'out'])->default('in');
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
        Schema::dropIfExists('transactions');
    }
}
