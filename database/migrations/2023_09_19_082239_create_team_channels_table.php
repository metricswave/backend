<?php

use App\Models\UserService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use MetricsWave\Channels\TeamChannel;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained();
            $table->foreignId('channel_id')->constrained();
            $table->json('data');
            $table->string('data_channel_id')->virtualAs("data->>'$.configuration.channel_id'")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $telegramServices = UserService::query()->where('service_id', 3);
        foreach ($telegramServices->get() as $telegramService) {
            $team = $telegramService->user->ownedTeams->first();
            TeamChannel::create([
                'team_id' => $team->id,
                'channel_id' => 1,
                'data' => $telegramService->service_data,
            ]);
        }

        $telegramServices->delete();
    }

    public function down(): void
    {
        Schema::dropIfExists('team_channels');
    }
};
