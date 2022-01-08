<?php

?>

<div class="modal-dialog modal-open">
    <div class="modal-content rounded-bottom">
        <div class="modal-header">
            <h4 class="modal-title pull-left"><i class="ft-user"></i> Add User</h4>
            <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class='panel panel-body'>
                <form novalidate class="form-group" method="post" action="<?= sysUrl('addUser') ?>">

                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                        <span id="name_result"></span>
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email"
                               placeholder="Email">
                        <span id="email_result"></span>
                    </div>

                    <div class="form-group green-border-focus">
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="Password">
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="type" name="type" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="owner">Owner</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#name').change(function () {
            var name = $('#name').val();
            if (name != '') {
                $.ajax({
                    url: "<?=sysUrl("checkUserAvalibility")?>",
                    method: "POST",
                    data: {name: name},
                    success: function (data) {
                        $('#name_result').html(data);
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        $('#email').change(function () {
            var email = $('#email').val();
            if (email != '') {
                $.ajax({
                    url: "<?=sysUrl("checkEmailAvalibility")?>",
                    method: "POST",
                    data: {email: email},
                    success: function (data) {
                        $('#email_result').html(data);
                    }
                });
            }
        });
    });

</script>