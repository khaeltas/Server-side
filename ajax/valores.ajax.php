<?php
    require_once "../controllers/valoresControllers.php";
    require_once "../models/valoresModels.php";

    // almacenar petición ( es decir , obtener / post) array global a una variable
    $requestData= $_REQUEST;

    $columns = array( 
        // índice de columna tabla de datos = > nombre de la columna de base de datos
            0 => 'idNroSerie', 
            1 => 'idProducto',
            2 => "nroSerie",
            3 => "estado"
    );

    $tabla ="series";
	$where = " ";
	$orderBy =" ORDER BY idNroSerie ASC";

    //Obtener el total de registros sin ninguna búsqueda
	$respuesta = ValoresControllers::mostrarValoresControllers($tabla, $where, $orderBy);
	$totalData = count($respuesta);

    //Cuando no hay un parámetro de búsqueda el número total de 
	//registros filtrados es igual al total de registros.
	$totalFiltered = $totalData;

    //$where = " WHERE 1=1 AND disponible = 'Si'";
	$where = " WHERE 1=1";

    //Si hay un parámetro de búsqueda , $RequestData [ 'search '] [ ' valor '] 
	//contiene parámetros de búsqueda.
	if( !empty($requestData['search']['value']) ) {  
	    $where.=" AND ( Id LIKE '%".$requestData['search']['value']."%' ";    
	    $where.=" OR datos LIKE '%".$requestData['search']['value']."%')";
	}

    //Obtener el total de registros con parámetros.
	$respuesta = ValoresControllers::mostrarValoresControllers($tabla, $where, $orderBy);

    //Cuando hay un parámetro de búsqueda, tenemos que
	//modificar el total de filas filtradas.
	$totalFiltered = count($respuesta);

    $orderBy=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

    //Obtener el total de registros con parámetros.
	//con el orden y filtro especificados.
	$respuesta = ValoresControllers::mostrarValoresControllers($tabla, $where, $orderBy);

    $data = array();
    $i = 1;

	if (count($respuesta) > 0){
		foreach ($respuesta as $row => $item)
        {
	        $nestedData=array();
	        $nestedData[] = "<kbd>".$i."</kbd>";
	        $nestedData[] = $item['idProducto'];
            $nestedData[] = $item['nroSerie'];
            $nestedData[] = $item['estado'];
            $nestedData[] = "<div class='btn-group float-right'>".
                                "<button type='button' class='btn btn-warning btnEditarSerie' token='".$item['idNroSerie']."' data-toggle='modal' data-target='#modalEditarSerie'><i class='far fa-edit'></i></button>".
                                "<button type='button' class='btn btn-danger btnEliminarSerie' token='".$item["idNroSerie"]."'><i class='fa fa-times'></i></button>".
                            "</div>";
	        $data[] = $nestedData;
            $i++;
	    }
	}

    $json_data = array(
	    "draw"            => intval( $requestData['draw'] ),   
	    "recordsTotal"    => intval( $totalData ),  
	    "recordsFiltered" => intval( $totalFiltered ), 
	    "data"            => $data   
	    );

	echo json_encode($json_data);