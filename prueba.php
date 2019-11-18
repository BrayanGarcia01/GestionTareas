<!DOCTYPE html>
<html>
<head>
	<META HTTP-EQUIV="REFRESH" CONTENT=<?php echo "\"0;URL=tareas.php?cedula=".$_GET['cedula']."\""?>>
</head>
<body>
<?php
	unlink($_GET['cedula'].'.json');
?>
</body>
</html>