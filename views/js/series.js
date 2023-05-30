function valoresLista(){
	var table = $('.tablas').DataTable( {
		destroy: true,
		processing: true,
		serverSide: true,
		responsive: true,
		bAutoWidth: true,
    	lengthChange: false,
		pageLength: 10,
		ajax :{
			url:'ajax/valores.ajax.php',
			type:'POST'
		},
		columnDefs: [
			{ "orderable": false, "target": 1 }
        ]
    });
}