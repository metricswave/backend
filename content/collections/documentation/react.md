---
id: ca653e51-a9dc-4b90-84a6-57a3f649a9a8
blueprint: documentation
title: 'Integrations: React'
short_content: 'React is a free, open-source JavaScript library utilized for crafting user interfaces based on components.'
parent: 515e68b9-1b87-4a82-80d6-f614c1a536f3
updated_by: 1
updated_at: 1687524024
---

**[React](https://react.dev/) is a free, open-source JavaScript library utilized for crafting user interfaces based on
components.**

Integrating MetricsWave with react it's usually a single line of code.

## How to measure your traffic

Inside your `index.html` fiel you just need to add the script inside the `head` tag.

Something like this:

```html
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Other tags in your file -->


    <!-- Add MetricsWave visit script -->
    <script defer
            event-uuid="00000000-0000-0000-0000-000000000000"
            src="https://metricswave.com/js/visits.js"></script>

</head>

<body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root"></div>
</body>

</html>
```

## How to measure events

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
