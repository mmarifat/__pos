<?php

?>

<div class="modal-dialog modal-open">
    <div class="modal-content rounded-bottom">
        <div class="modal-header">
            <h4 class="modal-title pull-left">Update Category</h4>
            <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class='panel panel-body'>
                <form class="form-group" method="post" enctype="multipart/form-data" id="updateCategory"
                      action="<?= sysUrl('updateCategory/' . $updateCategory->id) ?>">

                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" name="code" id="code"
                               value="<?= $updateCategory->code ?>">
                        <span id="code_result"></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                               value="<?= $updateCategory->name ?>">
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
						<?php if ($updateCategory->image) { ?>
                            <img src="<?= uploadUrl($updateCategory->image) ?>" height="100px" width="100px">
						<?php } ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#code').change(function () {
            var code = $('#code').val();
            if (code != '') {
                $.ajax({
                    url: "<?=sysUrl("checkCodeAvalibility")?>",
                    method: "POST",
                    data: {code: code},
                    success: function (data) {
                        $('#code_result').html(data);
                    }
                });
            }
        });
    });
    $(document).ready(function () {
        $('#updateCategory').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                code: {
                    validators: {
                        notEmpty: {
                            message: 'The code is required'
                        }
                    }
                },
                name: {
                    validators: {
                        notEmpty: {
                            message: 'The name is required'
                        }
                    }
                }
            }
        });
    });
</script>