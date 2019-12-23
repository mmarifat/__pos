<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 11/28/2019 11:39 PM
 */
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content rounded-bottom">
        <div class="modal-body">
            <div class='panel panel-body'>
                <h4 class="text-bold-700 text-center"> <?= $duePayment->reference ?></h4>
                <hr>
                <div class="row">
                    <div class="col-6 text-left">
                        <span class="font-size-large text-muted"> Sale Date : <?= $duePayment->date ?></span><br>
                        <span class="font-size-large text-muted"> Items : <?= $duePayment->itemType ?> [<?= $duePayment->item ?>]</span><br>
                        <span class="font-size-large text-muted"> Total : TK <?= $duePayment->total ?></span><br>
                        <span class="font-size-large text-muted"> Discount : TK <?= $duePayment->orderedDiscount ?></span><br>
                        <span class="font-size-large text-muted"> Total Payable: TK <?= $duePayment->grandTotal ?></span><br>
                        <span class="font-size-large text-muted"> Paid : TK <?= $duePayment->amount ?></span><br>
						<?php if ($duePayment->due) { ?>
                            <span class="font-size-large text-muted red"
                                  id="due"> Due : Tk <?= $duePayment->due ?></span><br>
						<?php } else { ?>
                            <span class="font-size-large text-muted blue"
                                  id="due"> Change : Tk <?= $duePayment->amount - $duePayment->grandTotal ?></span><br>
						<?php } ?>
                    </div>
                    <div class="col-6 text-right">
                        <h5><u> Bill To </u></h5>
                        <span class="font-size-large text-muted"> <?= $duePayment->name ?></span><br>
                        <span class="font-size-large text-muted"> <?= $duePayment->contact ?></span><br>
                        <span class="font-size-large text-muted"> <?= $duePayment->address ?></span><br>
                    </div>
                </div>

                <hr>
				<?php if ($duePayment->due) { ?>
                    <form novalidate class="form-group" method="post" action="<?= posUrl('payment') ?>">
                        <input type="hidden" name="preAmount" value="<?= $duePayment->amount ?>">
                        <input type="hidden" name="preDue" value="<?= $duePayment->due ?>">
                        <input type="hidden" name="paymentID" value="<?= $duePayment->paymentID ?>">
                        <input type="hidden" name="sID" value="<?= $duePayment->id ?>">
                        <div class="form-group">
                            <h4 for="due" class="text-center"> Enter Due Payment </h4>
                            <input type="text" name="due" class="form-control border-bottom-3 text-center"
                                   value="<?= $duePayment->due ?>">
                        </div>
                        <div class="form-group text-center">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"> Cancel</button>
                            <button type="submit" class="btn btn-primary"> Repay</button>
                        </div>
                    </form>
				<?php } else { ?>
                    <div class="text-center">
                        <button type="button" class="btn btn-success" data-dismiss="modal"> Okay</button>
                    </div>
				<?php } ?>
            </div>
        </div>
    </div>
</div>
