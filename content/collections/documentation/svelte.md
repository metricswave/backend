---
id: 1387ca34-c1b3-45ef-b49b-19aed2f83de0
blueprint: documentation
title: 'Integrations: Svelte'
short_content: 'Svelte is a lightweight JavaScript framework for building web applications.'
table_of_contents: |-
  <ul class="table-of-contents">
  <li class="">
  <p><a href="#monitor-your-traffic" title="Monitor your traffic">Monitor your traffic</a></p>
  </li>
  <li class="">
  <p><a href="#how-to-trigger-events" title="How to trigger events">How to trigger events</a></p>
  </li>
  </ul>
parent: 515e68b9-1b87-4a82-80d6-f614c1a536f3
updated_by: 1
updated_at: 1689150383
---
[Svelte](https://svelte.dev/) is a lightweight JavaScript framework for building web applications.

{{ toc }}

## Monitor your traffic

Integrating MetricsWave with Svelte is easy. You only need to add the Script inside the `<svelte:head>` tag.

Something like this is enough.

```typescript
<svelte:head>
  <!-- MetricsWave Script -->
  <script defer
          event-uuid="00000000-0000-0000-0000-000000000000"
          src="https://tracker.metricswave.com/js/visits.js">
  </script>
</svelte:head>)
```

It's important that this script should be included on all the pages of your application, maybe you can use a layout or
extend the app from this component.

## How to trigger events

To trigger events whenever you want you will need to
use [the API](http://metricswave.test/documentation/tracking/events).

You have multiple options to do this, but a simple one it's to create a function like the next and use it everywhere in
your application.

You only need to pass the trigger UUID and the parameters of your event.

```typescript
export function triggerEvent(eventUuid: string, params: Object = {}) {
  if (!app.isProduction) {
    console.log(`[EventTracker] ${eventUuid}`, params)
    return
  }

  fetch(`https://notifywave.com/webhooks/${eventUuid}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
    },
    body: JSON.stringify(params),
  })
}
```