<title>{{ isset($title) ? $title . " - " : "" }}{{ config('app.name') }}</title>
<meta content="{{  $meta_description ?? 'Real-time notifications for everything that matters to you.'  }}"
      name="description"/>
<link rel="canonical"
      href="{{ safe_url(config('app.url').request()->getPathInfo()) }}"/>

{{-- OG Tags --}}
<meta property="og:url"
      content="{{ safe_url(config('app.url').request()->getPathInfo()) }}"/>
<meta property="og:locale"
      content="en_US"/>
<meta property="og:type"
      content="article"/>
<meta property="og:title"
      content="{{ isset($title) ? $title . " - " : "" }}{{ config('app.name') }}"/>
<meta property="og:description"
      content="{{ $meta_description ?? 'Real-time notifications for everything that matters to you.' }}"/>
<meta property="og:image"
      content="{{ safe_url(config('app.url').'/images/metricswave.png?v=20230612161011') }}"/>

<meta name="twitter:card"
      content="summary_large_image"/>
<meta name="twitter:title"
      content="{{ config('app.name') }}"/>
<meta name="twitter:description"
      content="{{ $meta_description ?? 'Real-time notifications for everything that matters to you.' }}"/>
<meta name="twitter:image"
      content="{{ safe_url(config('app.url').'/images/metricswave.png?v=20230612161011') }}"/>
