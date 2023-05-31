---
id: 04123833-6965-4891-bfe9-2fb2dbd327c8
blueprint: documentation
title: 'Triggers: Webhooks'
short_content: 'Webhooks are an special trigger that can be used to connect NotifyWave with other scripts or application in a few minutes.'
updated_by: 1
updated_at: 1685537005
---
Webhooks are a special trigger that can be used to connect NotifyWave with other scripts, applications or even devices in a few minutes.

The use case is simple. Every time you generate a webhook we will give you a URL to call at the moment you want to launch the notification.

---

#### Table of Content

- [❓ How they work](#how-they-work)
	- [Using a POST request](#using-post-request) 
- [🪵 Trigger a notification](#trigger-a-notification)
- [💻 Trigger a notification Programatically](#trigger-a-notification-programatically)
- [😍 Dynamic Emoji](#dynamic-emoji)

---

<div style="scroll-margin-top: 40px" id="how-they-work"></div>

### ❓ How they work

For example, imagine you create a webhook with an `email` parameter and where the title is `New lead` and the content is `{email}`.

For this webhook we will give you a URL which could be this `https://notifywave.com/webhooks/fd37c3c1-efed-4545-a75b-d32c7fec525e?email={email}`.

<div style="scroll-margin-top: 40px" id="using-post-request"></div>

#### Using a POST request

You can also, if you prefer, send a POST request with the params in a json body. In this case it will be something like this `{email: "any@email.com"}`.

With POST request is important to set `Content-Type: application/json` and `Accept: application/json` headers. Here you can find an example of a request made from bash terminal.

```bash
BODY='{"email": "my@email.com"}'
curl -X POST https://notifywave.com/webhooks/fd37c3c1-efed-4545-a75b-d32c7fec525e \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d "$BODY"
```

---

<div style="scroll-margin-top: 40px" id="trigger-a-notification"></div>

### 🪵 Trigger a notification

You only have to access the following URL, for example, `https://notifywave.com/webhooks/fd37c3c1-efed-4545-a75b-d32c7fec525e?email=hi@notifywave.com` and you will receive the following notification:

- Title: New lead
- Content: hi@notifywave.com

---

<div style="scroll-margin-top: 40px" id="trigger-a-notification-programmatically"></div>

### 💻 Trigger a notification Programmatically

You can trigger this notification programmatically with just one line. For example, in JavaScript you can do just this:

```javascript
const email = "hi@notifywave.com"
fetch(`https://notifywave.com/webhooks/fd37c3c1-efed-4545-a75b-d32c7fec525e?email=${email}`)
```

With PHP, it will be something like this:

```php
$email = "hi@notifywave.com";
file_get_contents("https://notifywave.com/webhooks/fd37c3c1-efed-4545-a75b-d32c7fec525e?email=${email}");
```

---

<div style="scroll-margin-top: 40px" id="dynamic-emoji"></div>

### 😍 Dynamic Emoji

![Same trigger with different emojis](/images/documentation/20230505094536_webhook_trigger_dynamic_emoji.png)

All webhooks have a hidden `emoji` parameter. This parameter gives you the option to dynamically change the emoji.

Just add the param `&emoji=😍` at the end of your GET request, or as a param in your POST, and the notification will be triggered with this emoji instead of the one configured in the Trigger.

---

[**← Read more about Triggers**](/documentation/triggers)