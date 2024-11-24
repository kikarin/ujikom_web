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
        Schema::table('photos', function (Blueprint $table) {
            $table->string('title')->after('id'); // Menambahkan kolom title setelah id
            $table->text('description')->nullable()->after('title'); // Menambahkan kolom description setelah title
        });
    }
    
    public function down()
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('description');
        });
    }
    
};
