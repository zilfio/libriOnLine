<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>LibriOnLine - Dashboard</title>

<link rel="icon" href="skins/favicon/book.gif" type="image/gif" />

<!-- Bootstrap Core CSS -->
<link rel="stylesheet" type="text/css"
	href="skins/backend/include/bootstrap/css/bootstrap.min.css" />

<!-- MetisMenu CSS -->
<link href="skins/backend/css/plugins/metisMenu/metisMenu.min.css"
	rel="stylesheet">

<!-- DataTables CSS -->
<link href="skins/backend/css/plugins/dataTables.bootstrap.css"
	rel="stylesheet">

<!-- Select2 CSS -->
<link href="skins/backend/include/select2/select2.css" rel="stylesheet">
<link href="skins/backend/include/select2/select2-bootstrap.css"
	rel="stylesheet">

<!-- Custom CSS -->
<link href="skins/backend/css/sb-admin-2.css" rel="stylesheet">

<!-- Custom Fonts -->
<link
	href="skins/backend/include/font-awesome-4.1.0/css/font-awesome.min.css"
	rel="stylesheet" type="text/css">

<!-- Custom CSS -->
<link rel="stylesheet" type="text/css"
	href="skins/backend/css/style.css" />

<link href="skins/backend/include/fileupload/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
	
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body>

	<div id="wrapper">

		<!-- Navigation -->
		{include file="backoffice_navigation.tpl"}

		<div id="page-wrapper">{include file="{$body}"}</div>
		<!-- /#page-wrapper -->

	</div>
	<!-- /#wrapper -->

	<!-- jQuery Version 1.11.0 -->
	<script src="skins/backend/js/jquery-1.11.0.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script type="text/javascript"
		src="skins/backend/include/bootstrap/js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script src="skins/backend/js/plugins/metisMenu/metisMenu.min.js"></script>

	<!-- Morris Charts JavaScript -->
	<!--<script src="js/plugins/morris/raphael.min.js"></script>
        <script src="js/plugins/morris/morris.min.js"></script>
        <script src="js/plugins/morris/morris-data.js"></script>-->

	<!-- DataTables JavaScript -->
	<script src="skins/backend/js/plugins/dataTables/jquery.dataTables.js"></script>
	<script
		src="skins/backend/js/plugins/dataTables/dataTables.bootstrap.js"></script>

	<!-- Select2 JavaScript -->
	<script src="skins/backend/include/select2/select2.min.js"></script>
	<!-- Select2 Italiano -->
	<script src="skins/backend/include/select2/select2_locale_it.js"></script>

	<!-- CKEDITOR JavaScript -->
	<script src="skins/backend/include/ckeditor/ckeditor.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="skins/backend/js/sb-admin-2.js"></script>

	<script src="skins/backend/include/fileupload/js/fileinput.min.js" type="text/javascript"></script>
	
	<script>
            $(document).ready(function() {

            	$("#electronic_copy").fileinput();
                
            	/*$('#reset').click(function() {
					$('#prova').val($('#prova').prop('defaultSelected'));
				});*/

                $('.table-paginated').dataTable({
                    "pagingType": "full_numbers",
					"language": {
						"lengthMenu": "Visualizza _MENU_ elementi",
						"zeroRecords": "La ricerca non ha portato alcun risultato",
						"info": "Vista da _START_ a _END_ di _TOTAL_ elementi",
						"infoEmpty": "Nessun dato presente nella tabella",
						"infoFiltered": "(filtrati da _MAX_ elementi totali)",
						"loadingRecords": "Caricamento...",
						"processing": "Elaborazione...",
						"search": "Cerca:",
						"paginate": {
							"first": "Inizio",
					        "previous": "Precedente",
					        "next": "Successivo",
					        "last": "Fine"

						},
						"aria": {
							"sortAscending": "- click/return to sort ascending",
							"sortDescending": "- click/return to sort descending"
						}
					}
                });
                
                $(".select2").select2();
                CKEDITOR.replace('recensione');
                
            });
        </script>

</body>

</html>
