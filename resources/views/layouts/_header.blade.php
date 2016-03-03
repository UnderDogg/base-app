<title>@yield('title') | {{ env('APP_NAME', 'Helpdesk') }} </title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Helpdesk">
<meta name="author" content="Steve Bauman">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="http://fonts.googleapis.com/css?family=Roboto:400,700,300,500" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="{{ asset('css/all.css') }}">
<script type="text/javascript" src="{{ asset('js/all.js') }}"></script>

<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script type="text/javascript" src="{{ asset('js/html5.js') }}"></script>
<![endif]-->
