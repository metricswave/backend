---
id: 0b99f2ed-3870-40bd-9ab9-bcc690492324
blueprint: documentation
title: 'Tracking your Deployments'
parent: c46aafa5-b49b-4019-a55d-2074ae56570d
updated_by: 1
updated_at: 1686501654
short_content: 'You can track each deploy and also send a message to your channels.'
---
With webhooks triggers you can connect any application or process with NotifyWave and receive a notification when something happens and also get useful stats about them.

## Event to Track your Deployments

Create an event with this params.

![Webhook Trigger notification example](/images/documentation/event_deployment.png)

In this case we have this params: `author`, `message`, `version` and `service`.

The you can simply trigger this bash command in your deployment script to receive a notification when everything finish.

```bash
BODY='{"version":"'$(git log --pretty=format:'%h' -n 1)'", "message":"'$(git log --pretty=format:'%s' -n 1)'","author":"'$(git log --pretty=format:'%an' -n 1)'", "service":"Backend"}'

curl -X POST https://notifywave.com/webhooks/00000000-0000-0000-0000-000000000000 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d "$BODY"
```

That's all. You can add more parameters and data if you want.

**Important:** Remember to replace `00000000-0000-0000-0000-000000000000` with the UUID of your event.

---

## 🔔 Share every deploy on Telegram

Remember that in each event you have the option to send a notification to a connected channel every time an event is received.

So, you can [connect a Telegram channel](/documentation/services/telegram) a share a custom notification automatically after each deploy.

You can use this title and description configuration as an example:

```
Title: 
{service} Deployed

Description:
**Author:** {author}
**Version:** {version}

{message}
```

---

[← Go back to documentation](/documentation)