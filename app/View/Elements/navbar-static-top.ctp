<nav  role="navigation" class="navbar navbar-static-top <?php echo !empty($class) ? $class : '' ?>" style="margin-bottom: 0px">
	<div class="navbar-header">
		<a href="#" class="navbar-minimalize minimalize-styl-2 btn btn-primary "><i class="fa fa-bars"></i> </a>
		<form role="search" class="navbar-form-custom" method="post">
			<div class="form-group">
				<input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
			</div>
		</form>
	</div>
	<ul class="nav navbar-top-links navbar-right">
		<span class="m-r-sm text-muted welcome-message">Welcome to AdminDashboard</span>
		<li>
			<a href="<?php echo Router::url(array('controller' => 'Users', 'action' => 'logout')) ?>">
				<i class="fa fa-sign-out"></i> <?php echo __('log_out') ?>
			</a>
		</li>
	</ul>
</nav>