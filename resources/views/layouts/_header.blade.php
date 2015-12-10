<meta charset="utf-8">
<title>@yield('title') | {{ memorize('site.name', 'IT Hub') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ memorize('site.description', 'IT Hub') }}">
<meta name="author" content="{{ memorize('site.author', 'Steve Bauman') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<link href="http://fonts.googleapis.com/css?family=Roboto:400,700,300,500" rel="stylesheet" type="text/css">

#{{ $asset = app('orchestra.asset')->container('ithub.header') }}
#{{ $asset->style('all', 'css/all.css') }}
#{{ $asset->script('all', 'js/all.js') }}

{!! $asset->styles() !!}
{!! $asset->scripts() !!}
