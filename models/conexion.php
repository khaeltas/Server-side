<?php

class Conexion
{
    static public function conectar()
    {
        $link = new PDO("mysql:host=localhost;dbname=dolphins_skynet", "dolphins_skynet", "ichKsfC4i9QM");
        $link->exec("set names utf8");
        return $link;
    }
}