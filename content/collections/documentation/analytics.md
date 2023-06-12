---
id: dedd1c62-2411-4547-ab0a-a343bcd05bbf
blueprint: documentation
title: 'Actionable Insights from your Traffic and Referral'
short_content: "Learn how to get actionable insights from your traffic and referral. It's super simple and configurable."
parent: c46aafa5-b49b-4019-a55d-2074ae56570d
updated_by: 1
updated_at: 1686500647
---

With MetricsWave you can replace Google Analytics or any other analytics service.

We are privacy-friendly because we focus on store only important an actionable insights.

MetricsWave is compliant with different privacy regulations so you don’t need to worry about getting GDPR consent from
your visitors. We keep it simple by minimizing data collection and focusing on 20% of Google Analytics metrics that 80%
of analytics users find most useful.

Also, because it's a self-made tool where you can configure it as you want you can add or remove more parameters if you
need too, but, in this case we are going to focus on how to start tracking traffic with all the basic features.

#### Table of Content

1. [Create the event](#create-event)
2. [Track your traffic](#track-traffic)

<div style="scroll-margin-top: 40px" id="create-avent"></div>

## 1 - Create the event

![Visit Event](/images/documentation/visit_event.png)
The first thing it's to create your event. It came by default after sign up, but if you don't have it just create one.

It's important to add `path`, `language`, `userAgent`, `platform` and `referrer` as params.

**Important:** After creating the event, you will need to copy the Event UUID.

![Event UUID](/images/documentation/event_uuid.png)

---

<div style="scroll-margin-top: 40px" id="track-traffic"></div>

## 2 - Track your traffic

Now you just need to trigger the event on every website request you have.

You just need to add this simple line to your javascript file or inside a `script` tag.

```javascript
  fetch(
    `https://metricswave.com/webhooks/${eventUuid}?` +
    'path=' + window.location.pathname +
    '&language=' + window.navigator.language +
    '&userAgent=' + window.navigator.userAgent +
    '&platform=' + window.navigator.platform +
    '&referrer=' + document.referrer
)
```

---

[← Go back to Documentation](/documentation)
