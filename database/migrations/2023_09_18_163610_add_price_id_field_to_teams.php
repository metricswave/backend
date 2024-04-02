<?php

use App\Models\Lead;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use MetricsWave\Teams\Team;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->foreignId('price_id')->nullable()->constrained('prices');
        });

        // Migrate price_id from leads to teams using owner email
        if (config('env') === 'production') {
            foreach (Team::all() as $team) {
                $lead = Lead::query()->where('email', $team->owner->email)->first();

                if (! $lead) {
                    continue;
                }

                $team->price_id = $lead->price_id;
                $team->save();
            }
        }
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['price_id']);
            $table->dropColumn('price_id');
        });
    }
};
