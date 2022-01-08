<?php

?>

<?php

?>

<div id="content-nav-right">
    <div class="btn-group float-md-right" role="group">
        <div class="btn-group" role="group">
            <a class="btn btn-outline-blue-grey" modal-toggler="true" data-target="#remoteModal1"
               data-remote="<?= sysUrl("addExpense") ?>">Add Expense</a>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered serverSide-table dtr-inline">
        <thead>
        <tr>
            <th>Date<br></th>
            <th>Reference<br></th>
            <th>Amount<br></th>
            <th>Note<br></th>
            <th>Added By</th>
            <th>Add Time<br></th>
            <th>Action</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Date<br></th>
            <th>Reference<br></th>
            <th>Amount</th>
            <th>Note<br></th>
            <th>Added By</th>
            <th>Add Time<br></th>
            <th>Action</th>
        </tr>
        </tfoot>
        <tbody>
        </tbody>
    </table>
</div>

<script>
    var Table, selectedIDs = [];
    window.onload = function () {
        geTableData();
    };

    function geTableData() {
        Table = $('.serverSide-table').DataTable({
            order: [[0, "DESC"]],
            "columnDefs": [
                {"visible": false, "targets": [4, 5, 6]},
                {
                    "render": function (data, type, row) {
                        return moment(data).format("ddd, MMM DD,Y");
                    },
                    "targets": [0]
                },
                {
                    "render": function (data, type, row) {
                        return "Tk " + data;
                    },
                    "targets": [2]
                },
                {
                    "render": function (data, type, row) {
                        // return '<span class="badge-sm badge-pill badge-dark">' + data + '</span>';
                        return data;
                    },
                    "targets": [4]
                },
                {
                    "render": function (data, type, row) {
                        return moment(data).format("ddd, MMM DD,Y-hh:mm A");
                        return data;
                    },
                    "targets": [5]
                }
            ],
            'aoColumns': [{mData: "date"}, {mData: "reference"}, {mData: "amount"}, {mData: "note"}, {mData: "addedBy"},
                {mData: "addedTime"}, {mData: "actions", bSortable: false}],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "all"]],
            "iDisplayLength": 10,
            'bProcessing': true,
            "language": {
                processing: '<div><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>'
            },
            'bServerSide': true,
            'sAjaxSource': '<?= sysUrl("getExpenses") ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                $.ajax({
                    'dataType': 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': function (d, e, f) {
                        //console.log(f);
                        fnCallback(d, e, f);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        if (jqXHR.jqXHRstatusText)
                            alert(jqXHR.jqXHRstatusText);
                    }
                });
            },
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var api = this.api();
                col = [2];
                for (let i = 0; i < col.length; i++) {
                    total = api.column(col[i]).data().sum();
                    $(api.table().column(col[i]).footer()).html(
                        '</span><span class="badge badge-pill badge-secondary">Total: ' + total + '</span>'
                    );
                }
            },
            dom: '<"pull-left"B><"pull-right"f>rt<"pull-right"l>ip',
            //dom: 'Blfrtip',
            buttons: [
                {
                    extend: "copy",
                    charset: "utf-8",
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            header: function (data, column, row) {
                                return data.split('<')[0];
                            }
                        }
                    }
                },
                {
                    extend: "csv",
                    charset: "utf-8",
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            header: function (data, column, row) {
                                return data.split('<')[0];
                            }
                        }
                    }
                },
                {
                    extend: "excel",
                    charset: "utf-8",
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            header: function (data, column, row) {
                                return data.split('<')[0];
                            }
                        }
                    }
                },
                {
                    extend: "pdf",
                    charset: "utf-8",
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            header: function (data, column, row) {
                                return data.split('<')[0];
                            }
                        }
                    }
                },
                {
                    extend: "print",
                    charset: "utf-8",
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            header: function (data, column, row) {
                                return data.split('<')[0];
                            }
                        }
                    }
                },
                'colvis'
            ]
        });
        yadcf.init(Table, [
            {
                column_number: 0, filter_default_label: ["From Date", "End Date"],
                filter_type: "range_date",
                date_format: 'dd M, yyyy',
                filter_delay: 100,
                filter_reset_button_text: "<i class='fa fa-close'></i>"
            },
            {column_number: 1, filter_default_label: "Type ...", filter_type: "auto_complete"},
            {column_number: 2, filter_default_label: "Type ...", filter_type: "auto_complete"},
            {column_number: 3, filter_default_label: "Type ...", filter_type: "auto_complete"},
            {
                column_number: 4,
                filter_type: 'select',
                filter_default_label: "Select",
                data:<?= json_encode($addedByOwner) ?>
            },
            {
                column_number: 5, filter_default_label: ["From Date", "End Date"],
                filter_type: "range_date",
                date_format: 'dd M, yyyy',
                filter_delay: 100,
                filter_reset_button_text: "<i class='fa fa-close'></i>"
            },
        ], "header");
    }
</script>



