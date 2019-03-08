<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('slug');

            // ->onDelete('RESTRICT'); by default - запрещает удаление внешних вещей(колонок)
            // ->onDelete('SET NULL'); установить в значение NULL
            // ->onDelete('CASCADE'); рекурсивно удалить все внешние вещи (улицы, деревни, дома, ...)
            $table->integer('parent_id')->nullable()->references('id')->on('regions')->onDelete('CASCADE');

            $table->timestamps();

            // всё это мы сделали, чтобы не только в PHP было ограничение по уникальности, но и БД была "умной", поддерживала нас
            // и не давала другим, неопытным разработчикам допустим через PhpMyAdmin вносить кривые правки
            $table->unique(['parent_id','slug']);
            $table->unique(['parent_id','name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
