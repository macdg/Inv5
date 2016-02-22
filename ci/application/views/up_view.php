<?php $this->load->helper('form'); ?>
<!DOCTYPE html>
<html>

	<head>
		<title>Vista de Up XML</title>
			<meta charset="utf-8"/>
	</head>

<body>
	<br><br><br>
		<center>
		Elije el archivo a Subir.
		<br><br><br><br>
			<form action="<?php echo 'subiendo_archivo'; ?>" method="post" enctype="multipart/form-data">
					Selecciona el archivo con extensión .xml .

					<br><br>
						<input type="file" name="mi_archivo_1" id="m_archivo_1" size="40">
					<br><br>
						<input type="button" value="Borrar" onClick="location='index'"/>

						<input type="submit" value="Subir" name="submit">
						<form name="buttonbar">
					<br><br>
			</form>
 		</center>
		<br><br>

</body>
</html>
