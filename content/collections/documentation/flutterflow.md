---
id: b3c29b03-88a4-47a6-8e0d-1a40c0c88225
blueprint: documentation
title: 'Integrations: FlutterFlow'
short_content: 'FlutterFlow is a low-code builder for developing native mobile applications and you can use MetricsWave to log user behaviour.'
parent: 515e68b9-1b87-4a82-80d6-f614c1a536f3
updated_by: 1
updated_at: 1687768154
table_of_contents: |-
  <ul class="table-of-contents">
  <li class="">
  <p><a href="#1-create-an-api-call" title="1. Create an API Call">1. Create an API Call</a></p>
  </li>
  <li class="">
  <p><a href="#2-triggering-your-event-using-that-api-call" title="2. Triggering your Event using that API Call">2. Triggering your Event using that API Call</a></p>
  </li>
  </ul>
---
[FlutterFlow](https://flutterflow.io) is a low-code builder for developing native mobile applications. You can use our
simple drag and drop interface to build your app 10x faster than traditional development.

With MetricsWave you can log all your traffic and how the user is using your product sending as many events as you want.

It's super simple.

{{ toc }}

## 1. Create an API Call

The first thing it's to create the [API call](https://docs.flutterflow.io/data-and-backend/api-calls) to your event.

![Define your API Call in FlutterFlow](/images/documentation/flutterflow/define_api_call.png)

Use `method type POST` and the Url should be `https://metricswave.com/webhooks/[uuid]`.

Then, inside variables tab, you need to add, at least, the uuid variable. This variable is type string and you can add
the default value with the UUID of your event.

Last thing, if your event has some parameters you need to define them in the Body tab.
sc

In this case we are using a variable of type JSON. By doing this we can change the body every time we are triggering
this event, but you can put something fixed if it's better for you.

## 2. Triggering your Event using that API Call

Now everything is ready to just trigger our event when we want.

Imagine that you want to trigger something one the user press a button, for example.

We just need to an [Action](https://docs.flutterflow.io/actions/actions/backend-database/api-call) to the button. In the
Action Flow Editor we can customize parameters and make more than one thing, if we needed.

![Action Flow in FlutterFlow](/images/documentation/flutterflow/action_flow.png)

---

That's all! Now you can integrate MetricsWave in your FlutterFlow application and learn about what users are doing with
your app.

You can measure everything, monitor your business and detect possible errors or problems in your flow.