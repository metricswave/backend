<?php

namespace App\Http\Requests;

use App\Transfers\Stats\Period;
use App\Transfers\Stats\PeriodEnum;
use App\Transfers\Stats\PeriodInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\RequiredIf;

/**
 * @property-read ?PeriodEnum $period
 * @property-read ?\Illuminate\Support\Carbon $date
 * @property-read ?\Illuminate\Support\Carbon $fromDate
 */
class PeriodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function period(): PeriodEnum
    {
        if ($this->period === null) {
            return PeriodEnum::default();
        }

        return PeriodEnum::from($this->period);
    }

    public function rules(): array
    {
        return [
            'period' => [new Enum(PeriodEnum::class)],
            'date' => ['date'],
            'from-date' => [
                new RequiredIf($this->period()->isCustom()),
            ],
        ];
    }

    public function getPeriod(): PeriodInterface
    {
        return new Period(
            $this->toDate(),
            $this->period(),
            $this->fromDate()
        );
    }

    private function toDate(): Carbon
    {
        return $this->date !== null ? Carbon::createFromFormat('Y-m-d', $this->date) : now();
    }

    private function fromDate(): ?Carbon
    {
        return $this->get('from-date') ?
            Carbon::createFromFormat('Y-m-d', $this->get('from-date'))
                ->startOf($this->period()->visitsPeriod()) :
            null;
    }
}
