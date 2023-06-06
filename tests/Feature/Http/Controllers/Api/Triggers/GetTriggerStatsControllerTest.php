<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use Carbon\Carbon;
use function Pest\Laravel\actingAs;

function values(): string
{
    return "762,visits:triggers_visits_day,6,2,,,2023-06-06 08:12:55,2023-06-06 08:12:58
47,visits:triggers_visits_day,6,2,,2023-05-05 00:00:00,2023-05-04 20:46:17,2023-05-04 21:09:57
66,visits:triggers_visits_day,6,6,,2023-05-06 00:00:00,2023-05-05 08:48:42,2023-05-05 20:13:35
103,visits:triggers_visits_day,6,9,,2023-05-07 00:00:00,2023-05-06 07:50:32,2023-05-06 20:32:05
129,visits:triggers_visits_day,6,3,,2023-05-08 00:00:00,2023-05-07 20:31:55,2023-05-07 23:08:14
152,visits:triggers_visits_day,6,2,,2023-05-09 00:00:00,2023-05-08 09:20:37,2023-05-08 12:30:04
168,visits:triggers_visits_day,6,5,,2023-05-10 00:00:00,2023-05-09 06:49:20,2023-05-09 17:17:39
192,visits:triggers_visits_day,6,10,,2023-05-11 00:00:00,2023-05-10 05:26:30,2023-05-10 13:30:05
246,visits:triggers_visits_day,6,4,,2023-05-13 00:00:00,2023-05-12 07:09:22,2023-05-12 14:17:03
260,visits:triggers_visits_day,6,5,,2023-05-14 00:00:00,2023-05-13 09:24:25,2023-05-13 21:25:47
316,visits:triggers_visits_day,6,2,,2023-05-16 00:00:00,2023-05-15 16:05:20,2023-05-15 19:00:14
335,visits:triggers_visits_day,6,3,,2023-05-17 00:00:00,2023-05-16 12:14:44,2023-05-16 17:24:48
350,visits:triggers_visits_day,6,3,,2023-05-18 00:00:00,2023-05-17 08:20:43,2023-05-17 17:24:47
380,visits:triggers_visits_day,6,5,,2023-05-19 00:00:00,2023-05-18 13:21:38,2023-05-18 13:36:24
395,visits:triggers_visits_day,6,1,,2023-05-20 00:00:00,2023-05-19 15:31:16,2023-05-19 15:31:16
429,visits:triggers_visits_day,6,2,,2023-05-22 00:00:00,2023-05-21 14:24:24,2023-05-21 14:25:14
463,visits:triggers_visits_day,6,8,,2023-05-23 00:00:00,2023-05-22 11:52:43,2023-05-22 13:04:06
534,visits:triggers_visits_day,6,1,,2023-05-27 00:00:00,2023-05-26 19:10:53,2023-05-26 19:10:53
616,visits:triggers_visits_day,6,6,,2023-05-31 00:00:00,2023-05-30 12:15:42,2023-05-30 23:57:01
637,visits:triggers_visits_day,6,7,,2023-06-01 00:00:00,2023-05-31 07:55:44,2023-05-31 22:42:18
672,visits:triggers_visits_day,6,7,,2023-06-02 00:00:00,2023-06-01 15:07:25,2023-06-01 22:47:49
685,visits:triggers_visits_day,6,10,,2023-06-03 00:00:00,2023-06-02 06:07:22,2023-06-02 18:14:52
709,visits:triggers_visits_day,6,11,,2023-06-04 00:00:00,2023-06-03 09:01:04,2023-06-03 20:58:29
735,visits:triggers_visits_day,6,4,,2023-06-05 00:00:00,2023-06-04 09:10:52,2023-06-04 22:33:31";
}

it('return expected array list', function () {
    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create();

    $csvRows = collect(explode("\n", values()))
        ->map(function ($row) {
            return explode(',', $row);
        });
    foreach ($csvRows as $row) {
        DB::table('visits')
            ->insert([
                'primary_key' => 'visits:testing:triggers_visits_day',
                'secondary_key' => $trigger->id,
                'score' => (int) $row[3],
                'expired_at' => $row[5] === "" ? null : new Carbon($row[5]),
            ]);
    }

    actingAs($trigger->user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/stats')
        ->assertSuccessful();
});

