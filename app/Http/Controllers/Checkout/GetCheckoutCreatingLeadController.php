<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\RedirectResponse;

class GetCheckoutCreatingLeadController extends Controller
{
    use HasCheckoutSessions;

    public function __invoke(Price $price): RedirectResponse
    {
        return $this->checkout($price)->redirect();
    }
}
