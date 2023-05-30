<?php
require_once "conexion.php";
class ValoresModels
{
    static public function mostrarValoresModels($tabla, $where, $orderBy)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla $where $orderBy");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt = null;
    }
}