<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

var_dump($_REQUEST);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>cascaron</title>
</head>
<body>

</body>
</html>

<script type="text/javascript">
$('#loaderContainer').show();
$(document).ready(function(){
	$('#loaderContainer').hide();
});
</script>