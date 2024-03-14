---
id: f6b216f1-9e69-49c2-9674-71e75f67091b
blueprint: documentation
title: 'Integrations: HTML and JavaScript'
short_content: 'Follow this steps to monitor your basic HTML and JavaScript site. You just need to follow one simple step.'
table_of_contents: |-
  <ul class="table-of-contents">
  <li class="">
  <p><a href="#how-to-measure-your-traffic" title="How to measure your traffic">How to measure your traffic</a></p>
  </li>
  <li class="">
  <p><a href="#how-to-measure-events" title="How to measure events">How to measure events</a></p>
  </li>
  </ul>
parent: 515e68b9-1b87-4a82-80d6-f614c1a536f3
updated_by: 1
updated_at: 1687768054
---

To integrate MetricsWave in your HTML and JavaScript site you just need to add the visits script. This should be added
inside the `<head>` tag in all your sites.

It's a super small script (less than 1KB) so it's going to load fast without compromising the user experience or loading
time.

{{ toc }}

## How to measure your traffic

Inside your `index.html` file you just need to add the script inside the `head` tag.

Something like this:

```html
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Other tags in your file -->


    <!-- Add MetricsWave visit script -->
    <script defer
            event-uuid="00000000-0000-0000-0000-000000000000"
            src="https://tracker.metricswave.com/js/visits.js"></script>

</head>

<body>
    <!-- website content -->
</body>

</html>
```

## How to measure events

To trigger events whenever you want you will need to
use [the API](/documentation/tracking/events).

You have multiple options to do this, but a simple one it's to create a function like the next and use it everywhere in
your application.

You only need to pass the trigger UUID and the parameters of your event.

```javascript
export function triggerEvent(eventUuid, params = {}) {
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
