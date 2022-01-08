<?php

?>

<div class="modal-dialog modal-open">
    <div class="modal-content rounded-bottom">
        <div class="modal-header">
            <h4 class="modal-title pull-left"><i class="fa fa-money"></i> Update Expense</h4>
            <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class='panel panel-body'>
                <form novalidate class="form-group" method="post"
                      action="<?= sysUrl('updateExpense/' . $updateExpense->id) ?>">

                    <div class="form-group">
                        <input type="text" class="form-control" name="date" id="date" placeholder="Date"
                               value="<?= changeDateFormatToLong($updateExpense->date) ?>">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="reference" id="reference"
                               value="<?= $updateExpense->reference ?>" placeholder="Reference">
                    </div>

                    <div class="form-group green-border-focus">
                        <input type="number" step="any" class="form-control" name="amount" id="amount"
                               value="<?= $updateExpense->amount ?>" placeholder="Amount">
                    </div>

                    <div class="form-group green-border-focus">
                        <input type="text" class="form-control" name="note" id="note"
                               value="<?= $updateExpense->note ?>" placeholder="Note">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Expense</button>
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
</script>

