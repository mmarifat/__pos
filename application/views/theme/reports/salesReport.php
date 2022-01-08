<?php

?>

<div class="row justify-content-center animated pulse">
    <div class="col-xl-2 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-darken-2">
                        <i class="icon-basket-loaded font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-primary white media-body">
                        <h5> Sales</h5>
                        <span class="text-bold-400 mb-0"><?= $sales ?> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-danger bg-darken-2">
                        <i class="ft-crop font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-danger white media-body">
                        <h5> Discount</h5>
                        <span class="text-bold-400 mb-0"><?= $discount ?> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-red bg-darken-2">
                        <i class="icon-question font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-red white media-body">
                        <h5> Due</h5>
                        <span class="text-bold-400 mb-0"> <?= $due ?>  </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-success bg-darken-2">
                        <i class="icon-calculator font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-success white media-body">
                        <h5> Revenue</h5>
                        <span class="text-bold-400 mb-0"> <?= $revenue ?> <span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-info bg-darken-2">
                        <i class="icon-plus font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-info white media-body">
                        <h5> Purchases</h5>
                        <span class="text-bold-400 mb-0"> <?= $purchase ?>  </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-warning bg-darken-2">
                        <i class="icon-info font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-warning white media-body">
                        <h5> Expenses</h5>
                        <span class="text-bold-400 mb-0"> <?= $expense ?>  </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" class="form-group" action="<?= reportUrl() ?>">
    <div class="row justify-content-center">
        <div class="col-md-3" id="dateRange">
            <input type="text" class="form-control border-bottom-3 border-info" name="dateRange">
        </div>
        <div class="col-md-auto pl-0">
            <button type="submit" class="btn btn-primary">Generate</button>
        </div>
    </div>
</form>

<div class="card text-center">
    <div class="card-body">
        <div class="row animated zoomIn">
            <div class="col-md">
                <div class="card-header">
                    <h3 class="card-title text-bold-500"> Sales</h3>
                </div>
                <div class="card-body">
                    <div id="salesChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        salesChart();
        $(window).resize(function () {
            window.salesChart().redraw();
        });
    });

    function salesChart() {
        window.salesChart = Morris.Bar({
            element: 'salesChart',
            data:  <?= json_encode($salesChart) ?>,
            xkey: 'label',
            xLabelAngle: 65,
            ykeys: ['profit', 'qty', 'sale'],
            labels: ["Revenue", "Quantity", "Sale",],
            barColors: ['#785e80', '#B715C2', "#1e0f52"],
            lineWidth: '3px',
            parseTime: false,
            grid: false,
            resize: true,
            redraw: true
        });
    }
</script>

<script>
    $(function () {
        var start = moment().subtract(0, 'days');
        var end = moment();

        function cb(start, end) {
            $('#dateRange input').val(start.format('D, MMMM YYYY') + ' - ' + end.format('D, MMMM YYYY'));
        }

        $('#dateRange').daterangepicker({
            startDate: start,
            endDate: end,
            opens: 'center',
            showDropdowns: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
</script>
