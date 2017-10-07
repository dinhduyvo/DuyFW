<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" ng-app="canthobox.main">  <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">

    <title>Cổng thông tin Cần Thơ<?=isset($title)?" - ".$title:""?></title>
	<?php $this->load->view('common'); ?>
    <!-- CSS -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href="<?=base_url()?>assets/<?=DUYTEMPLATE?>css/animate.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/<?=DUYTEMPLATE?>css/bootsnav.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/<?=DUYTEMPLATE?>css/style.css" rel="stylesheet">
    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>
<body ng-controller="LoginController as $loginctrl">     
        
    <!-- Start Navigation -->
    <nav class="navbar navbar-default bootsnav navbar-fixed-top">
        <!-- Start Top Search -->
        <div class="top-search">
            <div class="container">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search">
                    <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                </div>
            </div>
        </div>
        <!-- End Top Search -->

        <div class="container">            
            <!-- Start Atribute Navigation -->
            <div class="attr-nav">
                <ul>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                            <i class="fa fa-shopping-bag"></i>
                            <span class="badge">3</span>
                        </a>
                        <ul class="dropdown-menu cart-list">
                            <li>
                                <a href="#" class="photo"></a>
                                <h6><a href="#">Delica omtantur </a></h6>
                                <p>2x - <span class="price">$99.99</span></p>
                            </li>
                            <li>
                                <a href="#" class="photo"></a>
                                <h6><a href="#">Omnes ocurreret</a></h6>
                                <p>1x - <span class="price">$33.33</span></p>
                            </li>
                            <li>
                                <a href="#" class="photo"></a>
                                <h6><a href="#">Agam facilisis</a></h6>
                                <p>2x - <span class="price">$99.99</span></p>
                            </li>
                            <li class="total">
                                <span class="pull-right"><strong>Total</strong>: $0.00</span>
                                <a href="#" class="btn btn-default btn-cart">Cart</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a data-toggle="modal" href='#modal-id'>
                            <i class="fa fa-user"></i>
                        </a>
                        
                    </li>
                    <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                    <li class="side-menu"><a href="#"><i class="fa fa-bars"></i></a></li>
                </ul>
            </div>
            <!-- End Atribute Navigation -->

            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="<?php echo site_url(""); ?>">
					<div class="logo">
						
					</div>
					CanthoBox.vn
				</a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-left" data-in="fadeInDown" data-out="fadeOutUp">

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
								<a class="dropdown-toggle" data-toggle="dropdown" href="<?=$this->mu->createMenuLink($menu)?>"><span class="toplink"><?=$menu["title"]?></span></a>
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
            </div><!-- /.navbar-collapse -->
        </div>   

        <!-- Start Side Menu -->
        <div class="side">
            <a href="#" class="close-side"><i class="fa fa-times"></i></a>
            <div class="widget">
                <h6 class="title">Custom Pages</h6>
                <ul class="link">
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Portfolio</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="widget">
                <h6 class="title">Additional Links</h6>
                <ul class="link">
                    <li><a href="#">Retina Homepage</a></li>
                    <li><a href="#">New Page Examples</a></li>
                    <li><a href="#">Parallax Sections</a></li>
                    <li><a href="#">Shortcode Central</a></li>
                    <li><a href="#">Ultimate Font Collection</a></li>
                </ul>
            </div>
        </div>
        <!-- End Side Menu -->
    </nav>
    <!-- End Navigation -->

    <div class="clearfix"></div>

    <!-- Start Content -->
	<div class="clearfix"></div>
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
				<div class="text-center">&copy; 2017 CanthoBox.vn</div>
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
    <!-- End Content -->
    
	
    <!-- Bootsnavs -->
    <script src="<?=base_url()?>assets/<?=DUYTEMPLATE?>js/bootsnav.js"></script>

</body>
</html>