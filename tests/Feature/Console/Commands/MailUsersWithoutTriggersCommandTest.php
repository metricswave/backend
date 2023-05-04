<?php

use App\Models\MailLog;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

$withOneTargetUserCreated = function (int $daysAgo) {
    $triggerType = TriggerType::factory()->create();
    Trigger::factory()
        ->for($triggerType)
        ->for(User::factory()->create(['created_at' => now()->subDays($daysAgo)]))
        ->create();
    User::factory()->create(['email' => 'target@mail.com', 'created_at' => now()->subDays($daysAgo)]);
    User::factory()->create(['email' => 'already-targeted@mail.com', 'created_at' => now()->subDays($daysAgo)]);
    MailLog::factory()->create(['mail' => 'already-targeted@mail.com', 'type' => 'user-without-triggers']);
    User::factory()->create(['created_at' => now()->subDays($daysAgo - 1)]);
    User::factory()->create(['created_at' => now()->subDays($daysAgo + 1)]);
};

it('mail users created three days ago that do not have any trigger', function () use ($withOneTargetUserCreated) {
    $daysAgo = 2;
    $withOneTargetUserCreated($daysAgo);

    artisan('app:mail-users-without-triggers-command', ['--days-ago' => $daysAgo])
        ->expectsOutputToContain('1 mails sent.')
        ->assertSuccessful();

    assertDatabaseCount('mail_logs', 2);
    assertDatabaseHas('mail_logs', ['mail' => 'target@mail.com', 'type' => 'user-without-triggers']);
});
