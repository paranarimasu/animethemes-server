<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTelescopeEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('telescope_entries')) {
            Schema::table('telescope_entries', function (Blueprint $table) {
                $table->json('content')->change();
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
        if (Schema::hasTable('telescope_entries')) {
            Schema::table('telescope_entries', function (Blueprint $table) {
                $table->longText('content')->change();
            });
        }
    }
}