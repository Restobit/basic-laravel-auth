var lang = require('/resources/lang/hu.json');

$(function () {
    "use strict"; // Start of use strict


});

$(document).ready(function () {
    $('#dataTable').DataTable({
        "bInfo": false,
        "language": {
            "lengthMenu": lang["Show _MENU_ entries"],
            "search": lang.Search + ":",
        },
        "columnDefs": [{
            "targets": [4, 5],
            "orderable": false
        }]
    });
});
