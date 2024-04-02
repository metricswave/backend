<?php

namespace App\Rules;

use App\Models\TriggerType;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class TriggerConfiguration implements DataAwareRule, ValidationRule
{
    protected array $data;

    /**
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $triggerType = $this->data['trigger_type_id'] ?? null;
        if (! $triggerType) {
            return;
        }

        $triggerType = TriggerType::find($triggerType);
        if (! $triggerType) {
            return;
        }

        $configuration = $triggerType->configuration;

        foreach ($configuration['fields'] as $field) {
            if (isset($field['required']) && $field['required'] && ! $this->hasValue($value, $field)) {
                $fail('The '.$field['name'].' inside configuration field is required.');
            }
        }
    }

    private function hasValue(array $value, array $field): bool
    {
        $value = $value['fields'][$field['name']] ?? null;

        if ($field['type'] === 'location' || ($field['multiple'] ?? false)) {
            return is_array($value) && count($value) > 0;
        }

        if (is_array($value)) {
            return false;
        }

        return $value !== null && strlen($value) > 0;
    }

    public function setData(array $data): TriggerConfiguration|static
    {
        $this->data = $data;

        return $this;
    }
}
