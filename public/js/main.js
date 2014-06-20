$(document).ready(function() {
    $('table.datatables').dataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "ajax/stock_data",
        "order": [[ 2, "desc" ]]
    } );
} );