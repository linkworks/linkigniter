/**
 * @author gonzalo
 */

 $(document).ready(function() {
  oTable = $('#example').dataTable({
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
});