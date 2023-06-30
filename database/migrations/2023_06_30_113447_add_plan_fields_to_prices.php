<?php

use App\Transfers\PlanId;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->after('price', function (Blueprint $table) {
                $table->integer('plan_id')->default(PlanId::BUSINESS);
            });
        });
    }

    public function down(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->dropColumn('plan_id');
        });
    }
};
