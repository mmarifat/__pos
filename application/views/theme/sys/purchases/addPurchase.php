<?php

?>

<div id="content-nav-right">
    <div class="btn-group float-md-right" role="group">
        <div class="btn-group" role="group">
            <a class="btn btn-outline-blue-grey"
               href="<?= sysUrl("purchases") ?>">Purchase</a>
            <a class="btn btn-outline-blue-grey"
               href="<?= sysUrl("products") ?>">Products</a>
        </div>
    </div>
</div>

<form class="form" novalidate action="<?= sysUrl("addPurchase") ?>" method="post">
    <div class="form-body">
        <h4 class="form-section"><i class="fa fa-info"></i> Purchase Info - [Neccessary]</h4>
        <div class="row">
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Product</label>
                    <select name="product" id="productSelect" class="form-group" style="width: 100%"></select>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Vendor</label>
                    <select name="vendor" id="vendorSelect" class="form-group" style="width: 100%"></select>
                </fieldset>
            </div>

            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="date">Date</label>
                    <input required type="text" class="form-control border-primary" name="date" id="date"
                           data-validation-required-message="Requires valid date">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>

            <div class="col-md-4">
                <fieldset class="form-group">
                    <label>Total Quantity</label>
                    <input required type="text" class="form-control border-primary" name="total" id="total"
                           data-validation-required-message="Requires a valid total qauntity">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label>Reference</label>
                    <input required type="text" class="form-control border-primary"
                           value="<?= getReference(TABLE_PURCHASES, "date", "PUR") ?>" name="reference" id="reference"
                           data-validation-required-message="Requires valid reference">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>
            <input name="received" id="received" hidden>
        </div>
    </div>

    <div class="form-actions center">
        <button type="button" class="btn btn-warning mr-1">
            <i class="ft-x"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-check-square"></i> Save
        </button>
    </div>
</form>

<script>

    window.onload = function (ev) {
        $('input[name="date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'), 10),
            locale: {
                format: 'DD MMMM, Y'
            }
        });

        $('#productSelect').select2({
            placeholder: 'Select Product',
            ajax: {
                url: '<?=sysUrl("selectProductForPurchase")?>',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('#vendorSelect').select2({
            placeholder: 'Select Vendor',
            ajax: {
                url: '<?=sysUrl("selectVendorForPurchase")?>',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    }

    $(document).ready(function () {
        $('form').submit(function (event) {
            event.preventDefault();
            var form = $(this)[0];
            test = $("select#productSelect").children("option:selected").val();
            test2 = $("select#vendorSelect").children("option:selected").val();

            if (test == undefined) {
                event.preventDefault();
                $.dialog('<p class="danger text-uppercase text-bold-600">Select a product first !!</p>');
            } else {
                if (test2 == undefined) {
                    event.preventDefault();
                    $.dialog('<p class="danger text-uppercase text-bold-600">Select a vendor !!</p>');
                } else {
                    $.confirm({
                        theme: 'modern',
                        icon: 'fa fa-check-square',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        type: 'blue',
                        draggable: true,
                        title: 'Payment Confirmation!',
                        content: 'Did you pay your amount to the vendor fully??',
                        buttons: {
                            NO: {
                                btnClass: 'btn-red',
                                action: function () {
                                    $('#received').val(0);
                                    $.confirm({
                                        theme: 'supervan',
                                        icon: 'fa fa-money',
                                        animation: 'scale',
                                        closeAnimation: 'scale',
                                        type: 'blue',
                                        draggable: true,
                                        title: 'Confirm Purchase!',
                                        content: 'Are you sure to purchase is item?',
                                        buttons: {
                                            CANCEL: {
                                                btnClass: 'btn-red',
                                            },
                                            CONFIRM: {
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    form.submit();
                                                }
                                            }
                                        }
                                    });
                                }
                            },
                            YES: {
                                btnClass: 'btn-blue',
                                action: function () {
                                    $('#received').val(1);
                                    $.confirm({
                                        theme: 'supervan',
                                        icon: 'fa fa-money',
                                        animation: 'scale',
                                        closeAnimation: 'scale',
                                        type: 'blue',
                                        draggable: true,
                                        title: 'Confirm Purchase!',
                                        content: 'Are you sure to purchase is item?',
                                        buttons: {
                                            CANCEL: {
                                                btnClass: 'btn-red',
                                            },
                                            CONFIRM: {
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    form.submit();
                                                }
                                            }
                                        }
                                    });
                                }
                            }
                        }
                    });
                }
            }
        });
        var newOption = new Option("<?= $products->name ?>", <?= $products->id ?>, false, false);
        $('#productSelect').append(newOption).trigger('change');
    });
</script>
