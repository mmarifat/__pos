<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 10/30/2019 10:06 PM
 */
?>
<?php if (isOwner()) { ?>

    <div id="content-nav-right">
        <div class="btn-group float-md-right" role="group">
            <div class="btn-group" role="group">
                <a class="btn btn-outline-blue-grey"
                   href="<?= sysUrl("addCategory") ?>">Add Category</a>
            </div>
        </div>
    </div>
<?php } ?>

<div class="table-responsive">
    <table class="table table-striped table-bordered serverSide-table dtr-inline">
        <thead>
        <tr>
            <th>Image<br></th>
            <th>Code<br></th>
            <th>Name<br></th>
            <th>Add By</th>
            <th>Add Time<br></th>
			<?php if (isOwner()) { ?>
                <th>Action</th>
			<?php } ?>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Image<br></th>
            <th>Code<br></th>
            <th>Name<br></th>
            <th>Add By</th>
            <th>Add Time<br></th>
			<?php if (isOwner()) { ?>
                <th>Action</th>
			<?php } ?>
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
            order: [[1, "DESC"]],
            "columnDefs": [
                {"visible": false, "targets": [3, 4]},
                {
                    "data": "img",
                    "render": function (data, type, row) {
                        if (data != null)
                            return '<img height="50px" width="50px" class="rounded-circle" src="<?=uploadUrl()?>' + data + '"/>';
                        else
                            return data;

                    },
                    "targets": 0
                },
                {
                    "render": function (data, type, row) {
                        return moment(data).format("ddd, MMM DD,Y-hh:mm A");
                        return data;
                    },
                    "targets": [4]
                }
            ],
			<?php if(isOwner()) { ?>
            'aoColumns': [{mData: "image"}, {mData: "code"}, {mData: "name"}, {mData: "addedBy"},
                {mData: "addedTime"}, {mData: "actions", bSortable: false}],
			<?php } else { ?>
            'aoColumns': [{mData: "image"}, {mData: "code"}, {mData: "name"}, {mData: "addedBy"},
                {mData: "addedTime"}],
			<?php } ?>
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "all"]],
            "iDisplayLength": 10,
            'bProcessing': true,
            "language": {
                processing: '<div><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>'
            },
            'bServerSide': true,
            'sAjaxSource': '<?= sysUrl("getCategories") ?>',
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
                // console.log(nRow);
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
            {column_number: 1, filter_default_label: "Type ...", filter_type: "auto_complete"},
            {column_number: 2, filter_default_label: "Type ...", filter_type: "auto_complete"},
            {
                column_number: 3,
                filter_type: 'select',
                filter_default_label: "Select",
                data:<?= json_encode($addedByOwner) ?>
            },
            {
                column_number: 4, filter_default_label: ["From Date", "End Date"],
                filter_type: "range_date",
                date_format: 'dd M, yyyy',
                filter_delay: 100,
                filter_reset_button_text: "<i class='fa fa-close'></i>"
            },
        ], "header");
    }
</script>


