<?php

?>

<div class="modal-dialog modal-open">
    <div class="modal-content rounded-bottom">
        <div class="modal-header">
            <h4 class="modal-title pull-left">Update Vendor</h4>
            <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class='panel panel-body'>
                <form novalidate class="form-group" method="post"
                      action="<?= sysUrl('updateVendor/' . $updateVendor->id) ?>">

                    <div class="form-group">
                        <label for="companyName">Company Name</label>
                        <input type="text" class="form-control" name="companyName" id="companyName"
                               value="<?= $updateVendor->companyName ?>">
                    </div>

                    <div class="form-group">
                        <label for="name">Executive Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                               value="<?= $updateVendor->name ?>">
                    </div>

                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="number" class="form-control" name="contact" id="contact"
                               value="<?= $updateVendor->contact ?>">
                        <span id="contact_result"></span>
                    </div>

                    <div class="form-group">
                        <label for="address">Email</label>
                        <input type="text" class="form-control" name="address" id="address"
                               value="<?= $updateVendor->address ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                               value="<?= $updateVendor->email ?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Vendor</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#contact').change(function () {
            var contact = $('#contact').val();
            if (contact != '') {
                $.ajax({
                    url: "<?=sysUrl("checkVendorContactAvalibility")?>",
                    method: "POST",
                    data: {contact: contact},
                    success: function (data) {
                        $('#contact_result').html(data);
                    }
                });
            }
        });
    });
</script>

