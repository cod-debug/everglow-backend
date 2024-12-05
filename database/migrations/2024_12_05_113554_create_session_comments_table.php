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
        Schema::create('session_comments', function (Blueprint $table) {
            $table->id();
            $table->enum("session_type", ["session-1", "session-2"]);
            $table->string("ip_address");
            $table->longText("comment");
            $table->timestamp('created_at')->useCurrent()->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->useCurrentOnUpdate()->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_comments');
    }
};
