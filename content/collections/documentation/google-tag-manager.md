---
id: e6248cc2-7855-480f-aad5-ea148eae478d
blueprint: documentation
title: 'Integration: Google Tag Manager'
short_content: 'You can use Google Tag Manager to add MetricsWave tracking code in your website easily.'
updated_by: 1
updated_at: 1694716354
table_of_contents: |-
  <ul class="table-of-contents">
  <li class="">
  <p><a href="#how-to-add-the-script-to-your-site-with-google-tag-manager" title="How to add the script to your site with Google Tag Manager">How to add the script to your site with Google Tag Manager</a></p>
  </li>
  <li class="">
  <p><a href="#how-to-find-your-event-uuid" title="How to find your event UUID">How to find your event UUID</a></p>
  </li>
  </ul>
---
{{ toc }}

## How to add the script to your site with Google Tag Manager

In a few and simple steps you can add MetricsWave script to all your sites with Google Tag Manager.

1. In your Google Tag Manager account, go to Tags > New.
2. Choose Tag Configuration and setup a custom name.
3. Choose HTML Tag and add the code bellow in the HTML field
```html
<script>
  var script = document.createElement('script');
  script.defer = true;
  script.setAttribute('event-uuid', 'YOUR EVENT UUID')
  script.src = "https://tracker.metricswave.com/js/visits.js";
  document.getElementsByTagName('head')[0].appendChild(script);
</script>
```
4. Save, Submit and Publish your new tag.

## How to find your event UUID

There are different ways to find your event UUID for the code before.

If you're in the welcome screen you can find it inside the current code block that we are showing to you. **Just look in the tag `event-uuid`, it's there, between quotes.**

![Welcome page tracking code in welcome page - MetricsWave](/storage/documentation/find-event-uuid-in-welcome-page.png)

If you are inside the app, you should go to Events, and enter the desire Visit type event you want to track.

**There, you can find the UUID in the top of page, under the event name.**

![Welcome page tracking code In event page - MetricsWave](/storage/documentation/find-event-uuid-in-event-page.png)