<?php

//fixed-top
if ($navBarSettings["topBar"]) {
	?>
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top <?= topBar() ?> navbar-shadow <?= centerBrand() ?>">
        <div class="navbar-wrapper">
            <div class="navbar-header <?= brandNameColor() ?>">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="<?= sysUrl() ?>" data-toggle="tooltip" data-placement="bottom"
                           title=<?= systemName() ?>>
                            <img class="brand-logo" alt="<?= systemName() ?>" src="<?= systemlogoSrc() ?>"
                                 width="32">
                            <span class="brand-text"><?= systemName() ?></span>
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                                    class="fa fa-ellipsis-v"></i></a>
                    </li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
						<?php
						if ($navBarSettings["slideBar"]) {
							?>
                            <li class="nav-item d-none d-md-block"><a
                                        class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                            class="ft-menu"></i></a></li>
							<?php
						}
						?>
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i
                                        class="ficon ft-maximize"></i></a>
                        </li>

						<?php if (isOwner()) { ?>
                            <li class="dropdown nav-item">
                                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"
                                   aria-expanded="true">Reports</a>
                                <div class="dropdown-menu dropdown-menu-left">
                                    <a class="dropdown-item" href="<?= reportUrl() ?>">
                                        <i class="fa fa-chart-bar"></i>
                                        Sales Report
                                    </a>
                                    <a class="dropdown-item" href="<?= reportUrl("cr") ?>">
                                        <i class="fa fa-chart-pie"></i>
                                        Customer Report
                                    </a>
                                </div>
                            </li>
						<?php } ?>
                    </ul>
                    <li class="nav-item d-none d-md-block">
                        <a href="javascript: window.history.back()">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </li>
                    <ul class="nav navbar-nav float-right">
						<?php if (isOwner()) { ?>
                            <li class="dropdown dropdown-notification nav-item">
                                <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                                    <i class="ficon ft-bell"></i>
                                    <span class="badge badge-pill badge-danger badge-up"><?= count($productNoti) ?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                    <li class="dropdown-menu-header">
                                        <a class="dropdown-header m-0 text-center" target="_blank"
                                           href="https://drive.google.com/open?id=1M-ej4pnRhKuVz_V7ovlyUFSH0ZrqDQF8">Report
                                        </a>
                                        <p class="text-muted text-center">Product Warehouse</p>
                                        <h6 class="dropdown-header m-0">
											<?php foreach ($productNoti as $index => $value) { ?>
                                                <hr class="mb-0 p-0">
                                                <span> <a href="<?= sysUrl('addPurchase/' . urlEncrypt($value->id)) ?>"</a> <?= $value->name ?></span>
												<?php if ($value->quantity < CRITICAL_STORAGE && $value->quantity != 0) { ?>
                                                    <span class="notification-tag badge badge-warning float-right
                                            m-0"><?= $value->quantity ?></span>
												<?php } elseif ($value->quantity == 0) { ?>
                                                    <span class="notification-tag badge badge-danger float-right
                                            m-0"><?= $value->quantity ?></span>
												<?php } else { ?>
                                                    <span class="notification-tag badge badge-dark float-right
                                            m-0"><?= $value->quantity ?></span>
												<?php }
											} ?>
                                        </h6>
                                    </li>
                                </ul>
                            </li>
						<?php } else { ?>
                            <li class="dropdown dropdown-notification nav-item">
                                <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                                    <i class="ficon ft-bell"></i>
                                    <span class="badge badge-pill badge-danger badge-up"><?= count($productNoti) ?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                    <li class="dropdown-menu-header">
                                        <a class="dropdown-header m-0 text-center" target="_blank"
                                           href="https://drive.google.com/open?id=1M-ej4pnRhKuVz_V7ovlyUFSH0ZrqDQF8">Report
                                        </a>
                                        <p class="text-muted text-center">Product Warehouse</p>
                                        <h6 class="dropdown-header m-0">
											<?php foreach ($productNoti as $index => $value) { ?>
                                                <hr class="mb-0 p-0">
                                                <span> <?= $value->name ?></span>
												<?php if ($value->quantity < CRITICAL_STORAGE && $value->quantity != 0) { ?>
                                                    <span class="notification-tag badge badge-warning float-right
                                            m-0"><?= $value->quantity ?></span>
												<?php } elseif ($value->quantity == 0) { ?>
                                                    <span class="notification-tag badge badge-danger float-right
                                            m-0"><?= $value->quantity ?></span>
												<?php } else { ?>
                                                    <span class="notification-tag badge badge-dark float-right
                                            m-0"><?= $value->quantity ?></span>
												<?php }
											} ?>
                                        </h6>
                                    </li>
                                </ul>
                            </li>
						<?php } ?>

                        <li class="dropdown dropdown-user nav-item ">
                            <a class="dropdown-togFgle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <img src="<?= currentUserImage() ?>" class="rounded-circle" height="20px" width="20px">
								<?php echo currentUserName() ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" data-toggle="tooltip" data-placement="top" title="Profile"
                                   href=" <?= sysUrl('profile') ?>"><i class="ft-home"></i>
                                    Profile</a>
                                <a class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="Logout"
                                   href=" <?= sysUrl('signout') ?>"><i class="ft-power"></i>
                                    Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
	<?php
}
//top end

