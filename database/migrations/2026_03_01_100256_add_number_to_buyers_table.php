<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
if (!Schema::hasColumn('buyers', 'number')) {
    $table->integer('number')->nullable();
}

}

public function down()
{
    Schema::table('buyers', function (Blueprint $table) {
        $table->dropColumn('number');
    });
}


};
