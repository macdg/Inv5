<?php $this->load->helper('html');
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Pagina de Exito</title>
</head>
	<body>
  		<center><?php if (isset($finalizar)) :echo br(3); ?>
  			<h1> ¡¡ Su archivo fue procesado. !!</h1>
  				<div>
  					<?php echo anchor('index.php/up_xml_c/index', heading('Finalizar', 2)); endif; ?>
				</div>
								
				<div>
					<h3><?php if(isset($primera)) : echo br(3); ?> 
                        El archivo: <?php  echo $nombreFichero; ?>  , ya se cargo con anterioridad. Seleccione otro archivo. </h3>
					<form name="buttonbar"><input type="button" value="Regresar" onClick="history.back()"> </form><?php endif;?>
				</div>
				
				<div>
					<h3><?php if(isset($invalido)): echo br(3) ?> Extensión del archivo invalido:  <?php echo $val_ext; ?>  . Seleccione otro archivo. </h3>
					<form name="buttonbar"><input type="button" value="Regresar" onClick="history.back()"> </form><?php endif;?>
				</div>

				<div>
					<h3><?php if(isset($no_up)): echo br(3); ?> No selecciono archivo. </h3>
					<form name="buttonbar"><input type="button" value="Regresar" onClick="history.back()"> </form><?php endif;?>
				</div>

				<div>
					<h3><?php if(isset($m3)): echo br(3); ?> Ya existe este registro en la DB. </h3>
					<form name="buttonbar"><input type="button" value="Regresar" onClick="history.back()"> </form><?php endif;?>
				</div>

				<div>
					<center>
					<h3><?php if(isset($m4)): echo br(3); ?> No puede dejar campo(s) vacio(s). </h3>
					<form name="buttonbar"><input type="button" value="Regresar" onClick="history.back()"> </form><?php endif;?>
					</center>
				</div>
		</center>
</body>
</html>