//side start
if ($navBarSettings["slideBar"]) {
	?>
    <div class="main-menu menu-fixed <?= sideBar() ?> menu-accordion menu-shadow menu-collapsible <?= borderMenu() ?>"
         data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main show" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="navigation-header">
                    <span> MAP </span><i class=" ft-minus" data Family-toggle="tooltip" data-placement="right"
                                         data-original-title=<?= systemName() ?>></i>
                </li>

                <li class="nav-item" id="dashboard_nav">
                    <a href="<?= sysUrl() ?>">
                        <i class="ft-home"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                <li class=" nav-item " id="pos_nav">
                    <a href="<?= posUrl() ?>">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="menu-title">POS</span>
                    </a>
                </li>

                <li class="nav-item"><a href="#" id="sales_nav">
                        <i class="fa fa-shopping-bag"></i>
                        <span class="menu-title"> Sales</span>
                    </a>
                    <ul class="menu-content">
                        <li id="users_nav">
                            <a class="menu-item" href="<?= posUrl() ?>sales">
                                <i class="fa fa-shopping-cart"></i> Customers Sales</a>
                        </li>
                        <li id="customers_nav">
                            <a class="menu-item" href="<?= posUrl() ?>productsSales">
                                <i class="fa fa-shopping-basket"></i> Products Sales</a>
                        </li>
                    </ul>
                </li>

				<?php if (isOwner()) { ?>
                    <li class="nav-item " id="purchases_nav">
                        <a href="<?= sysUrl() ?>purchases">
                            <i class="fa fa-plus"></i>
                            <span class="menu-title">Purchases</span>
                        </a>
                    </li>
				<?php } ?>

                <li class="nav-item " id="expenses_nav">
                    <a href="<?= sysUrl() ?>expenses">
                        <i class="fa fa-minus"></i>
                        <span class="menu-title">Expenses</span>
                    </a>
                </li>

                <li class="nav-item " id="products_nav">
                    <a href="<?= sysUrl() ?>products ">
                        <i class="fa fa-barcode"></i>
                        <span class="menu-title">Product</span>
                    </a>
                </li>

                <li class="nav-item " id="categories_nav">
                    <a href="<?= sysUrl() ?>categories">
                        <i class="fa fa-folder"></i>
                        <span class="menu-title">Category</span>
                    </a>
                </li>

				<?php if (isOwner()) { ?>
                    <li class="nav-item"><a href="#" id="people_nav">
                            <i class="fa fa-users"></i>
                            <span class="menu-title">People</span>
                        </a>
                        <ul class="menu-content">
                            <li id="users_nav">
                                <a class="menu-item" href="<?= sysUrl() ?>users">
                                    <i class="fa fa-people-carry"></i> Employees</a>
                            </li>
                            <li id="customers_nav">
                                <a class="menu-item" href="<?= sysUrl() ?>customers">
                                    <i class="fa fa-address-card"></i> Customers</a>
                            </li>
                            <li id="vendors_nav">
                                <a class="menu-item" href="<?= sysUrl() ?>vendors">
                                    <i class="fa fa-support"></i> Vendors</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item " id="settings_nav">
                        <a href="<?= sysUrl() ?>settings">
                            <i class="ft-settings"></i>
                            <span class="menu-title">Settings</span>
                        </a>
                    </li>
				<?php }
				if (isStaff()) { ?>
                    <li class="nav-item " id="customer_nav">
                        <a href="<?= sysUrl() ?>customers">
                            <i class="fa fa-address-card"></i>
                            <span class="menu-title">Customers</span>
                        </a>
                    </li>
				<?php } ?>
        </div>
    </div>
	<?php
}

//global
if (isset($navMeta["active"])) {
	?>

    <script>
        if (document.getElementById("<?= $navMeta["active"] ?>_nav")) {
            document.getElementById("<?= $navMeta["active"] ?>_nav").className += " active is-shown ";
        }
    </script>
	<?php
}

?>
<div class="app-content content">
    <div class="content-wrapper p-2">
		<?php
		if (!$navMeta["hideContentHeader"]) {
			?>
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-1 text-md-left text-center">
                    <h3 class="content-header-title mb-0 text-center text-md-left"><?= $navMeta["pageTitle"] ?></h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12 text-center text-md-left">
                            <ol class="breadcrumb justify-content-md-start justify-content-center">
								<?php
								$navMeta["n"] = 1;
								foreach ($navMeta["bc"] as $bc) {
									?>
                                    <li class="breadcrumb-item <?= $navMeta["n"] == sizeof($navMeta["bc"]) ? "active" : "" ?>">

										<?php
										if ($bc["url"] && isset($bc["url"])) {
											?>
                                            <a href="<?= $bc["url"] ?>"><?= $bc["page"] ?></a>
											<?php
										} else {
											?><?= $bc["page"] ?>
											<?php
										}
										?>
                                    </li>
									<?php
									$navMeta["n"]++;
								}
								?>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12 mb-1 text-md-right text-center"
                     id="nav-right-container"></div>
            </div>
			<?php
		}
		if ($navBarSettings["topBar"]) {
		if ($navBarSettings["mainContentCard"]) { ?>
        <div class="content-body bg-white p-1">
			<?php
			}
			}
			?>

