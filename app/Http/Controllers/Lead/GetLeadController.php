<?php

namespace App\Http\Controllers\Lead;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\Prices\GetLandingPricesService;
use Illuminate\Contracts\View\View;

class GetLeadController extends Controller
{
    public function __construct(public readonly GetLandingPricesService $landingPricesService)
    {
    }

    public function __invoke(Lead $lead): View
    {
        $name = config('app.name');

        return view('lead.lead_index', [
            'lead' => $lead,
            'todos' => [
                [
                    "done" => $lead->form_filled,
                    "text" => "What would you like {$name} to be like? 🤔",
                    "description" => '(less than 2 minutes)',
                    "link" => "https://tally.so/r/3xVO5y?lead_id={$lead->uuid}",
                ],
                [
                    "done" => $lead->paid_at !== null,
                    "text" => 'Check out the lifetime license 🎉',
                    "description" => "With one payment only you'll get all the features for free and for ever.",
                    "link" => '#lifetime-license',
                ],
            ],
        ]);
    }
}
