<?php

?>

<?php if (!is_numeric($uriSegment)) { ?>
	<?= setAlertMsgFromViewPage("Sale complete!!", SUCCESS); ?>
<?php } ?>

<div class="row justify-content-center">
    <div class="col-8">
        <section class="card">
            <div id="invoice-template" class="card-body d-flex flex-column">
                <!-- Invoice Company Details -->
                <div class="row">
                    <div class="col-md-6 col-sm-12 text-center text-md-left">
                        <div class="media">
                            <img src="<?= systemlogoSrc() ?>" alt="company logo" class="h-25 w-25">
                            <div class="media-body">
                                <ul class="ml-2 px-0 list-unstyled">
                                    <li class="text-bold-700"><?= $company->name ?></li>
                                    <li><?= $company->address ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center text-md-right">
                        <h3>INVOICE</h3>
                        <p><?= $sales->reference ?></p>
                    </div>
                </div>
                <!--/ Invoice Company Details -->

                <!-- Invoice Customer Details -->
                <div id="invoice-customer-details" class="row">
                    <div class="col-sm-12 text-center text-md-left">
                        <p class="text-muted"><br>Bill To</p>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center text-md-left">
                        <ul class="px-0 list-unstyled">
                            <li class="text-bold-600"><?= $customer->name ?></li>
                            <li><?= $customer->email ?></li>
                            <li><?= $customer->contact ?></li>
                            <li><?= $customer->address ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-12 text-md-right">
                        <p><span class="text-muted">Invoice Date :
                            </span> <?= changeDateFormatToLong($sales->date) ?>
                        </p>
                        <p><span class="text-muted">Salesman : </span><?= $salesman->name ?></p>
                        <p><span class="text-muted">Payment Type : </span>Cash</p>
                    </div>
                </div>
                <!--/ Invoice Customer Details -->

                <!-- Invoice Items Details -->
                <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                        <div class="table-responsive col-sm-12">
                            <table class="table">
                                <thead class="table-success">
                                <tr>
                                    <th class="p-1">#</th>
                                    <th class="p-1">Item</th>
                                    <th class="text-right p-1">Price</th>
                                    <th class="text-right p-1">Quantity</th>
                                    <th class="text-right p-1">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
								<?php foreach ($salesItems as $index => $items) { ?>
                                    <tr>
                                        <th scope="row" class="p-1"> <?= $index + 1 ?></th>
                                        <td class="p-1">
                                            <p><?= $items->name ?></p>
                                        </td>
                                        <td class="text-right p-1"><?= CURRENCY . $items->salePrice ?></td>
                                        <td class="text-right p-1"><?= $items->qty ?></td>
                                        <td class="text-right p-1"><?= CURRENCY . $items->subTotal ?></td>
                                    </tr>
								<?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-auto">
                        <div class="col-md-6 col-sm-12 text-center text-md-left">
                            <div class="text-center">
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <h6><?= $salesman->name ?></h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <p class="lead text-uppercase"> Total Due</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td class="p-1">SubTotal</td>
                                        <td class="text-right p-1"><?= CURRENCY . $sales->total ?></td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">Ordered Discount</td>
                                        <td class="text-right p-1"><?= CURRENCY . $sales->orderedDiscount ?></td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">Total</td>
                                        <td class="text-right p-1"><?= CURRENCY . $sales->grandTotal ?></td>
                                    </tr>
                                    <tr class="grey-blue">
                                        <td class="text-bold-600 p-1">Payment Made</td>
                                        <td class="text-bold-600 text-right p-1"><?= CURRENCY . $payments->amount ?></td>
                                    </tr>
									<?php if ($sales->grandTotal > $payments->amount) { ?>
                                        <tr class="red">
                                            <td class="text-bold-600 p-1">Due</td>
                                            <td class="text-bold-600 text-right p-1"> <?= CURRENCY . ($sales->grandTotal - $payments->amount) ?></td>
                                        </tr>
									<?php } else { ?>
                                        <tr class="blue">
                                            <td class="text-bold-600 p-1">Change</td>
                                            <td class="text-bold-600 text-right p-1"> <?= CURRENCY . ($payments->amount - $sales->grandTotal) ?></td>
                                        </tr>
									<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Footer -->
                <div id="invoice-footer">
                    <div class="row">
                        <div class="col-md-12 text-center col-sm-12 noprint">
                            <button type="button" onclick="window.location=document.referrer"
                                    class="btn btn-red my-1">
                                <i class="fa fa-fast-backward"></i> BACK
                            </button>
                            <button type="button" onclick="window.print()"
                                    class="btn btn-grey-blue my-1">
                                <i class="fa fa-print"></i> PRINT
                            </button>
                        </div>
                        <div class="col-md-12 text-center col-sm-12 py-1">
                            <p>Thanks for shopping with - <?= systemName() ?></p>
                        </div>
                    </div>
                </div>
                <!--/ Invoice Footer -->

            </div>
        </section>
    </div>
</div>


