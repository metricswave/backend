<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->after('scopes', function (Blueprint $table) {
                $table->boolean('multiple')->default(false);
                $table->json('configuration')->nullable();
            });
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('multiple');
            $table->dropColumn('configuration');
        });
    }
};
