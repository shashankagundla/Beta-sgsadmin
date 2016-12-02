<?php
/*
 * Page Setup
 */
$page = 'Change Crew Colors';
require_once("../../includes/init.php");
echo $template->header($page,$subtitle);
/*
 * Init schedule class and get required info
 */
?>
<div class="row">
    <div class="table-padding">
        <table id="dt" class="table table-striped table-bordered table-condensed table-list" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Color</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?php
/*
 * Page footer and notifications
 */
echo $template->footer();
echo $template->notify();
?>
<script src="/assets/js/datatables.min.js"></script>
<script>
    var editor; // use a global for the submit and return data rendering in the examples
    $(document).ready(function() {
        editor = new $.fn.dataTable.Editor( {
            ajax: "/includes/queries/crew.color.table.php",
            table: "#dt",
            fields: [
                {
                    label: "Name:",
                    name: "employee.display_name",
                    type: "text"
                },
                {
                    label: "Color:",
                    name: "employee.color",
                    attr: {
                        type:'color'
                    }
                }
            ]
        } );
        var dt = $('#dt').DataTable( {
            dom:
            "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            ajax: {
                url: "/includes/queries/crew.color.table.php",
                type: "POST"
            },
            serverSide: true,
            stateSave: true,
            stateDuration: 221198760,
            lengthMenu: [[20, 50, 100, 250, 500], [20, 50, 100, 250, 500]],
            columnDefs: [{
                orderable: false,
                searchable: false,
                className: 'select-checkbox',
                data: null,
                defaultContent: '',
                targets: 0
                },
                { name: "1", data: "employee.display_name", targets: 1 },
                {   name: "2",
                    data: "employee.color",
                    targets: 2,
                    render: function ( data, type, full, meta ) {
                        return '<img src="http://www.googlemapsmarkers.com/v1/'+data.substring(1, 7)+'">';
                    }
                }
            ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            responsive: false,
            colReorder: true,
            fixedColumns: {
                leftColumns: 2
            },
            order: [[ 1, "asc" ]],
            buttons: [
                { extend: "edit",   editor: editor },
                {
                    text: 'Reset',
                    action: function () {
                        dt.state.clear();
                        window.location.reload();
                    }
                }
            ]
        } );
    } );
</script>
