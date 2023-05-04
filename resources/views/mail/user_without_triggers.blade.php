<x-mail::message>
Hi 👋!

I'm Victor, in case you didn't know me yet, and I'm the creator of {{ config('app.name') }}.

I saw that you created an account, but you haven't created any trigger yet. I want to help you get started, so I'm going to give you a few tips.

**How about creating a trigger to receive the weather information every morning?** You can do it with the following steps:

- Go to the [triggers page]({{ config('app.web_app_url') }}triggers?utm_source=user_without_triggers_mail) and click on the "Add trigger" button.
- Select the "Daily Weather Summary" trigger.
- In the title field, write "Today: {weather.today.condition}"
- And in the content write something like "Temperature: {weather.today.temperature2m_min}°-{weather.today.temperature2m_max}°"
- Then choose your location, the time and the days of the week you want to receive the notification.
- That's it! Click on the "Create" button, and you're done.

**Also, if you want to know more about how to create triggers or you are missing some functionality, just replay to this email and I will help you.**

🇪🇸 PD: Si quieres puedes responder en español, que el idioma no sea un problema.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
