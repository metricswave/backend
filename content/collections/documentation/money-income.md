---
id: 00993a65-de4b-413c-846d-7c7b88970410
blueprint: documentation
title: 'Money Income'
short_content: 'Track all your money transactions from subscriptions, purchases or anything else.'
parent: f3552167-30d1-442f-8dc1-1bfbaa5c032a
updated_by: 6ee8895a-52f6-44a1-a772-a0e7f04692b7
updated_at: 1733479444
---
You can track your money income sending a custom event super easily.

The first thing is to create the event.

### Track your money income automatically with Stripe

If you're using Stripe to manage your subscriptions or payments you can just connect your Stripe account with MetricsWave and we  will track all charges automatically.

Take a look into the documentation about [how to connect Stripe](/documentation/services/stripe).

### Create a money income event

Just go to events, and create a new one of type `Money Income`.

You can add a custom title and description, and, if you want, you can connect it with any of your Telegram channels to receive a notification when a transaction occurs.

With the **event UUID**, you can send an event everytime a transaction happened.

Remember that, by default, a money income event has two fields:

- The `amount` of the transaction **in cents**.
- And the `source` that can be what ever you want. It's just for tracking purposes.

```javascript
fetch(
    `https://metricswave.com/webhooks/${eventUuid}?amount=2595&source=subscription`
)
```

Also, if you want, you can send a post request:

Remember that with POST request is important to set `Content-Type: application/json` and `Accept: application/json` headers. Here you
can find an example of a request made from bash terminal.

```bash
BODY='{"amount": 2595, "source": "subsription"}'
curl -X POST https://metricswave.com/webhooks/[[EVENT-UUID]] \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d "$BODY"
```