<title>@yield('title') | Administration</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Administration.">
<meta name="author" content="Author">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="{{ asset('administration/css/libs/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('administration/css/libs/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('administration/css/libs/select2.css') }}">
<link rel="stylesheet" href="{{ asset('administration/css/libs/select2-bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('administration/css/libs/sweetalert.css') }}">

<!-- Custom Application CSS -->
<link rel="stylesheet" href="{{ asset('administration/css/app.css') }}">

<script type="text/javascript" src="{{ asset('administration/js/libs/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('administration/js/libs/jquery.pjax.js') }}"></script>
<script type="text/javascript" src="{{ asset('administration/js/libs/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('administration/js/libs/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('administration/js/libs/sweetalert.min.js') }}"></script>

<!-- Custom Application JS -->
<script type="text/javascript" src="{{ asset('administration/js/app.js') }}"></script>

<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script type="text/javascript" src="{{ asset('administration/js/libs/html5.js') }}"></script>
<![endif]-->
