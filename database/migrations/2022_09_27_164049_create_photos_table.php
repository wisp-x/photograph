<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->nullable()->comment('相册')->constrained('albums')->nullOnDelete();
            $table->text('intro')->nullable()->comment('简介');
            $table->unsignedInteger('width')->default(0)->comment('宽');
            $table->unsignedInteger('height')->default(0)->comment('高');
            $table->unsignedDecimal('size')->default(0)->comment('大小(kb)');
            $table->string('filename', 255)->default('')->comment('文件原始名称');
            $table->string('pathname', 255)->default('')->comment('原图相对路径');
            $table->string('thumbnail_pathname', 255)->default('')->comment('缩略图相对路径');
            $table->string('md5', 32)->default('')->comment('md5');
            $table->string('sha1', 64)->default('')->comment('sha1');
            $table->unsignedInteger('views')->default(0)->comment('浏览量');
            $table->integer('weigh')->default(0)->comment('权重');
            $table->json('exif')->nullable()->comment('exif');
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
        Schema::dropIfExists('photos');
    }
};
