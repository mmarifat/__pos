<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 11/8/2019 12:41 PM
 */
?>

<div class="modal-dialog modal-open">
    <div class="modal-content rounded-bottom">
        <div class="modal-header">
            <h4 class="modal-title pull-left"><i class="fa fa-money"></i> Add Expense</h4>
            <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class='panel panel-body'>
                <form novalidate class="form-group" method="post" action="<?= sysUrl('addExpense') ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="date" id="date" placeholder="Date">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="reference" id="reference"
                               value="<?= getReference(TABLE_EXPENSES, "date", "EXP") ?>"
                               placeholder="Reference">
                    </div>

                    <div class="form-group green-border-focus">
                        <input type="number" step="any" class="form-control" name="amount" id="amount"
                               placeholder="Amount">
                    </div>

                    <div class="form-group green-border-focus">
                        <input type="text" class="form-control" name="note" id="note"
                               placeholder="Expense Note">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add Expense</button>
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
    $(document).ready(function () {
        $('form').submit(function (event) {
            event.preventDefault();
            var form = $(this)[0];

            if ($('#amount').val() === "") {
                $.alert('<p class="danger text-uppercase text-bold-600">Enter amount !!</p>');
            } else {
                if ($('#note').val() === "") {
                    $.alert('<p class="danger text-uppercase text-bold-600">Reason for expense ??</p>');
                } else {
                    $.confirm({
                        theme: 'modern',
                        icon: 'fa fa-minus-circle',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        type: 'blue',
                        draggable: true,
                        title: 'Confirmation!',
                        content: 'Are you sure to add this expense ??',
                        buttons: {
                            CANCEL: {
                                btnClass: 'btn-pink',
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
        });
    });
</script>
