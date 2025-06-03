<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8" />
	<title>@yield('pageTitle')</title>

	{{--
	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="/back/vendors/images/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="/back/vendors/images/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="/back/vendors/images/favicon-16x16.png" /> --}}

	<link rel="icon" type="image/png" sizes="16x16"
		href="/images/site/{{ isset(settings()->site_favicon) ? settings()->site_favicon : ''}}" />


	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
		rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="/back/vendors/styles/core.css" />
	<link rel="stylesheet" type="text/css" href="/back/vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />
	@stack('stylesheets')
</head>

<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="login.html">
					<img src="/back/vendors/images/deskapp-logo.svg" alt="" />
				</a>
			</div>
			<div class="login-menu">
				<ul>
					<li><a href="register.html">Register</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="/back/vendors/images/login-page-img.png" alt="" />
				</div>
				<div class="col-md-6 col-lg-5">
					@yield('content')
				</div>
			</div>
		</div>
	</div>
	<!-- welcome modal start -->
	<div class="welcome-modal">
		<button class="welcome-modal-close">
			<i class="bi bi-x-lg"></i>
		</button>
		<iframe class="w-100 border-0" src="https://embed.lottiefiles.com/animation/31548"></iframe>
		<div class="text-center">
			<h3 class="h5 weight-500 text-center mb-2">
				Open source
				<span role="img" aria-label="gratitude">❤️</span>
			</h3>
			<div class="pb-2">
				<a class="github-button" href="https://github.com/dropways/deskapp"
					data-color-scheme="no-preference: dark; light: light; dark: light;" data-icon="octicon-star"
					data-size="large" data-show-count="true"
					aria-label="Star dropways/deskapp dashboard on GitHub">Star</a>
				<a class="github-button" href="https://github.com/dropways/deskapp/fork"
					data-color-scheme="no-preference: dark; light: light; dark: light;" data-icon="octicon-repo-forked"
					data-size="large" data-show-count="true"
					aria-label="Fork dropways/deskapp dashboard on GitHub">Fork</a>
			</div>
		</div>
		<div>
			<a href="https://github.com/dropways/deskapp" target="_blank" class="btn btn-light btn-block btn-sm">
				<span class="text-danger weight-600">STAR US</span>
				<span class="weight-600">ON GITHUB</span>
				<i class="fa fa-github"></i>
			</a>
		</div>
		<p class="font-14 text-center mb-1 d-none d-md-block">
			Available in the following technologies:
		</p>
		<div class="d-none d-md-flex justify-content-center h1 mb-0 text-danger">
			<i class="fa fa-html5"></i>
		</div>
	</div>
	<!-- welcome modal end -->
	<!-- js -->
	<script src="/back/vendors/scripts/core.js"></script>
	<script src="/back/vendors/scripts/script.min.js"></script>
	<script src="/back/vendors/scripts/process.js"></script>
	<script src="/back/vendors/scripts/layout-settings.js"></script>
	@stack('scripts')
</body>

</html>