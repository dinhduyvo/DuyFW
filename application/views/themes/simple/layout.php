<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en" ng-app="canthobox.main">
<head>
	<meta charset="utf-8">
	<title>Cổng thông tin ĐBSCL - <?=isset($title)?$title:""?></title>
	<?php $this->load->view('common'); ?>
</head>
<body ng-controller="LoginController as $loginctrl">

	<header class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-menu">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo site_url("");  ?>">
					<div class="logo">
						<span class="l l1"></span>
						<span class="l l2"></span>
						<span class="l l3"></span>
						<span class="l l4"></span>
						<span class="l l5"></span>
					</div>
					CanthoBox.vn
				</a>
			</div>
			<nav class="collapse navbar-collapse" id="navbar-collapse-menu">
				<ul class="nav navbar-nav navbar-left">
					<?php
					$iflag = 0;
					foreach ($menus as $menu) {
						if($menu["childnum"] == 0 && $menu["parent"] == "") {
							if($iflag == 1){
								echo "</ul>
							</li>";
							}
							$iflag = 0;
							?>
							<li><a href="<?=$this->mu->createMenuLink($menu)?>"><span class="toplink"><?=$menu["title"]?></span></a></li>
							<?php
						}
						else if ($menu["childnum"] > 0 && $menu["parent"] == ""){
							if($iflag == 1){
								echo "</ul></li>";
							}
							$iflag = 1;
							?>

							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="<?=$this->mu->createMenuLink($menu)?>"><span class="toplink"><?=$menu["title"]?> <span class="caret"></span></span></a>
								<ul class="dropdown-menu">
							<?php
						}
						else {
							?>
									<li><a href="<?=$this->mu->createMenuLink($menu)?>"><?=$menu["title"]?></a></li>
							<?php
						}
					}
					if($iflag == 1){
						echo "</ul>
					</li>";
					}
					 ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php
					if ($this->ion_auth->logged_in())
					{
					 ?>
					<li><a href="<?=site_url("auth/edit_user")?>"><span class="glyphicon glyphicon-user"></span> Thông tin cá nhân</a></li>
					<li><a href="<?=site_url("auth/logout")?>"><span class="glyphicon glyphicon-log-in"></span> Đăng xuất</a></li>
					<?php
					}
					else {
					 ?>
					<li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;Đăng ký</a></li>
					<li>
						<a data-toggle="modal" href='#modal-id'><span class="glyphicon glyphicon-log-in"></span>&nbsp;Đăng nhập</a>
					</li>

				<?php } ?>

				</ul>

			</nav>
			</div>
	</header>

	<div class="container main">
		<div class="row">
			<div class="<?=isset($viewright)?"col-md-6 box":"col-md-12 box"?>">

					<?php
		      if (isset ( $view )) {
							foreach ($view as $vitem) {
								$this->load->view ( $vitem );
							}

		      }
					else {
						echo "Trang chưa được thiết lập!";
					}
		      ?>

			</div>
			<?php
			if (isset ( $viewright )) {
			?>
			<div class="col-md-6 box">
				<div class="div-container">
					<?php
							foreach ($viewright as $vitem) {
								$this->load->view ( $vitem );
							}
		      ?>
				</div>
			</div>
			<?php
			}
			 ?>
		</div>
	</div>
	<div id="footer-navigation">
		<div class="container">
			<div class="row">
				<div class="text-center">&copy; 2017 MekongBox.vn</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-id">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span> Login {{email}}</h4>
					</div>
					<div class="modal-body">
						<span class="alert alert-success" style="display: {{successDisplay}}">Login successful!</span>
						<span class="alert alert-danger" style="display: {{failDisplay}}">{{failReason}}</span>
						<div class="form-group">
							<label for="loginEmail"><span class="glyphicon glyphicon-envelope"></span> Email:</label>
							<input type="email" class="form-control" id="identity" name="identity" ng-model="formData.identity" />
						</div>
						<div class="form-group">
							<label for="loginPassword"><span class="glyphicon glyphicon-asterisk"></span> Password:</label>
							<input type="password" class="form-control" id="password" name="password" ng-model="formData.password" />
						</div>
					</div>
					<div class="modal-footer text-center">
						<button class="btn btn-primary" type="button" ng-click="$loginctrl.login('<?php echo site_url('auth/login') ?>')">Đăng nhập</button>
						<button class="btn btn-warning" type="button" ng-click="$loginctrl.cancel()" data-dismiss="modal">Bỏ qua</button>
					</div>
				</div>
			</div>
		</div>

</body>
</html>
