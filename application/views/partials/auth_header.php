<html>
<head>
	<title>Home | Markfed</title>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
 <link href="<?=base_url('assets/css/main.css')?>" rel="stylesheet">
 </head>
	<body>
     <nav class="navbar navbar-default">
				<div class="container-fluid">
				  <!-- Brand and toggle get grouped for better mobile display -->
				  <div class="navbar-header">
				    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				      <span class="sr-only">Toggle navigation</span>
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
				    </button>
          </div>

				  <!-- Collect the nav links, forms, and other content for toggling -->
				  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				    <ul class="nav navbar-nav">
				      <li class=""><a href="<?=site_url()?>">Home <span class="sr-only">(current)</span></a></li>
				      <li class=""><a href="<?=site_url('/auth/login')?>">Login <span class="sr-only">(current)</span></a></li>
				      <li class=""><a href="<?=site_url('/auth/Register')?>">Register</a></li>
				      <li><a href="<?=site_url('/auth/forgot_password')?>">Forgot Password</a></li>
				    </ul>
				  </div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
				</nav>
