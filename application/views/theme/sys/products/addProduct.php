<?php

?>

<div id="content-nav-right">
    <div class="btn-group float-md-right" role="group">
        <div class="btn-group" role="group">
            <a class="btn btn-outline-blue-grey"
               href=" <?= sysUrl('products') ?>"> Products list</a>
        </div>
    </div>
</div>

<form class="form" novalidate action="<?= sysUrl("addProduct") ?>" method="post" enctype="multipart/form-data">
    <div class="form-body">
        <h4 class="form-section"><i class="fa fa-info"></i> Product Info - [Neccessary]</h4>
        <div class="row">
            <div class="col-md-12">
                <fieldset class="form-group">
                    <label>Category</label>
                    <select name="category" id="categorySelect" class="form-control categorySelect"
                            style="width: 100%"></select>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Code [You can use your own - This is for barcode]</label>
                    <input type="text" class="form-control border-bottom-3" required name="code"
                           value="<?= barcode(TABLE_PRODUCTS, "addedTime", "P") ?>"
                           data-validation-required-message="Requires a valid code">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Name</label>
                    <input required type="text" class="form-control border-bottom-3" name="name"
                           data-validation-required-message="Requires valid name">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>

            <input hidden type="number" min="0" step=".01" class="form-control border-bottom-3" required
                   name="quantity">

            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Cost</label>
                    <input required type="number" min="0" step=".01" class="form-control border-bottom-3" name="cost"
                           data-validation-required-message="Requires valid cost">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Price</label>
                    <input required type="number" min="0" step=".01" class="form-control border-bottom-3" name="price"
                           data-validation-required-message="Requires valid price">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Type</label>
                    <select class="form-control border-bottom-3" id="type" name="type">
                        <option value="product" selected>Product</option>
                        <option value="service">Service</option>
                    </select>
                </fieldset>
            </div>
        </div>

        <h4 class="form-section"><i class="ft-image"></i>Image</h4>
        <fieldset class="form-group">
            <input class="form-control border-bottom-3 " type="file" multiple name="image" autocomplete="off"
                   accept="image/*"
        </fieldset>
    </div>

    <div class="form-actions right">
        <button type="button" class="btn btn-warning mr-1">
            <i class="ft-x"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary" id="addProductBtn">
            <i class="fa fa-check-square"></i> Save
        </button>
    </div>
</form>

<script>
    window.onload = function (e) {
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
    }

    $(document).ready(function () {
        $('#addProductBtn').on('click', function (event) {
            test = $("select#categorySelect").children("option:selected").val();
            if (test == undefined) {
                event.preventDefault();
                $.dialog('<p class="danger text-uppercase text-bold-600">Select category first !!</p>');
            }
        });
    });

</script>


