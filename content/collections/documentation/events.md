---
id: 5f9d25c0-3095-447d-b11c-4d2749198ee1
blueprint: documentation
title: 'Tracking custom Events'
parent: f3552167-30d1-442f-8dc1-1bfbaa5c032a
updated_by: 1
updated_at: 1686651420
short_content: 'You can log and register any custom event on your site as you want. Learn how to take advantage of custom events to find out how your application is used.'
---
One of MetricsWave's most powerful features is the ability to record custom events and obtain information from them.

Events, along with custom parameters, will allow you to view statistics and understand how users are using your
application.

![Custom Event Stats](/images/documentation/custom_event.png)

### Create and Trigger custom events

The first thing it's to create your event. You can do this in the `Event` view inside our application.

Add a title, a description and all the params that you want to attach if any. After creating the event copy and save the
event UUID. You will need it.

Now you just need to trigger the event in your application. This is as simple as making a fetch request to the endpoint
with the event UUID you just copied.

```javascript
fetch(
    `https://metricswave.com/webhooks/${eventUuid}?email=hi@metricswave.com`
)
```

#### Track custom event using visits script

If you are logging your traffic using our visits script. You can log an event `window.metricswave()` function.

```javascript
window.metricswave(eventUuid, {email: 'hi@metricswave.com'})
```

### Using a POST request

You can also, if you prefer, send a POST request with the params in a json body. In this case it will be something like
this `{email: "any@email.com"}`.

With POST request is important to set `Content-Type: application/json` and `Accept: application/json` headers. Here you
can find an example of a request made from bash terminal.

```bash
BODY='{"email": "my@email.com"}'
curl -X POST https://metricswave.com/webhooks/fd37c3c1-efed-4545-a75b-d32c7fec525e \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d "$BODY"
```

### 😍 Dynamic Emoji

Same trigger with different emojis

All events have a hidden `emoji` parameter. This parameter gives you the option to dynamically change the emoji.

Just add the param `&emoji=😍` at the end of your GET request, or as a param in your POST, and the notification will be
triggered with this emoji instead of the one configured in the Trigger.

---

[← Go back to documentation](/documentation)