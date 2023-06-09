<?php

namespace Database\Factories;

use App\Models\Trigger;
use App\Services\TravelDistance\TravelMode;
use App\Services\Triggers\TimeToLeaveTriggersProcessor;
use App\Transfers\TriggerTypeId;
use App\Transfers\Weekday;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trigger>
 */
class TriggerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 10),
            'trigger_type_id' => fake()->numberBetween(1, 10),
            'uuid' => fake()->uuid,
            'emoji' => fake()->emoji,
            'title' => fake()->word,
            'content' => fake()->sentence,
            'configuration' => [
                'version' => '1.0.0',
                'fields' => [
                    'name' => fake()->word,
                ],
            ],
        ];
    }

    public function onTime(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'trigger_type_id' => TriggerTypeId::OnTime->value,
                'configuration' => [
                    'fields' => [
                        'time' => '08:00',
                        'weekdays' => '["monday","tuesday","wednesday","thursday","friday"]',
                    ]
                ],
            ];
        });
    }

    public function calendarTimeToLeave(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'trigger_type_id' => TriggerTypeId::CalendarTimeToLeave->value,
                'configuration' => [
                    'fields' => [
                        'origin' => 'Calle Oca 21, Madrid, España',
                        'mode' => TravelMode::DRIVING->value,
                    ],
                ],
            ];
        });
    }

    public function timeToLeave(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'trigger_type_id' => TriggerTypeId::TimeToLeave->value,
                'configuration' => [
                    'fields' => [
                        'origin' => 'Calle Oca 21, Madrid, España',
                        'destination' => 'San Pantaleón 5, Madrid, España',
                        'mode' => TravelMode::DRIVING->value,
                        'arrival_time' => now()->subHours(TimeToLeaveTriggersProcessor::HOURS_BEFORE)->subMinutes(1)->format('H:i'),
                        'weekdays' => [Weekday::fromDayOfWeek(now()->dayOfWeek)->toString()],
                    ],
                ],
            ];
        });
    }

    public function webhook(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'trigger_type_id' => TriggerTypeId::Webhook->value,
                'configuration' => [
                    'fields' => [
                        "parameters" => [
                            'name',
                            'content',
                        ]
                    ]
                ]
            ];
        });
    }
}
