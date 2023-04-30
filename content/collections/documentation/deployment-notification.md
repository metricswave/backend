---
id: 0b99f2ed-3870-40bd-9ab9-bcc690492324
blueprint: documentation
title: 'How to trigger a notification after a Deployment?'
parent: c46aafa5-b49b-4019-a55d-2074ae56570d
updated_by: 1
updated_at: 1682876013
short_content: "Trigger a notification after a deploy and know the version, the author and what's new on your server."
---
With webhooks triggers you can connect any application or process with NotifyWave and receive a notification when something happens.

## Webhook Trigger example

Imagine that you have a webhook trigger with 4 parameters like this.

![Webhook Trigger notification example](/images/landings/20230430174544_deployment_trigger.png)

The you can simply trigger this terminal command in your deployment script to receive a notification when everything finish.

```bash
BODY='{"version":"'$(git log --pretty=format:'%h' -n 1)'", "message":"'$(git log --pretty=format:'%s' -n 1)'","author":"'$(git log --pretty=format:'%an' -n 1)'", "service":"Backend"}'

curl -X POST https://notifywave.com/webhooks/00000000-0000-0000-0000-000000000000 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d "$BODY"
```

That's all. You can add more parameters and data if you want.