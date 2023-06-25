---
id: d3aebd2f-e704-48fa-9661-9f77050513dd
blueprint: documentation
title: 'How to use UTM parameters to track marketing campaigns'
short_content: 'UTM parameters help track dark traffic, paid campaigns, newsletters, and high-converting social media content.'
parent: c46aafa5-b49b-4019-a55d-2074ae56570d
updated_by: 1
updated_at: 1687634551
table_of_contents: |-
  <ul class="table-of-contents">
  <li class="">
  <p><a href="#what-does-utm-stand-for" title="What does UTM stand for?">What does UTM stand for?</a></p>
  </li>
  <li class="">
  <p><a href="#how-do-i-view-utm-campaign-stats-in-metricswave" title="How do I view UTM campaign stats in MetricsWave?">How do I view UTM campaign stats in MetricsWave?</a></p>
  </li>
  <li class="">
  <p><a href="#how-do-i-generate-utm-tagged-links" title="How do I generate UTM tagged links?">How do I generate UTM tagged links?</a></p>
  </li>
  <li class="">
  <p><a href="#metricswave-utm-tag-builder-tool" title="MetricsWave UTM Tag Builder tool">MetricsWave UTM Tag Builder tool</a></p>
  </li>
  <li class="">
  <p><a href="#types-of-utm-parameters" title="Types of UTM parameters">Types of UTM parameters</a></p>
  </li>
  <li class="">
  <p><a href="#why-are-utm-parameters-so-valuable" title="Why are UTM parameters so valuable?">Why are UTM parameters so valuable?</a></p>
  </li>
  <li class="">
  <p><a href="#best-practices-for-utm-tags-and-other-things-to-know" title="Best practices for UTM tags and other things to know">Best practices for UTM tags and other things to know</a></p>
  </li>
  </ul>
---
UTM parameters are a helpful tool for business owners. 

They can assist you in gaining more knowledge on the dark traffic, tracking paid marketing campaigns, newsletters and determining particular pieces of social media content that deliver the most conversions.

![UTM Sources in MetricsWave Dashboard](/images/documentation/20230624211950_utm_sources.png)

