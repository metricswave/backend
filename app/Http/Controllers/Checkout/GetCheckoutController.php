<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Price;
use Illuminate\Http\RedirectResponse;

class GetCheckoutController extends Controller
{
    use HasCheckoutSessions;

    public function __invoke(Lead $lead, Price $price): RedirectResponse
    {
        return $this->checkout($price, $lead)->redirect();
    }
}
