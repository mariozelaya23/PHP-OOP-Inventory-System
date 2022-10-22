<?php

class Conexion
{
	public static function conectar()
	{
		$link = new PDO("mysql:host=localhost;dbname=oop_inventario","root","");
		$link->exec("set names utf8"); //to get any Latin character without any problem
		return $link;
	}
}