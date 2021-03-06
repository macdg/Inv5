<?php
class Up_xml extends CI_Controller {

public function __construct() {
	
	parent::__construct();
	$this->load->helper('file', 'form', 'html', 'url','directory', 'array');
	$this->load->database();
	$this->load->model('Up_xml_model', 'up_xml_model');
	$this->load->library('form_validation');
	
}


public function index() {

	$this->load->view('up_view');

}


public function subiendo_archivo() {
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

	if (is_uploaded_file($_FILES['mi_archivo_1']['tmp_name'])) {
	 		
	 	$nombreDirectorio = "/var/www/html/final/ci/application/uploads/";
 		$nombreFichero = $_FILES['mi_archivo_1']['name'];
 		$rutaCompleta = $nombreDirectorio . $nombreFichero;

	 	if (file_exists($nombreDirectorio.$nombreFichero)) {
			$datos['primera'] = 'El archivo: ';
			$datos['segunda'] = ' , ya se cargo con anterioridad. Seleccione otro archivo.';
			$datos['nombreFichero']=$nombreFichero;
			$val_p=$this->load->view('success', $datos);
			return ($val_p);
			exit();
		}
				$val_ext=substr($nombreFichero,-4);
				$exten1=".xml";
				$exten2=".XML";
				
					if ( ($val_ext != $exten1) && ($val_ext != $exten2) ) {

						$datos1['invalido'] = 'Extensión del archivo invalido: ';
						$datos1['invalido_a'] ='  . Seleccione otro archivo.';
						$datos1['val_ext']=$val_ext;
						$val_p1=$this->load->view('success', $datos1);
					
						return ($val_p1);
						exit();		
					} 
							move_uploaded_file($_FILES['mi_archivo_1']['tmp_name'],$rutaCompleta);
							echo $this->conv_xmlarreglo($rutaCompleta);				
 	}	else {

 			$datos2['no_up'] = 'No selecciono archivo.';
			$val_up=$this->load->view('success', $datos2);
			return ($val_up);
			exit();
		}

}


public function conv_xmlarreglo($rutaCompleta) {
	
	$this->load->helper('xml2array');
	$contents= file_get_contents($rutaCompleta);
	$result = xml2array($contents,1,'attribute');
 	echo $this->cam_estructura($result);

}


public function cam_estructura($result) {

	if (!isset($result['cfdi:Comprobante']['cfdi:Conceptos']['cfdi:Concepto'][0]))
		$result['cfdi:Comprobante']['cfdi:Conceptos']['cfdi:Concepto'] = array(0 => $result['cfdi:Comprobante']['cfdi:Conceptos']['cfdi:Concepto']);
		echo $this->asignando_var($result);

}


public function asignando_var($result) {

	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	$cont=count($result['cfdi:Comprobante']['cfdi:Conceptos']['cfdi:Concepto']);

		for ($i=0; $i<$cont; $i++) {

 			foreach ($result['cfdi:Comprobante']['cfdi:Conceptos']['cfdi:Concepto'][$i]['attr'] as $e => $val) {
 		 	
				if ($e == 'cantidad')
					$cantidad = (int) $val;
				if ($e == 'unidad')
					$unidad = $val;
				if ($e == 'descripcion')
					$descrip = $val;
				if ($e == 'valorUnitario')
					$val_unit = $val;

					$unificar_unidad= array('PIEZA', 'Pieza', 'pieza', 'PZA', 'Pza', 'pza', 'PZ', 'pz','Pz', 'P', 'p');

						foreach ($unificar_unidad as $key_u => $value_u) {
			
							if ($value_u === $unidad)
								$unidad ='PZA';
						}

							$datos_concepto_c[$i] = $cantidad;
 							$datos_concepto_u[$i] = $unidad;
 							$datos_concepto_d[$i] = $descrip;
 							$datos_concepto_v[$i] = $val_unit;
			}
 		}

 			if (isset($datos_concepto_d)) {
				$descrip_eliminar= array('BOLSA CAMISETA MEDIANA 40+20X60', 'Bolsa Camiseta Mediana 40+20X60', 'Bolsa camiseta mediana 40+20X60', 'bolsa Camiseta mediana 40+20X60', 'bolsa camiseta Mediana 40+20X60', 'bolsa camiseta mediana 40+20X60', 'TARJETA DE LEALTAD', 'Tarjeta de Lealtad', 'tarjeta de lealtad', 'Tarjeta de lealtad', 'tarjeta de Lealtad');
					foreach ($descrip_eliminar as $key => $value) {
						foreach ($datos_concepto_d as $key_d => $value_d) {
								if ($datos_concepto_d[$key_d] === $descrip_eliminar[$key] ) {												
									unset($datos_concepto_c[$key_d]);
				 					unset($datos_concepto_u[$key_d]);
									unset($datos_concepto_d[$key_d]);
									unset($datos_concepto_v[$key_d]);
								}
						}
 					}
 			}
 		
 			$cont = count($datos_concepto_d);
 			foreach ($result['cfdi:Comprobante']['cfdi:Complemento']['tfd:TimbreFiscalDigital']['attr'] as $s => $vu) {
				if ($s=='UUID')
					$id_uuid=$vu;
			}

				foreach ($result['cfdi:Comprobante']['cfdi:Emisor']['cfdi:DomicilioFiscal']['attr'] as $ke => $vue) {
					if ($ke=='calle')
						$calle=$vue;
					if ($ke=='noExterior')
						$no_ext=$vue;
					if ($ke=='noInterior')
						$no_int=$vue;	
					if ($ke=='colonia')
						$colonia=$vue;
					if ($ke=='referencia')
						$referen=$vue;
					if ($ke=='municipio')
						$mun=$vue;
					if ($ke=='estado')
						$estado=$vue;
					if ($ke=='pais')
						$pais=$vue;
					if ($ke=='codigoPostal')
						$cp=$vue;
				}

					foreach ($result['cfdi:Comprobante']['cfdi:Emisor']['attr'] as $ky => $l) {
						if ($ky=='rfc')
							$id_rfc=$l;
						if ($ky=='nombre')
							$rfc_nom=$l;
					}

						foreach ($result['cfdi:Comprobante']['attr'] as $cy => $ll) {

							if ($cy=='fecha')
								$fecha=$ll;
							if ($cy=='subTotal')
								$subtotal=$ll;
							if ($cy=='Moneda')
								$moneda=$ll;
							if ($cy=='total')
								$total=$ll;
						}

							$moneda1= array('Dolares', 'Dólares', 'dolares', 'dólares', 'dll', 'Dll','usd', 'USD', 'usa', 'USA', 'Dollar','dollar', 'dl', 'Dl', 'american', 'americana', 'American', 'Americana');
							foreach ($moneda1 as $value => $key) {
								if ($key === $moneda)
									$moneda_n ='USD';
							}

								$moneda2= array('Pesos', 'pesos', 'peso', 'Peso', 'PESOS', 'PESO', 'Moneda Nacional', 'moneda nacional','moneda Nacional', 'Moneda nacional', 'mx', 'MX', 'Mx', 'MN', 'mn', 'Mn', 'mex', 'Mex', 'MEX', 'MXN', 'Mxn', 'MXn', 'MxN', 'mxn', 'mxN', 'MXP', 'mxp', 'MXp', 'Mxp', 'MxP', 'mXP');
								foreach ($moneda2 as $value_m => $key_m) {
									if ($key_m === $moneda)
										$moneda_n ='MXN';
								}
			
									$datos_concepto['id_uuid']=$id_uuid;
									$datos_concepto['cantidad']=$datos_concepto_c;
									$datos_concepto['descrip']=$datos_concepto_d;
									$datos_concepto['val_unit']=$datos_concepto_v;
									$datos_concepto['unidad']=$datos_concepto_u;

									$datos_proveedor['id_rfc']=$id_rfc;
									$datos_proveedor['rfc_nom']=$rfc_nom;
									$datos_proveedor['calle']=$calle;
									$datos_proveedor['no_ext']=$no_ext;
									$datos_proveedor['no_int']=$no_int;
									$datos_proveedor['colonia']=$colonia;
									$datos_proveedor['referen']=$referen;
									$datos_proveedor['mun']=$mun;
									$datos_proveedor['estado']=$estado;
									$datos_proveedor['pais']=$pais;
									$datos_proveedor['cp']=$cp;

									$datos_factura['id_uuid']=$id_uuid;
									$datos_factura['rfc_nom']=$rfc_nom;
									$datos_factura['fecha']=$fecha;
									$datos_factura['subtotal']=$subtotal;
									$datos_factura['moneda']=$moneda_n;
									$datos_factura['total']=$total;
									$datos_factura['id_rfc']=$id_rfc;

									$ch=$this->load->view('form_xml',$datos_concepto, $cantidad, TRUE);
									echo $this->x($datos_concepto, $datos_proveedor, $datos_factura, $cont);

}


public function x($datos_concepto, $datos_proveedor, $datos_factura, $cont) {

	$igual=$datos_concepto['id_uuid'];
	$q_id_uuid=$this->up_xml_model->query_iduuid();
		foreach ($q_id_uuid as $key => $value_iduuid) {
			if ($value_iduuid === $igual) {
				$datos3['m3'] = 'Ya existe este registro en la DB.';
				$si_existe=$this->load->view('success', $datos3);
				return ($si_existe);
				exit();
			}
	 	}

			$this->up_xml_model->insert_concepto($datos_concepto, $cont);
	 	 	foreach ($q_id_uuid as $valu){
  				if ($igual === $valu) {
  					$datos3['m3'] = 'Ya existe este registro en la DB.';
					$si_existe=$this->load->view('success', $datos3);
				return ($si_existe);
				exit();
    			}
  			}

				$id_uuid=$datos_factura['id_uuid'];
				$fecha=$datos_factura['fecha'];
				$subtotal=$datos_factura['subtotal'];
				$moneda=$datos_factura['moneda'];
				$total=$datos_factura['total'];
				$id_rfc=$datos_factura['id_rfc'];

				$this->up_xml_model->factura_data_insert(
				$id_uuid,
				$fecha,
				$subtotal,
 				$moneda,
				$total,
				$id_rfc
 				);

				$q_idrfc_proveedor=$this->up_xml_model->query_idrfc();
				foreach ($q_idrfc_proveedor as $row)
					$cambiar=$row;
 			
 					$id_rfc=$datos_proveedor['id_rfc'];
					if ($cambiar != $id_rfc ) {
						$id_rfc=$datos_proveedor['id_rfc'];
						$rfc_nom=$datos_proveedor['rfc_nom'];
						$calle=$datos_proveedor['calle'];
						$no_ext=$datos_proveedor['no_ext'];
						$no_int=$datos_proveedor['no_int'];
						$colonia=$datos_proveedor['colonia'];
						$referen=$datos_proveedor['referen'];
						$mun=$datos_proveedor['mun'];
						$estado=$datos_proveedor['estado'];
						$pais=$datos_proveedor['pais'];
						$cp=$datos_proveedor['cp'];
								
						$this->up_xml_model->proveedor_data_insert(
						$id_rfc,
						$rfc_nom,
						$calle,
						$no_ext,
						$no_int,
						$colonia,
						$referen,
						$mun,
						$estado,
						$pais,
						$cp
						);
					}
  					  
}


public function solicitar2() {

	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	$id_uuid = $this->input->post('id_concepto');
	$cont = $this->input->post('cont_datos_concepto');
	$cantidad_total=$this->input->post();
	$cantidad = $this->input->post('canti');
	$noserie = $this->input->post('noserie');
	$elementos=count($cantidad);

	foreach ($noserie as $key => $value)
		$varx=$value;
	
			if ($varx == NULL) {
				for ($j=0; $j<$elementos; $j++) {
					$this->form_validation->set_rules('noserie', 'Número de Serie', 'required');
					 echo validation_errors();
								
						if ($this->form_validation->run()==FALSE) {
							$datos4['m4'] = 'No puede dejar campo(s) vacio(s).';
							$valida_camp=$this->load->view('success', $datos4);
							return ($valida_camp);
							exit();

							$q_idproductos=$this->up_xml_model->query_idproductos();
							foreach ($q_idproductos as $key => $value_q)
								$d_ant=$value_q;																				
   								
   									$d_antmas1=$d_ant+1;
   									exit();
										
						}

				}
 			}

				if ($varx != NULL ) {
					$this->up_xml_model->insert_in($noserie, $elementos);

				// ***Bloque para traer el id_concepto de la tabla CONCEPTO hacia el registro id_concepto de la tabla PRODUCTOS de acuerdo a la cantidad de registros ingresados por el usuario. ****
					$q_id_c_c_concepto=$this->up_xml_model->id_c_c_concepto();
					$dato_de_idconcepto_concepto=$q_id_c_c_concepto['dato_de_idconcepto_concepto'];
					$dato_de_cantidad_concepto=$q_id_c_c_concepto['dato_de_cantidad_concepto'];
					$contando_split=$q_id_c_c_concepto['contando_split'];
					// *** Fin de Bloque. ***
					// Esta línea se tuvo que agregar así para poder identificar el útimo dato a insertar en concepto, ya que la función $this->db->insert_id($consultar_concepto); no puede traer el último id, por que aquí no fue lo último q se escribío en la db sino la útima fue la de productos, por eso el dato que me trae es es el de id anterior pero de productos por que es lo último grabado en la DB, por ello la línea de abajo extrae el último id de la tabla concepto.
					$d_ant_concepto = end($dato_de_idconcepto_concepto);
					
					$q_id_c_p_productos=$this->up_xml_model->id_c_p_productos();
					$d_ant_productos=$q_id_c_p_productos['d_ant_productos'];
					$dato_de_id_productos=$q_id_c_p_productos['dato_de_id_productos'];
					$dato_de_idconcepto_productos=$q_id_c_p_productos['dato_de_idconcepto_productos'];

				// *** Bloque independiente ****
					for ($i=0; $i<$contando_split; $i++) { 
						$j=$dato_de_cantidad_concepto[$i];
							while ( $j != 0) {
								$n_id_concepto[]=$dato_de_idconcepto_concepto[$i];
								$j--;
						 	}
					}

						$this->up_xml_model->update_productos($d_ant_productos, $n_id_concepto, $dato_de_id_productos);
				// *** Fin de Bloque. ***

						$consulta_vacio=$this->up_xml_model->con_noserie_productos();
						foreach ($consulta_vacio->result_array() as $rw) {
					   		$evaluar=$rw['noserie'];

							while ($evaluar == NULL) {
								$consulta2 = $this->up_xml_model->id_productos_productos();
								$d_ant2=$consulta2;
								$datos4['m4'] = 'No puede dejar campo(s) vacio(s).';
								$valida_camp=$this->load->view('success', $datos4);
								return ($valida_camp);
								exit();
							}
						}
				}
					$d_final['finalizar']='finalizar';
					$finalizar=$this->load->view('success', $d_final);
					return ($finalizar);
					exit();
							
}


}
