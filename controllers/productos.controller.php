<?php

class ControladorProductos 
{

	/* Mostrar Productos */

	static public function ctrMostrarProductos($item, $valor)
	{

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor);

		return $respuesta;

	}

}
