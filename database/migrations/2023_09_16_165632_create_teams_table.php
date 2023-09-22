<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->foreignId('owner_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('team_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unique(['team_id', 'user_id']);
            $table->timestamps();
        });

        Schema::table('dashboards', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('user_id')->constrained()->cascadeOnDelete();
        });

        Schema::table('triggers', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('user_id')->constrained()->cascadeOnDelete();
        });

        \Illuminate\Support\Facades\Artisan::call('app:migrate:models-to-teams');

        Schema::table('dashboards', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->foreignId('team_id')->nullable(false)->change();
        });

        Schema::table('triggers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->foreignId('team_id')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');

        Schema::dropIfExists('team_user');

        Schema::table('dashboards', function (Blueprint $table) {
            $table->dropConstrainedForeignId('team_id');
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::table('triggers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('team_id');
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });
    }
};
