Hello {{ $name }},<br>
<br>
It seems that you have just reached your monthly limit with <strong>{{ $domain }}</strong>.<br>
<br>
Don't worry, since it's your first time, I want to share a coupon with you to use for free for the first month.<br>
<br>
Just add <code>FIRSTMONTHFREE</code> during your checkout on any plan.<br>
<br>
You can upgrade your plan <a href="{{ $url }}">here</a>, or just go to Settings > Billing.<br>
<br>
If you need help, just reply to this email.<br>
<br>
Thanks,<br>
{{ config('app.name') }}
