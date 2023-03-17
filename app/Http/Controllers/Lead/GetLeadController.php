<?php

namespace App\Http\Controllers\Lead;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Contracts\View\View;

class GetLeadController extends Controller
{
    public function __invoke(string $leadUuid): View
    {
        $name = config('app.name');
        $url = config('app.url');

        $lead = Lead::where('uuid', $leadUuid)->firstOrFail();
        return view('lead.lead_index', [
            'lead' => $lead,
            'todos' => [
                [
                    "done" => $lead->form_filled,
                    "text" => "What would you like {$name} to be like? 🤔",
                    "description" => '(less than 2 minutes)',
                    "link" => 'https://tally.so/r/3xVO5y?lead_id={lead.id}',
                ],
                [
                    "done" => $lead->paid_at !== null,
                    "text" => 'Check out the lifetime license 🎉',
                    "description" => "With one payment only you'll get all the features for free and for ever.",
                    "link" => '#lifetime-license',
                ],
//                [
//                    "id" => 'share',
//                    "done" => $lead->landing_shared,
//                    "text" => "Share {$name} with the world 🥰",
//                    "description" => '',
//                    "link" => "https://twitter.com/intent/tweet?text=I%20just%20discover%20{$name}%20%F0%9F%8E%89!%0A%0AAn%20app%20that%20will%20send%20you%20Real-time%20notifications%20for%20everything%20that%20matters to you.%0A%0ANever%20miss%20a%20beat%20%F0%9F%94%A5&url=https%3A%2F%2F{$url}",
//                ],
//                [
//                    "id" => 'follow',
//                    "done" => $lead->follow_me_on_twitter,
//                    "text" => 'Follow me on Twitter 🐦',
//                    "description" => "I'll let you know what's new and follow the steps below",
//                    "link" => 'https://twitter.com/intent/user?screen_name=victoor',
//                ],
            ],
        ]);
    }
}
