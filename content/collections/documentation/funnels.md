---
id: 45774172-0d54-4f8e-a6dd-32aadf0cbe51
blueprint: documentation
title: Funnels
short_content: 'Create a measure custom flows using funnels. You can see how your users are making purchases, registering or anything else.'
parent: f3552167-30d1-442f-8dc1-1bfbaa5c032a
updated_by: 1
updated_at: 1691338206
---
Funnels are amazing to track custom flows like purchases, sign ups or whatever you want, really.

### Create and Trigger custom events

The first thing it's to create your event of type Funnel. You can do this in the `Event` view inside our application.

It's important to add a title, but more important the number of steps in order. You have to write one step per line. Each step is important, because you have to send on of this in each event.

Now you just need to trigger the funnel event in your application. This is as simple as making a fetch request to the endpoint
with the event UUID.

```javascript
fetch(
    `https://metricswave.com/webhooks/${eventUuid}?
    	step=Add To Cart
        &user_id=123456`
)
```

You can also make a `POST` request if you prefer. You just need to make the request to the same path and add both fields in the body as json.

#### Track custom event using visits script

If you are logging your traffic using our visits script. You can log a funnel step using `window.metricswave()` function.

```javascript
window.metricswave(eventUuid, {step: 'Add To Cart', user_id: 123456})
```

### Using a POST request

You can also, if you prefer, send a POST request with the params in a json body. In this case it will be something like
this `{step: 'Add To Cart', user_id: 123456}`.

With POST request is important to set `Content-Type: application/json` and `Accept: application/json` headers. Here you
can find an example of a request made from bash terminal.