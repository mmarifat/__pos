<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 10/31/2019 9:24 AM
 */
?>

<div id="content-nav-right">
    <div class="btn-group float-md-right" role="group">
        <div class="btn-group" role="group">
            <a class="btn btn-outline-blue-grey"
               href=" <?= sysUrl('vendors') ?>"> Vendors list</a>
        </div>
    </div>
</div>

<form class="form" novalidate action="<?= sysUrl("addVendor") ?>" method="post">
    <div class="form-body">
        <h4 class="form-section"><i class="fa fa-address-card"></i> Vendor Info - [Neccessary]</h4>
        <div class="row">
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Company Name</label>
                    <input required type="text" class="form-control border-primary" name="companyName"
                           data-validation-required-message="Requires valid name">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Executive Name</label>
                    <input required type="text" class="form-control border-primary" name="name"
                           data-validation-required-message="Requires valid name">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Contact</label>
                    <input required type="number" class="form-control border-primary" name="contact"
                           data-validation-required-message="Only numbers are allowed">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Address</label>
                    <input required type="text" class="form-control border-primary" name="address"
                           data-validation-required-message="Requires valid address">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>
        </div>

        <h4 class="form-section"><i class="ft-mail"></i>Additional Info</h4>
        <fieldset class="form-group">
            <label>Email</label>
            <input class="form-control border-primary" type="email" name="email" autocomplete="off"
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
