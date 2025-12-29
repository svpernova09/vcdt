<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToDownloads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $indexes = collect(Schema::getIndexes('downloads'))->pluck('name');

        Schema::table('downloads', function (Blueprint $table) use ($indexes) {
            if (! $indexes->contains('downloads_downloads_index')) {
                $table->index('downloads');
            }
            if (! $indexes->contains('downloads_created_at_index')) {
                $table->index('created_at');
            }
        });
    }
}
