<?php

namespace App\Http\Controllers\Lead;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostLeadRequest;
use App\Services\Leads\FirstOrCreateLeadService;
use Illuminate\Http\RedirectResponse;

class PostLeadController extends Controller
{
    public function __construct(private readonly FirstOrCreateLeadService $createLeadService)
    {
    }

    public function __invoke(PostLeadRequest $request): RedirectResponse
    {
        $lead = ($this->createLeadService)($request->email);

        return response()->redirectTo("/lead/{$lead->uuid}");
    }
}
