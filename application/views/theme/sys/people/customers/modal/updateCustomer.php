<?php

?>

<div class="modal-dialog modal-open">
    <div class="modal-content rounded-bottom">
        <div class="modal-header">
            <h4 class="modal-title pull-left">Update User</h4>
            <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class='panel panel-body'>
                <form novalidate class="form-group" method="post"
                      action="<?= sysUrl('updateCustomer/' . $updateCustomer->id) ?>">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                               value="<?= $updateCustomer->name ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                               value="<?= $updateCustomer->email ?>">
                    </div>

                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" name="contact" id="contact"
                               value="<?= $updateCustomer->contact ?>">
                        <span id="contact_result"></span>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address"
                               value="<?= $updateCustomer->address ?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Customer</button>
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
                    url: "<?=sysUrl("checkContactAvalibility")?>",
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
