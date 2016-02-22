<?php $this->load->helper('html');
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Pagina de Exito</title>
</head>
	<body>
  		<center><?php if (isset($finalizar)): echo br(3);?>
  			<h1> ¡¡ Su archivo o petición fue procesada. !!</h1>
  				<div>
  					<?php echo anchor('index.php/up_xml/index', heading('Finalizar', 2) ); endif; ?>
				</div>
								
				<div>
					<h3><?php if(isset($primera)): echo br(3).$primera.$nombreFichero.$segunda; ?> </h3>
					<form name="buttonbar"><input type="button" value="Regresar" onClick="history.back()"> </form><?php endif;?>
				</div>
				
				<div>
					<h3><?php if(isset($invalido)): echo br(3).$invalido.$val_ext.$invalido_a; ?> </h3>
					<form name="buttonbar"><input type="button" value="Regresar" onClick="history.back()"> </form><?php endif;?>
				</div>

				<div>
					<h3><?php if(isset($no_up)): echo br(3).$no_up; ?></h3>
					<form name="buttonbar"><input type="button" value="Regresar" onClick="history.back()"> </form><?php endif;?>
				</div>

				<div>
					<h3><?php if(isset($m3)): echo br(3).$m3; ?> </h3>
					<form name="buttonbar"><input type="button" value="Regresar" onClick="history.back()"> </form><?php endif;?>
				</div>

				<div>
					<center>
					<h3><?php if(isset($m4)): echo br(3).$m4; ?> </h3>
					<form name="buttonbar"><input type="button" value="Regresar" onClick="history.back()"> </form><?php endif;?>
					</center>
				</div>
		</center>
</body>
</html>
