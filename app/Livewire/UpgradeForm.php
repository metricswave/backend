<?php

namespace App\Livewire;

use App;
use App\Services\Plans\PlanGetter;
use App\Transfers\Plan;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use MetricsWave\Plan\Plans;
use MetricsWave\Teams\Team;

class UpgradeForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $currency = 'usd';

    public string $currencySymbol = '$';

    public bool $showPlans = true;

    public Plans $plans;

    public Plan $currentPlan;

    public int $teamId;

    public string $intentCode;

    public function mount(): void
    {
        $this->name = session('name', '');
        $this->email = session('email', '');

        $this->plans = (new PlanGetter())->paidPlans();

        $this->showPlans = match (request()->query('f', false)) {
            false => true,
            default => false,
        };

        if (App::getLocale() === 'es') {
            $this->currency = 'eur';
            $this->currencySymbol = '€';
        }

        if (request()->query('plan', false)) {
            $routePlan = (int) request()->query('plan') + 1;
            $this->currentPlan = $this->plans
                ->first(fn(Plan $plan) => $plan->id->value === $routePlan);
        } else {
            $this->currentPlan = $this->plans->first();
        }

        $this->intentCode = Team::find($this->teamId)
            ->createSetupIntent([
                'payment_method_types' => ['card'],
                'metadata' => [
                    'team_id' => $this->teamId,
                    'currency' => $this->currency,
                    'plan_id' => $this->currentPlan->id->value,
                ]
            ])
            ->client_secret;
    }

    public function changePlan(int $planId): void
    {
        session()->put('name', $this->name);
        session()->put('email', $this->email);

        $this->redirect('?plan=' . $planId);
    }

    public function render(): View
    {
        return view('livewire.upgrade-form');
    }
}
