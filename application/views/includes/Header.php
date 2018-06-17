<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<title>Simple Memory Translation App</title>
	<base href="<?=base_url()?>">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="assets/css/plugins/jquery-ui/jquery-ui.min.css">
	<!-- PageGuide -->
	<link rel="stylesheet" href="assets/css/plugins/pageguide/pageguide.css">
	<!-- chosen -->
	<link rel="stylesheet" href="assets/css/plugins/chosen/chosen.css">
	<!-- select2 -->
	<link rel="stylesheet" href="assets/css/plugins/select2/select2.css">
	<!-- icheck -->
	<link rel="stylesheet" href="assets/css/plugins/icheck/all.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="assets/css/themes.css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">

	<!-- jQuery -->
	<script src="assets/js/jquery.min.js"></script>


	<!-- Nice Scroll -->
	<script src="assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
	<!-- jQuery UI -->
	<script src="assets/js/plugins/jquery-ui/jquery-ui.js"></script>
	<!-- Touch enable for jquery UI -->
	<script src="assets/js/plugins/touch-punch/jquery.touch-punch.min.js"></script>
	<!-- slimScroll -->
	<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="assets/js/bootstrap.min.js"></script>
	<!-- Bootbox -->
	<script src="assets/js/plugins/bootbox/jquery.bootbox.js"></script>
	<!-- Bootbox -->
	<script src="assets/js/plugins/form/jquery.form.min.js"></script>
	<!-- PageGuide -->
	<script src="assets/js/plugins/pageguide/jquery.pageguide.js"></script>
	<!-- Chosen -->
	<script src="assets/js/plugins/chosen/chosen.jquery.min.js"></script>
	<!-- select2 -->
	<script src="assets/js/plugins/select2/select2.min.js"></script>
	<!-- icheck -->
	<script src="assets/js/plugins/icheck/jquery.icheck.min.js"></script>
		<!-- Validation -->
	<script src="assets/js/plugins/validation/jquery.validate.min.js"></script>
	<script src="assets/js/plugins/validation/additional-methods.min.js"></script>
	<!--Notification!-->
	<script type="text/javascript" src="assets/js/plugins/notifications/noty.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/notifications/jgrowl.min.js"></script>

	<!--Notification!-->
	<script type="text/javascript" src="assets/js/components_notifications_other.js"></script>	
	<!-- Theme framework -->
	<script src="assets/js/eakroko.min.js"></script>
	<!-- Theme scripts -->
	<script src="assets/js/application.min.js"></script>
	<!-- Just for demonstration -->
	<script src="assets/js/demonstration.min.js"></script>

</head>

<body id="body">
	<div id="navigation">
		<div class="container-fluid">
			<a href="Pages/Index" id="brand">Simple Memory Translator App</a>
			<ul class='main-nav'>
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Search</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="Pages/WaitedWords">Search Waited Words</a>
						</li>
						<li>
							<a href="Pages/WordSearch">Search Words</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="Pages/ValidateSentence">Validate Sentence</a>
				</li>
				<li>
					<a href="Pages/TranslateSentence">Translate Sentence</a>
				</li>
			</ul>
			<div class="user">
			</div>
		</div>
	</div>	
	<div class="container-fluid nav-hidden" id="content">
		<div id="left">
		</div>