<?php

namespace App\Http\Controllers\Tally;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostTallyController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $leadUuid = collect($request->json('data.fields', []))
            ->first(fn ($field) => $field['label'] === 'lead_id');

        Lead::where('uuid', $leadUuid['value'])
            ->update([
                'form_filled' => true,
            ]);

        return response()->noContent();
    }
}
