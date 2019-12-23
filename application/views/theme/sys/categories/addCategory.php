<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 10/31/2019 11:53 AM
 */

?>
<div id="content-nav-right">
    <div class="btn-group float-md-right" role="group">
        <div class="btn-group" role="group">
            <a class="btn btn-outline-blue-grey"
               href=" <?= sysUrl('categories') ?>"> Categories list</a>
        </div>
    </div>
</div>

<form class="form" novalidate action="<?= sysUrl("addCategory") ?>" method="post" enctype="multipart/form-data">
    <div class="form-body">
        <h4 class="form-section"><i class="fa fa-infor"></i> Category Info - [Neccessary]</h4>
        <div class="row">
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control border-bottom-3" required name="code"
                           data-validation-required-message="Requires a valid code">
                    <span id="code_result"></span>
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control border-bottom-3" required name="name"
                           data-validation-required-message="Requires valid name">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>
        </div>

        <h4 class="form-section"><i class="ft-image"></i>Image</h4>
        <fieldset class="form-group">
            <input class="form-control border-bottom-3" type="file" name="image" autocomplete="off" accept="image/*"
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

