<?php
require_once "conexion.php";

class ProductosModels
{
    static public function mostrarProductosModels($tabla, $item, $valor)
    {
        if($item != null)
        {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
			return $stmt -> fetch();
        }
        else
        {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY stock ASC");
			$stmt -> execute();
			return $stmt -> fetchAll();
        }
		$stmt = null;
    }
    static public function mostrarUltimoProductosPorIdCategoriaModels($tabla, $item, $valor)
    {
        try
        {
            // $stmt = Conexion::conectar()->prepare("SELECT idProducto, idCategoria, idUsuario, tokenProducto, foto, MAX(codigo) AS codigo, descripcion, stock, salidas, stockMinimo, precioVenta, precioVentaSus, fechaCreacion, salidaStock, fechaModificacion FROM $tabla WHERE $item = :$item");
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idProducto = (SELECT MAX(idProducto) FROM productos WHERE $item=:$item)");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
            $stmt -> execute();
			return $stmt -> fetch();
        }
        catch (Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    static public function mostrarProductosDesdeTraspasosModels($tabla, $item, $valor)
    {
        try
        {
            $stmt = Conexion::conectar()->prepare("SELECT $tabla.tokenProducto, $tabla.foto, $tabla.codigo, $tabla.descripcion, SUM(compras.stock) AS totalStock, MAX(compras.precioVenta) AS 'precioVenta'
            FROM compras
            INNER JOIN $tabla
            ON compras.idProducto = $tabla.idProducto AND compras.stock > 0 WHERE $tabla.tokenProducto = :tokenProducto GROUP BY $tabla.codigo");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch();
            $stmt = null;
        }
        catch (Exception $ex)
        {
            echo "ERROR: ".$ex->getMessage();
        }
    }

    static public function buscarNombreProductoModels($tabla, $item, $valor)
    {
        try
        {
            $stmt = Conexion::conectar()->prepare("SELECT $tabla * WHERE $item = :$item");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch();
            $stmt = null;
        }
        catch (Exception $ex)
        {
            echo "ERROR: ".$ex->getMessage();
        }
    }

    static public function agregarProductosModels($tabla, $datos)
    {
        try
        {
            // $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idCategoria, idUsuario, tokenProducto, foto, codigo, descripcion, stock, stockMinimo, precioVenta) VALUES (:idCategoria, :idUsuario, :tokenProducto, :foto, :codigo, :descripcion, :stock, :stockMinimo, :precioVenta)");
            $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idCategoria, idUsuario, tokenProducto, foto, codigo, descripcion, stockMinimo, precioVenta) VALUES (:idCategoria, :idUsuario, :tokenProducto, :foto, :codigo, :descripcion, :stockMinimo, :precioVenta)");
            $stmt->bindParam(":idCategoria", $datos["idCategoria"], PDO::PARAM_INT);
            $stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_STR);
            $stmt->bindParam(":tokenProducto", $datos["tokenProducto"], PDO::PARAM_STR);
            $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
            $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            // $stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
            $stmt->bindParam(":stockMinimo", $datos["stockMinimo"], PDO::PARAM_STR);
            $stmt->bindParam(":precioVenta", $datos["precioVenta"], PDO::PARAM_STR);
            if($stmt->execute())
            {
                return "ok";	
    
            }
            else
            {
                return "error";
            
            }
            $stmt = null;
        }
        catch (Exception $ex)
        {
            echo "ERROR: ".$ex->getMessage();
        }
    }

    static public function editarProductosModels($tabla, $datos)
    {
        try
        {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idCategoria=:idCategoria, idUsuario=:idUsuario, foto=:foto, codigo=:codigo, descripcion=:descripcion, stockMinimo=:stockMinimo, fechaModificacion=:fechaModificacion WHERE tokenProducto=:tokenProducto");
            $stmt->bindParam(":idCategoria", $datos["idCategoria"], PDO::PARAM_INT);
            $stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_STR);
            $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
            $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindParam(":stockMinimo", $datos["stockMinimo"], PDO::PARAM_STR);
            $stmt->bindParam(":fechaModificacion", $datos["fechaModificacion"], PDO::PARAM_STR);
            $stmt->bindParam(":tokenProducto", $datos["tokenProducto"], PDO::PARAM_STR);
            if($stmt->execute())
            {
                return "ok";	
    
            }
            else
            {
                return "error";
            
            }
            $stmt = null;
        }
        catch (Exception $ex)
        {
            echo "ERROR: ".$ex->getMessage();
        }
    }

    static public function actualizarProductosModels($tabla, $item, $valor1, $item2, $valor2, $item3, $valor3, $valor)
    {
        try
        {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item, $item2 =:$item2, $item3 =:$item3 WHERE tokenProducto = :tokenProducto");
            $stmt -> bindParam(":".$item, $valor1, PDO::PARAM_STR);
            $stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
            $stmt -> bindParam(":".$item3, $valor3, PDO::PARAM_STR);
            $stmt -> bindParam(":tokenProducto", $valor, PDO::PARAM_STR);

            if($stmt -> execute())
            {
                return "ok";
            }
            else
            {
                return "error";
            }
        }
        catch (Exception $ex)
        {
            echo "ERROR: ".$ex->getMessage();
        }
    }

    static public function actualizarAlEliminarProductosModels($tabla, $item, $valor1, $valor)
    {
        try
        {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE tokenProducto = :tokenProducto");
            $stmt -> bindParam(":".$item, $valor1, PDO::PARAM_STR);
            $stmt -> bindParam(":tokenProducto", $valor, PDO::PARAM_STR);

            if($stmt -> execute())
            {
                return "ok";
            }
            else
            {
                return "error";
            }
        }
        catch (Exception $ex)
        {
            echo "ERROR: ".$ex->getMessage();
        }
    }

    static public function eliminarProductosModels($tabla, $datos)
    {
        try
        {
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE tokenProducto=:tokenProducto");
            $stmt->bindParam(":tokenProducto", $datos, PDO::PARAM_STR);
            if($stmt->execute())
            {
                return "ok";	
    
            }
            else
            {
                return "error";
            
            }
            $stmt = null;
        }
        catch (Exception $ex)
        {
            $numeroError = $ex->getCode();
            if($numeroError == "23000")
            {
                return $numeroError;
            }
            else
            {
                echo "ERROR: ".$ex->getMessage();
            }
        }
    }
}