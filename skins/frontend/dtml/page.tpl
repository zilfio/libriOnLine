<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>LibriOnLine - Homepage</title>

<link rel="icon" href="skins/favicon/book.gif" type="image/gif" />

<!-- Bootstrap Core CSS -->
<link href="skins/frontend/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="skins/frontend/css/modern-business.css" rel="stylesheet">

<!-- Custom Fonts -->
<link
	href="skins/frontend/include/font-awesome-4.1.0/css/font-awesome.min.css"
	rel="stylesheet" type="text/css">

<!-- Pagination -->
<link href="skins/frontend/css/pagination.css" rel="stylesheet"
	type="text/css">

<!-- Select2 CSS -->
<link href="skins/backend/include/select2/select2.css" rel="stylesheet">
<link href="skins/backend/include/select2/select2-bootstrap.css"
	rel="stylesheet">

{if $caption}
<!-- My Style CSS -->
<link href="skins/frontend/css/style.css" rel="stylesheet">

<link rel="stylesheet" type="text/css"
	href="skins/frontend/css/animate.min.css">
{/if}
	
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body>

	<!-- Navigation -->
	{include file="navigation.tpl"}

	<!-- Page Content -->
	<div class="container">

		<!-- Marketing Icons Section -->
		{include file="{$body}"}

		<hr>

		<!-- Footer -->
		{include file="footer.tpl"}

	</div>
	<!-- /.container -->

	<!-- jQuery -->
	<script src="skins/frontend/js/jquery.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="skins/frontend/js/bootstrap.min.js"></script>

	<!-- Pagination -->
	<script src="skins/frontend/js/jquery.pajinate.js"></script>

	<!-- Select2 JavaScript -->
	<script src="skins/backend/include/select2/select2.min.js"></script>
	<!-- Select2 Italiano -->
	<script src="skins/backend/include/select2/select2_locale_it.js"></script>

	<!-- Contact Form JavaScript -->
	<!-- Do not edit these files! In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
	{if $contact}
	<script src="skins/frontend/js/jqBootstrapValidation.js"></script>
	<script src="skins/frontend/js/contact_me.js"></script>
	{/if}

	{if $caption}
	<script>
	$( ".thumbnail" )
    .mouseenter(function() {
        $(this).find('.caption').removeClass("flipOutX").addClass("flipInX").show();
    })
    .mouseleave(function() {
        $(this).find('.caption').removeClass("flipInX").addClass("flipOutX");
});            
    </script>
    {/if}
	
	<script>
            	$(document).ready(function(){
            	    $('#books-container').pajinate({
            	    	items_per_page : 8,
            	    	nav_label_first : 'Inizio',
            	    	nav_label_prev : 'Precedente',
            	    	nav_label_next : 'Successivo',
            	    	nav_label_last : 'Fine'
            	    });

            	 	$(".select2").select2();
            	});               
    </script>

</body>

</html>
