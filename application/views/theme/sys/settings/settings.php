<?php

?>

<form class="form" novalidate action="<?= sysUrl("settings") ?>" method="post" enctype="multipart/form-data">
    <div class="form-body">
        <h4 class="form-section"><i class="fa fa-warehouse"></i> Store Info</h4>
        <div class="row">
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Store Name</label>
                    <input type="text" class="form-control border-primary" required name="name"
                           data-validation-required-message="Enter valid name"
                           value="<?= $settings->name ? $settings->name : "" ?>">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Store Address</label>
                    <input type="text" class="form-control border-primary" required name="address"
                           data-validation-required-message="Enter valid address"
                           value="<?= $settings->address ? $settings->address : "" ?>">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>
        </div>

        <h4 class="form-section"><i class="ft-image"></i>Store Image</h4>
        <fieldset class="form-group">
			<?php if ($settings->image) { ?>
            <p style="text-align:center;">
                <img align="center" src="<?= uploadUrl($settings->image) ?>" height="100px" max-width="100px">
				<?php } ?>
        </fieldset>
        <fieldset class="form-group">
            <label>Image [keep it blank, if you do not want to change]</label>
            <input class="form-control border-primary" type="file" name="image" id="image" accept="image/*"
                   aria-invalid="true">
        </fieldset>

        <h4 class="form-section"><i class="fa fa-laptop"></i>Store Favicon</h4>
        <fieldset class="form-group">
			<?php if ($settings->favicon) { ?>
            <p style="text-align:center;">
                <img align="center" src="<?= uploadUrl($settings->favicon) ?>" height="100px" max-width="100px">
				<?php } ?>
        </fieldset>
        <fieldset class="form-group">
            <label>Favicon- (Use ICO format) [keep it blank, if you do not want to change]</label>
            <input class="form-control border-primary" type="file" name="favicon" id="favicon" accept="image/*"
                   aria-invalid="true">
        </fieldset>
    </div>

    <div class="form-actions right">
        <button type="button" class="btn btn-warning mr-1">
            <i class="ft-x"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-check-square"></i> Save
        </button>
    </div>
</form>