[MetricsWave](https://metricswave.com/) has complete UTM tag support out-of-the-box to help you monitor your marketing campaigns from click to conversion. Let’s take a deeper look.

{{ toc }}

## What does UTM stand for?
A lot of website traffic has no referrer header. This traffic is called dark traffic.

Dark traffic involves clicks from emails, clicks from documents, clicks from mobile messengers, bookmarks, people typing in the URL directly into the browser and many other mechanisms. Site owners can't observe which referrer sources are sending that traffic.

A solution to reduce dark traffic is to tag links. Website owners use UTM parameters (Urchin Tracking Modules) to aid them in understanding where their site traffic is coming from. Urchin was the analytics company that Google acquired in 2005 and changed it into Google Analytics.

## How do I view UTM campaign stats in MetricsWave?
When you have UTM tagged links in your emails, social media and other platforms, you can view clicks on these links in your MetricsWave dashboard. 

You can view referral sources of your traffic, even those that would otherwise be listed as “Direct / None”:

-  In your “Top Sources” report you can filter by medium, source, campaign, term and content tabs which include all the visits to your sites from tagged links.
-  You can click on any of your individual UTM tags to dig deeper and get a full report based on that specific UTM tag:
  1. See which content on your site is visited by people that clicked on the links tagged with that UTM
  2. See which of your goals and events people that click on tagged URLs convert on
  3. See details about visitors that click on the tagged URLs such as what country they are from and what device, browser and OS they use

## How do I generate UTM tagged links?
UTM parameters are bits of text that you add to your URLs and links that you share. Here’s what a link looks like when it’s tagged with UTM parameters:
`https://yourdomain.com?utm_medium=social&utm_source=Twitter&utm_campaign=milestone`
UTM parameters are all the tags that come after the question mark (`?`) in the URL above:

-  utm_medium=social
-  utm_source=Twitter
-  utm_campaign=milestone

Individual parameters are separated by the ampersand (`&`) symbol.
You can tag all your links manually or you can use the UTM tag builder tool that makes this simple for you.

## MetricsWave UTM Tag Builder tool
You will find a lot of UTM tag builder tools such as [this one](https://utmbuilder.net/) or [another one](https://www.utmtagbuilder.com/) on the internet. 

They're super simple to use.

## Types of UTM parameters

UTM parameters consist of:

### UTM Source

`utm_source`: The name of the campaign source where you plan to share the link. Such as the name of your newsletter or the name of the social network you’re doing a campaign on.

The  `utm_source`  parameter is mandatory and required. Make sure to use it in all UTM tagged links.

### UTM Medium

`utm_medium`: The name of the channel where the link is placed. Such as email or paid social media posts.

You can organize and group  `utm_medium`  tags within few of your main marketing strategies:

-   “Email” for all email marketing campaigns
-   “Social” for organic content posted on your social media channels
-   “Social+paid” for paid campaigns posted on social media
-   “CPC” for pay per click advertising such as search engine paid advertising.
-   “Display” for any advertising banner campaigns you’re having on other websites
-   “Affiliate” for all affiliate marketing campaigns
-   “Referral” for all organic campaigns on other websites

### UTM Campaign

`utm_campaign`: The name of your individual campaign. Such as “November+newsletter” or “Black+Friday+sale”.

`utm_campaign`  is the most flexible of all the UTM tags. You can put anything you want. Launches, sales, features, specific topics…

### UTM Term

`utm_term`: The name of the keyword for your paid search ad campaign.

### UTM Content

`utm_content`: The name of the specific link.

In some campaigns, you may be having multiple links pointing to the same location. For instance two different links to your landing page in an email.  `utm_content`  allows you to differentiate between these two links and see which one performs best.

## Why are UTM parameters so valuable?

UTM parameters help you understand the big picture and referral sources that bring traffic to your site. But they also help you understand the small details such as what specific social media content works best in terms of driving conversions. Here are some use cases where UTMs can make a difference:

### Track your dark traffic

Facebook is a big source of traffic for many websites but the Facebook referrer only includes the fact that the visitor came from Facebook. Facebook never sends the post or comment ID where someone clicked. You can get this data by including UTM tags in the links you share on Facebook.

Twitter is similar in the way that it sets the referrer to their link shortener so you can see the shortened link but not the actual tweet that brought the traffic. UTM tags help you solve this.

### Track your email marketing campaigns

Any clicks on links in emails be it personal emails you send or newsletters are classified as “direct / none”. UTM tags are a perfect tool to get some insights into your email marketing campaigns.

Any links that you include in any of your emails should be tagged. At the top level, you can use  `utm_source=email`  to see how many visitors you’re getting from emails.

But you can go even further. For instance, you could track clicks on the link you have placed in your email signature: `?utm_medium=email&utm_source=personal&utm_campaign=signature` or you could track individual newsletter that you send out to your subscribers: `?utm_medium=email&utm_source=my-newsletter&utm_campaign=november-edition`.

For email newsletter campaigns, a useful naming convention could be to include the date the email was sent and the subject line as your  `utm_campaign`  tag.

### Compare paid vs organic social media activities

Social media typically sends dark traffic referrals. So by tagging the content you share in social media, you can bring light to some of your activities.

One way to do that would be to tag all your organic (non-paid) social media links with a  `utm_medium=social`  tag and all your paid social media posts with a  `utm_medium=social-paid`  tag.

This will show a clear split in your website referral traffic between visitors and activity coming from “social” and “social-paid”. It makes it easier to analyze and understand the results you’re getting from your campaigns.

### Check the results of each individual social media post

You can go even deeper than the paid vs organic social media split. You could analyze each individual post that you share using the  `utm_campaign`  tags. 

Here’s an example: `https://yourdomain.com?utm_medium=social-paid&utm_source=facebook&utm_campaign=black-friday-sale` or `https://yourdomain.com?utm_medium=social&utm_source=facebook&utm_campaign=new-season-announcement`

The above examples would allow you to not only split the traffic and see the difference between paid and organic posts but also the results of the individual posts such as paid campaign you’re having for Black Friday sale or the organic post you published about the announcement for the new season.

### Analyze influencers, affiliates and creators you’re sponsoring

UTM tags are useful in the world of affiliate marketing, influencer marketing and other sponsorships such as when sponsoring a specific newsletter.

You could tag all of the links they post with their unique UTM tags so you can not only figure out what results they drive and what ROI (return on investment) they get you, but also compare them to each other to understand which deliver the best value for you and which may make sense to sponsor again.

### Analyze your guest blogging and content syndication campaigns

In content marketing, companies do many guest blogging and content syndication campaigns. Some of these are hard to track as some websites don’t send a referral header. UTM tags are a solution to these.

Simply tag all the links in the different guest posts and other syndication activities to be able to see how many clicks and other results they drive.

## Best practices for UTM tags and other things to know

### UTM tags are case-sensitive

UTM tags are case-sensitive so  `utm_source=Twitter`  and  `utm_source=twitter`  will show separately in your analytics dashboard. Be consistent in your UTM naming practices.

Keep all the tag names consistent to keep your dashboard clean and tidy and make it easier to analyze results.

### MetricsWave merges UTM tags that are identical to referral sources

We merge all identical sources in the “All” tab of the “Top Sources” report in your MetricsWave dashboard.

For instance, clicks that you get from Twitter which are not tagged by UTMs are labeled with a referral source Twitter by Twitter itself. If you tag some links that you share on Twitter with the  `utm_source=Twitter`, clicks on those we will merge alongside other Twitter clicks in the “All” tab.

This is in order to make it easier for you to keep track and get a combined overview of all the clicks from Twitter. When you click on the “Source” tab, we only show those clicks coming from  `utm_source=Twitter`  itself.

And note again that UTM tags are case-sensitive so  `utm_source=twitter`  with lowercase t doesn’t get merged with Twitter with uppercase T.

Here are the referral header names for other popular websites so do aim to name your utm_source with identical names:

-    Facebook
-    GitHub
-    Twitter
-    LinkedIn
-    Reddit
-    Google

### You cannot use spaces in UTM tags

You cannot just include  `utm_medium=social paid`  as spaces are not supported. Either call it  `utm_medium=social-paid`,  `utm_medium=social+paid`  or  `utm_medium=social%20paid`.

### MetricsWave converts plus signs into spaces

We recommend the plus sign or  `%20`  as MetricsWave will automatically convert those into spaces. For instance, if you use  `social+paid`  or  `social%20paid`  in your links, it will be displayed as  `social paid`  in your MetricsWave dashboard.

### Note the standard URL syntax for query strings

As explained earlier, to specify query parameters you start with a  `?`  and follow each consecutive parameter with  `&`. If you use the question mark twice, the first part is ignored and only the last part is used.

So try to avoid URLs with more than a single question mark in them. If the URL already has a question mark in it, simply use the ampersand symbol instead of the initial question mark at the start of your UTM.

### Have a consistent campaign naming convention

Do you see too many campaign names and other sources in your UTM report? Is it difficult to get a good overview? Try to create a better and more consistent campaign naming convention for you and your team.

Keeping the  `utm_source`  consistent from platform to platform allows you to view all the activities in one place. If you tag all the links you share on Facebook with  `utm_source`  Facebook, then you’ll be able to see all of them by clicking on the  `utm_source`  Facebook in your MetricsWave dashboard.

This is not possible if you call some of your tags Facebook, others facebook, or Facebook-post and facebook-paid.

### How to test UTM parameters

If you get no traffic from links tagged with UTM parameters, then your UTM report in MetricsWave will be empty.

In order to test whether your UTM tagged link works, simply click on it and check your MetricsWave dashboard. Your visit should immediately show on the dashboard.

Note that in MetricsWave the referral sources are counted only when they start a new session so you won’t be able to use this method to test your links multiple times each day. Our session length is one day long.