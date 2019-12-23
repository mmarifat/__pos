<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 11/30/2019 9:24 AM
 */
?>

<div id="content-nav-right">
    <div class="btn-group float-md-right" role="group">
        <div class="btn-group" role="group">
            <a class="btn btn-outline-blue-grey"
               href="<?= posUrl() ?>">Add Sale</a>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered serverSide-table dtr-inline">
        <thead>
        <tr>
            <th>Date<br></th>
            <th>Sale Reference<br></th>
            <th>Product Name<br></th>
            <th class="text-center">Price<br></th>
            <th class="text-center">Quantity<br></th>
            <th class="text-center">Subtotal<br></th>
			<?php if (isOwner()) { ?>
                <th class="text-center">Cost Subtotal<br></th>
			<?php } ?>
            <th class="text-center">Discount<br></th>
            <th>Add By<br></th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Date<br></th>
            <th>Sale Ref<br></th>
            <th>Product Name<br></th>
            <th class="text-center">Price<br></th>
            <th class="text-center">Quantity<br></th>
            <th class="text-center">Subtotal<br></th>
			<?php if (isOwner()) { ?>
                <th class="text-center">Cost Subtotal<br></th>
			<?php } ?>
            <th class="text-center">Discount<br></th>
            <th>Add By<br></th>
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
				<?php if(isOwner()) {?>
                {"visible": false, "targets": [1, 3, 6, 7, 8]},
				<?php } else {?>
                {"visible": false, "targets": [1, 3, 7]},
				<?php } ?>
                {
                    "render": function (data, type, row) {
                        return moment(data).format("ddd, MMM DD,Y-hh:mm A");
                    },
                    "targets": [0]
                },
                {
                    "render": function (data, type, row) {
                        return '<?=CURRENCY?>' + data;
                    },
					<?php if(isOwner()) {?>
                    "targets": [3, 5, 6, 7]
					<?php } else {?>
                    "targets": [3, 5, 6]
					<?php } ?>
                },
            ],
			<?php if(isOwner()) {?>
            'aoColumns': [{mData: "saleDate"}, {mData: "reference"}, {mData: "name"}, {mData: "salePrice"}, {mData: "qty"},
                {mData: "subTotal"}, {mData: "orgSubTotal"}, {mData: "discount"}, {mData: "addBy"}],
			<?php } else { ?>
            'aoColumns': [{mData: "saleDate"}, {mData: "reference"}, {mData: "name"}, {mData: "salePrice"}, {mData: "qty"},
                {mData: "subTotal"}, {mData: "discount"}, {mData: "addBy"}],
			<?php }?>
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "all"]],
            "iDisplayLength": 10,
            'bProcessing': true,
            "language": {
                processing: '<div><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>'
            },
            'bServerSide': true,
            'sAjaxSource': '<?= posUrl("getProductsSales") ?>',
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
                col = [3, 4, 5, 6, 7];
                for (let i = 0; i < col.length; i++) {
                    total = api.column(col[i]).data().sum();
                    $(api.table().column(col[i]).footer()).html(
                        '</span><span class="badge badge-pill badge-secondary">Total: ' + total + '</span>'
                    );
                }
            },
            dom: '<"pull-left"B><"pull-right"f>rt<"pull-right"l>ip',
            //dom: 'Blfrtip',
            buttons:
                [
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
                    }, 'colvis'
                ]
        });
        yadcf.init(Table, [
            {
                column_number: 0, filter_default_label: ["From Date", "End Date"],
                filter_type: "range_date",
                date_format: 'dd M, yyyy',
                filter_delay: 100,
                filter_reset_button_text: "<i class= 'fa fa-close'></i>"
            },
            {column_number: 1, filter_type: "auto_complete", filter_default_label: "Type ..."},
            {column_number: 2, filter_type: "auto_complete", filter_default_label: "Type ..."},
            {column_number: 3, filter_type: "auto_complete", filter_default_label: "Type ..."},
            {column_number: 4, filter_type: "auto_complete", filter_default_label: "Type ..."},
            {column_number: 5, filter_type: "auto_complete", filter_default_label: "Type ..."},
            {column_number: 6, filter_type: "auto_complete", filter_default_label: "Type ..."},
			<?php if (isOwner()) {?>
            {column_number: 7, filter_type: "auto_complete", filter_default_label: "Type ..."},
			<?php }?>
        ], "header");
    }
</script>
