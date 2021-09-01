$(document).ready(function(){
    $('#dirTable').DataTable({
        "searching": false,
        "paging": false,
        "info": false,
        "scrollY": "70%",
        "scrollCollapse": true,
        columnDefs: [{
            type: 'file-size',
            targets: 1
        }]
    });
});