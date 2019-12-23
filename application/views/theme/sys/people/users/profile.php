<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 10/30/2019 9:41 PM
 */
?>

<div id="content-nav-right">
    <div class="btn-group float-md-right" role="group">
        <div class="btn-group" role="group">
            <a class="btn btn-outline-blue-grey"
               href=" <?= sysUrl('users') ?>"> Back </a>
        </div>
    </div>
</div>

<form class="form" novalidate action="<?= sysUrl("profile") ?>" method="post" enctype="multipart/form-data">
    <div class="form-body">
        <h4 class="form-section"><i class="fa fa-user"></i> Personal Info</h4>
        <div class="row">
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control border-primary" required name="name"
                           data-validation-required-message="Enter valid name"
                           value="<?= $profile->name ?>">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control border-primary" required name="email"
                           data-validation-required-message="Enter valid email"
                           value="<?= $profile->email ?>">
                    <p class="help-block m-0 danger"></p>
                </fieldset>
            </div>
        </div>

        <h4 class="form-section"><i class="ft-lock"></i>Password</h4>
        <fieldset class="form-group">
            <label>Password[keep it blank, if you do not want to change]</label>
            <input class="form-control border-primary" type="password" name="password" autocomplete="off">
        </fieldset>

        <h4 class="form-section"><i class="ft-image"></i>Image</h4>
        <fieldset class="form-group">
			<?php if ($profile->image) { ?>
            <p style="text-align:center;">
                <img align="center" src="<?= uploadUrl($profile->image) ?>" height="200px" max-width="200px">
				<?php } ?>
        </fieldset>
        <fieldset class="form-group">
            <label>Image [Max Size: 1 MB] [keep it blank, if you do not want to change]</label>
            <input class="form-control border-primary" type="file" name="image" id="image" accept="image/*"
                   aria-invalid="true">
        </fieldset>

        <h4 class="form-section"><i class="fa fa-desktop"></i>Theme</h4>
        <div class="row justify-content-center text-center">
            <div class="col-md-2">
                <fieldset class="form-group">
                    <label>Top Bar Theme</label>
					<?php
					$topBarColor = array(
						"System Default" => "navbar-light bg-white",
						"Default Light" => "navbar-light bg-blue-grey bg-lighten-4",
						"Primary Light" => "navbar-light bg-primary bg-lighten-4",
						"Danger Light" => "navbar-light bg-danger bg-lighten-4",
						"Success Light" => "navbar-light bg-success bg-lighten-4",
						"Blue Light" => "navbar-light bg-blue bg-lighten-4",
						"Cyan Light" => "navbar-light bg-cyan bg-lighten-4",
						"Pink Light" => "navbar-light bg-pink bg-lighten-4",

						"Default Dark" => "navbar-dark bg-blue-grey",
						"Primary Dark" => "navbar-dark bg-primary",
						"Danger Dark" => "navbar-dark bg-danger",
						"Success Dark" => "navbar-dark bg-success",
						"Blue Dark" => "navbar-dark bg-blue",
						"Cyan Dark" => "navbar-dark bg-cyan",
						"Pink Dark" => "navbar-dark bg-pink",

						"Default Gradient" => "navbar-dark bg-gradient-x-grey-blue",
						"Primary Gradient" => "navbar-dark bg-gradient-x-primary",
						"Danger Gradient" => "navbar-dark bg-gradient-x-danger",
						"Success Gradient" => "navbar-dark bg-gradient-x-success",
						"Blue Gradient" => "navbar-dark bg-gradient-x-blue",
						"Cyan Gradient" => "navbar-dark bg-gradient-x-cyan",
						"Pink Gradient" => "navbar-dark bg-gradient-x-pink"
					);
					?>
                    <select class="form-control border-primary" id="topBar" name="topBar" required>
						<?php
						foreach ($topBarColor as $label => $value) { ?>
                            <option value="<?= $value ?>" <?= $theme->topBar == $value ? "selected" : " " ?> >
								<?= $label ?>
                            </option>
						<?php } ?>
                    </select>
                </fieldset>
            </div>

            <div class="col-md-2">
                <fieldset class="form-group">
                    <label>Side Bar Theme</label>
                    <select class="form-control border-primary" id="sideBar" name="sideBar" required>
                        <option value="menu-light" <?= $theme->sideBar == "menu-light" ? "selected" : " " ?> >Light
                        </option>
                        <option value="menu-dark" <?= $theme->sideBar == "menu-dark" ? "selected" : " " ?> >Dark
                        </option>
                    </select>
                </fieldset>
            </div>

            <div class="col-md-2">
                <fieldset class="form-group">
                    <label>Side Bar Alignment</label>
                    <select class="form-control border-primary" id="flippedSideBar" name="flippedSideBar" required>
                        <option value="static" <?= $theme->flippedSideBar == "left" ? "selected" : " " ?> >Left</option>
                        <option value="menu-flipped" <?= $theme->flippedSideBar == "menu-flipped" ? "selected" : " " ?> >
                            Right
                        </option>
                    </select>
                </fieldset>
            </div>

            <div class="col-md-2">
                <fieldset class="form-group">
                    <label>Brand Name</label>
                    <select class="form-control border-primary" id="centerBrand" name="centerBrand" required>
                        <option value="side" <?= $theme->centerBrand == "side" ? "selected" : " " ?> >Left</option>
                        <option value="navbar-brand-center" <?= $theme->centerBrand == "navbar-brand-center" ? "selected" : " " ?> >
                            Center
                        </option>
                    </select>
                </fieldset>
            </div>

            <div class="col-md-2">
                <fieldset class="form-group">
                    <label>Brand Name Color</label>
					<?php
					$brandNameColor = array(
						"System Default" => " ",
						"Dark" => "bg-default",
						"Primary" => "bg-primary",
						"Danger" => "bg-danger",
						"Success" => "bg-success",
						"Blue" => "bg-blue",
						"Cyan" => "bg-cyan",
						"Pink" => "bg-pink",
					);
					?>
                    <select class="form-control border-primary" id="colorBrand" name="colorBrand" required>
						<?php
						foreach ($brandNameColor as $label => $value) { ?>
                            <option value="<?= $value ?>" <?= $theme->colorBrand == $value ? "selected" : " " ?> >
								<?= $label ?>
                            </option>
						<?php } ?>
                    </select>
                </fieldset>
            </div>

            <div class="col-md-2">
                <fieldset class="form-group">
                    <label>Menu</label>
                    <select class="form-control border-primary" id="borderMenu" name="borderMenu" required>
                        <option value="static" <?= $theme->borderMenu == "static" ? "selected" : " " ?> >Static</option>
                        <option value="menu-bordered" <?= $theme->borderMenu == "menu-bordered" ? "selected" : " " ?> >
                            Border
                        </option>
                    </select>
                </fieldset>
            </div>

            <div class="col-md-2">
                <fieldset class="form-group">
                    <label>Footer</label>
                    <select class="form-control border-primary" id="footerOption" name="footerOption" required>
                        <option value="light" <?= $theme->footerOption == "light" ? "selected" : " " ?> >Light</option>
                        <option value="light fixed-bottom" <?= $theme->footerOption == "light fixed-bottom" ? "selected" : " " ?> >
                            Light & Fix
                        </option>
                        <option value="dark" <?= $theme->footerOption == "dark" ? "selected" : " " ?> >Dark</option>
                        <option value="dark fixed-bottom" <?= $theme->footerOption == "dark fixed-bottom" ? "selected" : " " ?> >
                            Dark & Fix
                        </option>
                    </select>
                </fieldset>
            </div>
        </div>

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