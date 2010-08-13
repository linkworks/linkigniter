var asInitVals = new Array(); // Stores placeholder values for column-specific search boxes

$('document').ready(function() {
  oTable = $('#{table_id}').dataTable({
      "bStateSave": true,
      "bJQueryUI": true,
      "sPaginationType": "full_numbers",
      "oLanguage": {
  	    "sProcessing":   "Procesando...",
    	  "sLengthMenu":   "Mostrar _MENU_ registros",
    	  "sZeroRecords":  "No se encontraron resultados",
    	  "sInfo":         "_START_ - _END_ de _TOTAL_ registros",
    	  "sInfoEmpty":    "0 - 0 de 0 registros",
    	  "sInfoFiltered": "(de _MAX_ registros en total)",
    	  "sInfoPostFix":  "",
    	  "sSearch":       "Buscar:",
    	  "sUrl":          "",
    	  "oPaginate": {
    	    "sFirst":    "<<",
    	    "sPrevious": "<",
    	    "sNext":     ">",
    	    "sLast":     ">>"
  	    },
      },
  	  "fnDrawCallback" : function() {
  			// Load tipTips again
  			load_tiptips();
  		}
	});
  
  // Enable column-specific search
  $("#{table_id} tfoot input").keyup(function () {
  		/* Filter on the column (the index) of this element */
  		oTable.fnFilter( this.value, $("tfoot input").index(this) );
  	} );

	/*
	 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
	 * the footer
	 */
	$("#{table_id} tfoot input").each( function (i) {
		asInitVals[i] = this.value;
	} );

	$("#{table_id} tfoot input").focus(function () {
		if ( this.className == "search_init" )
		{
			this.className = "";
			this.value = "";
		}
	} );

	$("#{table_id} tfoot input").blur(function (i) {
		if ( this.value == "" )
		{
			this.className = "search_init";
			this.value = asInitVals[$("#{table_id} tfoot input").index(this)];
		}
	});
});