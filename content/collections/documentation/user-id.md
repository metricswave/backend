---
id: 7cd0310d-48c1-4c5d-b414-f4e62561d635
blueprint: documentation
title: 'Track User Unique Identifier'
short_content: 'Know what each user is doing on your app. Track their actions, clicks, forms, and purchases.'
parent: f3552167-30d1-442f-8dc1-1bfbaa5c032a
updated_by: 6ee8895a-52f6-44a1-a772-a0e7f04692b7
updated_at: 1732034155
table_of_contents: |-
  <ul class="table-of-contents">
  <li class="">
  <p><a href="#using-the-tracking-script" title="Using the tracking script">Using the tracking script</a></p>
  </li>
  <li class="">
  <p><a href="#manually-for-all-the-events" title="Manually for all the events">Manually for all the events</a></p>
  </li>
  </ul>
---
You can track a user ID to see his timeline and how is he using your app.

![User realtime timeline - MetricsWave](/storage/documentation/user-timeline.png)

To do this, you simply need to inform MetricsWave about the current user ID so we can know which user is logged in at the moment.

To do this you have multiple options.

## Using the tracking script

If you have added the visit script to your site, this one:

```html
<script 
        defer
        event-uuid="{{EVENT_UUID}}" 
        src="https://tracker.metricswave.com/js/visits.js"
></script>
```

You can use `window.metricswave.setUser()` method to set the user id after login.

```javascript
# After login
window.metricswave.setUser(userId);

# After logout
window.metricswave.setUser(null);
```

- `userId` can be either a string or an integer, but it should be unique for each user.

## Manually for all the events

You can send this parameter with all events that you already have as a param.

For example this is the code for a custom event with source param.

```javascript
fetch(
    `https://metricswave.com/webhooks/${eventUuid}?source=landing`
)
```

If you want to track the user id on this event, you just need to send the param like this:

```javascript
fetch(
    `https://metricswave.com/webhooks/${eventUuid}?source=landing&user=john@email.com`
)
```

Or, if your are using POST:

```bash
BODY='{"source": "landing", "user": "john@email.com"}'
curl -X POST https://metricswave.com/webhooks/[[EVENT-UUID]] \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d "$BODY"
```

It's that easy.