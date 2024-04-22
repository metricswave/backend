<?php

namespace App\Livewire;

use App;
use App\Services\Plans\PlanGetter;
use App\Transfers\Plan;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use MetricsWave\Plan\Plans;

class UpgradeForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $currency = 'usd';

    public string $currencySymbol = '$';

    public bool $showPlans = true;

    public Plans $plans;

    public Plan $currentPlan;

    public function mount(): void
    {
        $this->name = session('name', '');
        $this->email = session('email', '');

        $this->plans = (new PlanGetter())->paidPlans();

        $this->showPlans = match (request()->query('f', false)) {
            false => true,
            default => false,
        };

        if (request()->query('plan', false)) {
            $routePlan = (int) request()->query('plan') + 1;
            $this->currentPlan = $this->plans
                ->first(fn(Plan $plan) => $plan->id->value === $routePlan);
        } else {
            $this->currentPlan = $this->plans->first();
        }

        if (App::getLocale() === 'es') {
            $this->currency = 'eur';
            $this->currencySymbol = '€';
        }
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

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        dd('Saving', [
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }
}
