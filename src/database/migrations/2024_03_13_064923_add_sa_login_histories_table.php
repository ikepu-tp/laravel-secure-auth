<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sa_login_histories', function (Blueprint $table) {
            $table->id();
            $table->uuid('loginId')->unique()->index();
            $table->string('user_id')->index();
            $table->string('guard');
            $table->ipAddress("ip_address");
            $table->text("user_agent");
            $table->string("device");
            $table->string("browser");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_login_histories');
    }
};