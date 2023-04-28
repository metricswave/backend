---
id: 7d99100b-b1fe-4ff4-81d5-7a0f4eb7e7b8
blueprint: documentation
title: 'NotifyWave in your Terminal'
short_content: 'Integrate NotifyWave inside your and receive a notification when a long command ends.'
parent: c46aafa5-b49b-4019-a55d-2074ae56570d
updated_by: 1
updated_at: 1682686173
---
Imagine that you are going to execute a command that you know it will take a while. Instead of being in fron of your computer just waiting you can receive a notification in all your devices just when it ends.

You can do this with a [Webhook notification](/documentation/triggers/webhooks) and a quick alias.

Just add, in your `.bashrc` or `.zshrc` file the next alias:

```bash
alias notifywave = curl https://notifywave.com/webhooks/{uuid-of-your-trigger}
```

Then, after realoading your terminal, you will be able to do something like this:

```bash
$ long-command; notifywave
```

And this it. When the `long-command` ends, you will receive a notification everywhere.