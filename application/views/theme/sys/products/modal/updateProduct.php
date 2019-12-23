<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 10/31/2019 12:27 PM
 */
?>

<div class="modal-dialog modal-open">
    <div class="modal-content rounded-bottom">
        <div class="modal-header">
            <h4 class="modal-title pull-left">Update Product</h4>
            <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class='panel panel-body'>
                <form novalidate class="form-group" method="post" enctype="multipart/form-data"
                      action="<?= sysUrl('updateProduct/' . $updateProduct->id) ?>">

                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" name="code" id="code"
                               value="<?= $updateProduct->code ?>">
                        <span id="code_result"></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="name" class="form-control" name="name" id="name"
                               value="<?= $updateProduct->name ?>">
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="product" <?= ($updateProduct->type == 'product') ? "selected" : "" ?>>
                                Product
                            </option>
                            <option value="service" <?= ($updateProduct->type == 'service') ? "selected" : "" ?>>
                                Service
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" id="categorySelect" class="categorySelect form-control"
                                style="width: 100%"></select>
                    </div>

                    <input hidden type="number" step=".01" class="form-control" name="quantity" id="quantity"
                           value="<?= $updateProduct->quantity ?>">

                    <div class="form-group">
                        <label for="cost">Cost</label>
                        <input type="number" step="any" class="form-control" name="cost" id="cost"
                               value="<?= $updateProduct->cost ?>">
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="any" class="form-control" name="price" id="price"
                               value="<?= $updateProduct->price ?>">
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
						<?php if ($updateProduct->image) { ?>
                            <img src="<?= uploadUrl($updateProduct->image) ?>" height="100px" width="100px">
						<?php } ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Product</button>
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
                    url: "<?=sysUrl("checkProductCodeAvalibility")?>",
                    method: "POST",
                    data: {code: code},
                    success: function (data) {
                        $('#code_result').html(data);
                    }
                });
            }
        });
    });

    $('#categorySelect').select2({
        placeholder: 'Select Category',
        ajax: {
            url: '<?=sysUrl("selectCategory")?>',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
    var newOption = new Option("<?= $category->code ?>", <?= $category->id ?>, false, false);
    $('.categorySelect').append(newOption).trigger('change');
</script>