---
id: edd2cd30-f085-4e3b-aa32-b2506728d8fa
blueprint: documentation
title: 'Integrations: Next.js'
short_content: 'The React Framework for the Web.'
parent: 515e68b9-1b87-4a82-80d6-f614c1a536f3
updated_by: 6ee8895a-52f6-44a1-a772-a0e7f04692b7
updated_at: 1696755152
table_of_contents: |-
  <ul class="table-of-contents">
  <li class="">
  <p><a href="#monitor-your-traffic" title="Monitor your traffic">Monitor your traffic</a></p>
  </li>
  <li class="">
  <p><a href="#how-to-trigger-events" title="How to trigger events">How to trigger events</a></p>
  </li>
  </ul>
---
[Next.js](https://nextjs.org/) is a react framework for the Web. It enables you to create full-stack web applications by
extending the latest React features.

{{ toc }}

## Monitor your traffic

Integrating MetricsWave with Next.js is easy. You only need to add the Script using the `next/script` tag.

Something like this is enough.

```typescript
import Script from "next/script";

export default function Home() {
  return (<>
    <Script defer
            event-uuid="00000000-0000-0000-0000-000000000000"
            src="https://tracker.metricswave.com/js/visits.js"></Script>

    {/* Rest of your page */}
  </>)
}
```

It's important that this script should be included on all the pages of your application, maybe you can use a layout or
extend the app from this component.

## How to trigger events

To trigger events whenever you want you will need to
use [the API](/documentation/tracking/events).

You have multiple options to do this, but a simple one it's to create a function like the next and use it everywhere in
your application.

You only need to pass the trigger UUID and the parameters of your event.

```typescript
export function triggerEvent(eventUuid: string, params: Object = {}) {
  if (!app.isProduction) {
    console.log(`[EventTracker] ${eventUuid}`, params)
    return
  }

  fetch(`https://metricswave.com/webhooks/${eventUuid}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
    },
    body: JSON.stringify(params),
  })
}
```
