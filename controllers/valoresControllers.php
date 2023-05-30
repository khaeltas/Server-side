<?php
class ValoresControllers
{
    static public function mostrarValoresControllers($tabla, $where, $orderBy)
    {
        $respuesta = ValoresModels::mostrarValoresModels($tabla, $where, $orderBy);
        return $respuesta;
    }
}