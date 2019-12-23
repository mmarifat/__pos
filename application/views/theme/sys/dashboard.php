<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 10/30/2019 8:57 PM
 */
?>

<div class="card">
    <div class="card-body animated slideInRight">
        <h4 class="text-uppercase text-center">Quick Links</h4>
        <div class="d-flex justify-content-center">
            <div class="row justify-content-center">
                <div class="col-12 text-center text-white">
                    <div class="row justify-content-center">
                        <div class="card px-1">
                            <div class="card-body width-100" style="background-color: #607D8B">
                                <a href="<?= posUrl() ?>" class="text-white">
                                    <i class="fa fa-shopping-cart animated infinite pulse delay-2s"></i><br>
                                    <h6 class="text-uppercase font-size-xsmall">&emsp;P O S&emsp;</h6>
                                </a>
                            </div>
                        </div>
                        <div class="card px-0">
                            <div class="card-body width-100" style="background-color: #607D8B">
                                <a href="<?= posUrl('sales') ?>" class="text-white">
                                    <i class="fa fa-shopping-bag animated infinite pulse delay-2s "></i><br>
                                    <h6 class="text-uppercase font-size-xsmall">&emsp;Sales&emsp;</h6>
                                </a>
                            </div>
                        </div>
                        <div class="card px-1">
                            <div class="card-body width-100" style="background-color: #607D8B">
                                <a href="<?= sysUrl("categories") ?>" class="text-white">
                                    <i class="fa fa-folder animated infinite pulse delay-2s "></i><br>
                                    <h6 class="text-uppercase font-size-xsmall">Categories</h6>
                                </a>
                            </div>
                        </div>
                        <div class="card px-0">
                            <div class="card-body width-100" style="background-color: #607D8B">
                                <a href="<?= sysUrl("products") ?>" class="text-white">
                                    <i class="fa fa-barcode animated infinite pulse delay-2s "></i><br>
                                    <h6 class="text-uppercase font-size-xsmall">Products</h6>
                                </a>
                            </div>
                        </div>
						<?php if (isOwner()) { ?>
                            <div class="card px-1">
                                <div class="card-body width-100" style="background-color: #607D8B">
                                    <a href="<?= sysUrl('purchases') ?>" class="text-white">
                                        <i class="fa fa-plus animated infinite pulse delay-2s "></i><br>
                                        <h6 class="text-uppercase font-size-xsmall">Purchases</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="card px-1">
                                <div class="card-body width-100" style="background-color: #607D8B">
                                    <a href="<?= sysUrl('users') ?>" class="text-white">
                                        <i class="fa fa-people-carry animated infinite pulse delay-2s "></i><br>
                                        <h6 class="text-uppercase font-size-xsmall">Employees</h6>
                                    </a>
                                </div>
                            </div>
						<?php } ?>
                        <div class="card px-1">
                            <div class="card-body width-100" style="background-color: #607D8B">
                                <a href="<?= sysUrl('expenses') ?>" class="text-white">
                                    <i class="fa fa-minus animated infinite pulse delay-2s "></i><br>
                                    <h6 class="text-uppercase font-size-xsmall">Expenses</h6>
                                </a>
                            </div>
                        </div>
                        <div class="card px-0">
                            <div class="card-body width-100" style="background-color: #607D8B">
                                <a href="<?= sysUrl('customers') ?>" class="text-white">
                                    <i class="fa fa-address-card animated infinite pulse delay-2s "></i><br>
                                    <h6 class="text-uppercase font-size-xsmall">Customers</h6>
                                </a>
                            </div>
                        </div>
						<?php if (isOwner()) { ?>
                            <div class="card px-1">
                                <div class="card-body width-100" style="background-color: #607D8B">
                                    <a href="<?= reportUrl('index') ?>" class="text-white">
                                        <i class="fa fa-chart-bar animated infinite pulse delay-2s "></i><br>
                                        <h6 class="text-uppercase font-size-xsmall">Reports</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="card px-0">
                                <div class="card-body width-100" style="background-color: #607D8B">
                                    <a href="<?= sysUrl('settings') ?>" class="text-white">
                                        <i class="ft-settings animated infinite pulse delay-2s"></i><br>
                                        <h6 class="text-uppercase font-size-xsmall">Settings</h6>
                                    </a>
                                </div>
                            </div>
						<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center animated slideInLeft">
    <div class="col-xl-2 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-darken-2">
                        <i class="icon-basket-loaded font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-primary white media-body">
                        <h5>Sales</h5>
                        <h5 class="text-bold-400 mb-0">
							<?php echo $totalSales ?>
                        </h5>
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
                        <i class="icon-question font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-danger white media-body">
                        <h5>Due Payment</h5>
                        <h5 class="text-bold-400 mb-0">
							<?php echo $totalDue; ?></h5>
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
                        <i class="icon-bag font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-warning white media-body">
                        <h5>Products</h5>
                        <h5 class="text-bold-400 mb-0">
							<?php echo $totalProducts ?></h5>
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
                        <i class="icon-users font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-success white media-body">
                        <h5>Customers</h5>
                        <h5 class="text-bold-400 mb-0">
							<?php echo $totalCustomers ?>
                        </h5>
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
                        <i class="icon-vector font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-success white media-body">
                        <h5>Employees</h5>
                        <h5 class="text-bold-400 mb-0">
							<?php echo $totalUsers ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row animated slideInUp">
            <div class="col-md-5">
                <div class="card-header">
                    <h3 class="card-title text-bold-500"> Todays Top 10 Products</h3>
                </div>
                <div class="card-body">
                    <div id="topTenProductsDonut"></div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card-header">
                    <h3 class="card-title text-bold-500">Todays Sales</h3>
                </div>
                <div class="card-body">
                    <div id="monthlySalesArea"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        monthlySales();
        topTenProducts();
        $(window).resize(function () {
            window.monthlySales().redraw();
            window.topTenProducts().redraw();
        });
    });

    function monthlySales() {
        window.monthlySales = Morris.Line({
            element: 'monthlySalesArea',
            data:  <?= json_encode($todaysSales) ?>,
            xkey: 'label',
            xLabelAngle: 270,
            ykeys: ['profit', 'qty', 'sale'],
            labels: ["Revenue", "Quantity", "Sale",],
            lineColors: ['#6a0dad', '#0000ee', "#000000"],
            lineWidth: '3px',
            parseTime: false,
            grid: false,
            resize: true,
            redraw: true
        });
    }

    function topTenProducts() {
        window.topTenProducts = Morris.Donut({
            element: 'topTenProductsDonut',
            data: <?=json_encode($todaysTopTenProducts)?>,
            dataLabels: true
        });
    }
</script>

