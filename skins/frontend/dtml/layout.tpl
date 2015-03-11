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
        
        <!-- My Style CSS -->
        <link href="skins/frontend/css/style.css" rel="stylesheet">
        
        <link rel="stylesheet" type="text/css" href="skins/frontend/css/animate.min.css">
        
        <!-- Bootstrap Core CSS -->
        <link href="skins/frontend/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="skins/frontend/css/modern-business.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="skins/frontend/include/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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

        <!-- Header Carousel -->
        {include file="header.tpl"}

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
        
        <!-- Script to Activate the Carousel -->
        <script>
        $( document ).ready(function() {
    	 	$('.carousel').carousel({
            	interval: 5000 //changes the speed
            });

    	 	$( ".thumbnail" )
    	    .mouseenter(function() {
    	        $(this).find('.caption').removeClass("fadeOutUp").addClass("fadeInDown").show();
    	    })
    	    .mouseleave(function() {
    	        $(this).find('.caption').removeClass("fadeInDown").addClass("fadeOutUp");
    	});
            
		});
        </script>

    </body>

</html>