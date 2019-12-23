<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 11/8/2019 10:54 AM
 */
?>

<div class="modal-dialog modal-open">
    <div class="modal-content rounded-bottom">
        <div class="modal-header">
            <h4 class="modal-title pull-left">Update Purchase</h4>
            <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class='panel panel-body'>
                <form novalidate class="form-group" method="post"
                      action="<?= sysUrl('updatePurchase/' . $updatePurchase->id) ?>">

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text" class="form-control" name="date" id="date" required
                               value="<?= changeDateFormatToLong($updatePurchase->date) ?>">
                    </div>

                    <div class="form-group">
                        <label for="reference">Reference</label>
                        <input type="text" class="form-control" name="reference" id="reference" required
                               value="<?= $updatePurchase->reference ?>">
                    </div>

                    <div class="form-group">
                        <label for="product">Product</label>
                        <select name="product" id="productSelect" class="form-control"
                                style="width: 100%"></select>
                    </div>

                    <div class="form-group">
                        <label for="total">Total Quantity</label>
                        <input type="text" class="form-control" name="total" id="total" required
                               value="<?= $updatePurchase->total ?>">
                    </div>

                    <div class="form-group">
                        <label for="vendor">Vendor</label>
                        <select name="vendor" id="vendorSelect" class="form-control" required
                                style="width: 100%"></select>
                    </div>

                    <div class="form-group">
                        <label for="received">Received</label>
                        <select class="form-control" id="received" name="received" required>
                            <option value="<?= $updatePurchase->received ?>"
                                    selected> <?= ($updatePurchase->received == 1) ? "Done" : "Pending" ?> </option>
                            <option value="1">DONE</option>
                            <option value="0">PENDING</option>
                        </select
                    </div>

                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Purchase</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('input[name="date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'), 10),
            locale: {
                format: 'DD MMMM, Y'
            }
        });
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

    var newOption = new Option("<?= $chVendor->companyName ?>", <?= $chVendor->id ?>, false, false);
    $('#vendorSelect').append(newOption).trigger('change');

    var newOption = new Option("<?= $chProduct->code ?>", <?= $chProduct->id ?>, false, false);
    $('#productSelect').append(newOption).trigger('change');
</script>