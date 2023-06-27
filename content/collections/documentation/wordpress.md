---
id: 6626aa8a-63f2-425f-88ed-16045913defe
blueprint: documentation
title: 'Integrations: WordPress'
short_content: 'MetricsWave is easy to integrate with your WordPress site and is designed to be user-friendly for site owners of all skill levels.'
table_of_contents: |-
  <ul class="table-of-contents">
  <li class="">
  <p><a href="#how-to-measure-your-traffic" title="How to measure your traffic">How to measure your traffic</a></p>
  </li>
  </ul>
parent: 515e68b9-1b87-4a82-80d6-f614c1a536f3
updated_by: 1
updated_at: 1687846318
---
**MetricsWave is a powerful analytics tool that offers several advantages over other analytics solutions.**

MetricsWave provides detailed, real-time analytics that can help you optimize your website's performance. With MetricsWave, you can track metrics such as page views, bounce rates, and visitor behavior, and use this data to make informed decisions about content, design, and marketing. 

This can help you increase engagement, generate more leads, and ultimately boost conversions. 

Also, MetricsWave is easy to integrate with your [WordPress](https://wordpress.org/) site and is designed to be user-friendly for site owners of all skill levels. 

{{ toc }}

## How to measure your traffic

Inside your **WordPress Dashboard**, go to Appearance → Editor. Click the `header.php` file to edit its code and add the next code just before the end `</head>` tag.

Something like this:

```php
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Other tags in your file -->


  <!-- Add MetricsWave visit script -->
  <script defer
          event-uuid="00000000-0000-0000-0000-000000000000"
          src="https://metricswave.com/js/visits.js"></script>
</head>

<body <?php body_class(); ?>>

  <!-- More code -->
```