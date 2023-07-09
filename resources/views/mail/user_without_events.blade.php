<x-mail::message>
Hi 👋!

I saw that you created an account, but you're not monitoring your traffic yet. I want to help you get started, so I'm going to give you a few tips.

## 1. Add the tracking code to your website
You can find the tracking code inside the event in your event list, but basically you just need to add this code to your website:

```html
<script defer
    event-uuid="{{ $uuid  }}"
    src="https://tracker.metricswave.com/js/visits.js">
</script>
```

Here your can find specific information about how to add the code to [React](https://metricswave.com/documentation/integrations/react), [Next.js](https://metricswave.com/documentation/integrations/next-js), [FlutterFlow](https://metricswave.com/documentation/integrations/flutterflow) or [something else](https://metricswave.com/documentation/integrations).

## 2. Check your events
You can see your events in the [event list](https://metricswave.com/events). If you don't see any events, it means that you didn't add the tracking code to your website yet. Events appear in real time so, if everything is working, you should see your events in a few seconds.

---

If you have any questions, you can reply to this email, and I'll be happy to help you.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
