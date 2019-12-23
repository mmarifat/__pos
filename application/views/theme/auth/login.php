<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 11/27/2019 1:21 AM
 */
?>

<div class="col-12 d-flex align-items-center justify-content-center p-5">
    <div class="col-md-4 col-10 box-shadow-2 p-0">
        <div class="card border-grey border-lighten-3 m-0">
            <div class="card-header border-0">
                <div class="card-title text-center">
                    <div class="p-1">
                        <a href="<?= base_url() ?>"><img src="<?= systemlogoSrc() ?>" height="120" width="170"
                                                         alt="branding logo">
                            <h4 class="h3"><strong><?= systemName() ?></strong></h4></a>
                    </div>
                </div>
				<?php
				if (isset($_SESSION["altMsg"])) {
				?>
                <div class="alert brt-alert text-center alert-dismissible alert-<?= isset($_SESSION["altMsgType"]) ? $_SESSION["altMsgType"] : "info" ?>"
				<?= $_SESSION["altMsg"] ?>
            </div>
			<?php
			unset($_SESSION["altMsg"]);
			}
			?>
            <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                <span><strong> LOG IN</strong></span>
            </h6>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form class="form-horizontal form-simple"
                      action="<?= loginUrl() ?>" novalidate method="post">
                    <fieldset class="form-group">
                        <label for="email"><i class="ft-user"></i> Email </label>
                        <input type="email" class="form-control" id="user-email" name="email"
                               data-validation-required-message="Must fill out email"
                               required>
                        <p class="help-block m-0 danger"></p>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="password"><i class="fa fa-key"></i> Password </label>
                        <input type="password" class="form-control" id="user-password" name="password"
                               data-validation-required-message="Must fill out password"
                               required>
                        <p class="help-block m-0 danger"></p>
                    </fieldset>
                    <button type="submit" data-toggle="tooltip" data-placement="bottom" title="Login"
                            class="btn btn-dark btn-lg btn-block"><i class="ft-unlock"></i> Login
                    </button>
                </form>
            </div>
        </div>
        <div class="card-footer ">
            <!--<div class="pull-center">
				<p class="float-sm text-center m-0"><a href=" " class="card-link">New Here?</a></p>
			</div>-->
        </div>
    </div>
</div>
