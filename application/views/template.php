<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?echo $this->config->item('website_name');?></title>
<meta name="description" content="">
<meta name="author" content="">

<!-- HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- Styles -->
<?php display_css('bootstrap.css'); ?>
<?php 
if ($this->config->item('use_browser_reject')) {
	display_css('jquery.reject.css');
}
if ($this->config->item('bootstrap_responsive')) {
	display_css('bootstrap-responsive.css');
}
?>
<?php display_css('style.css'); ?>
<script type="text/javascript">
var WEB_ROOT = "<?php echo site_url();?>";
</script>
<link rel="shortcut icon" href="img/favicon.ico">
</head>

<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">

			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse"
					data-target=".nav-collapse"> <span class="icon-bar"></span> <span
					class="icon-bar"></span> <span class="icon-bar"></span>
				</a> <a class="brand" href="<?echo site_url("/");?>"><? echo $this->config->item('website_name');?>
				</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li class="active"><a href="/">Home</a></li>
					</ul>

					<?php if (!$this->tank_auth->is_logged_in()) { ?>
					<form action="<?echo site_url("/auth/login");?>" method="post"
						class="navbar-form pull-right">
						<input class="input-small" type="text" name="login" maxlength="30"
							placeholder="Username"> <input class="input-small"
							type="password" name="password" placeholder="Password">
						<button class="btn" type="submit">Sign in</button>
					</form>
					<?php }else{ ?>

					<ul class="nav pull-right">
						<li><a href="###">Link</a></li>
						<li class="divider-vertical" />

						<li class="dropdown"><a data-toggle="dropdown"
							class="dropdown-toggle" href="###"><?=$this->tank_auth->get_username()?>
								<b class="caret"></b> </a>
							<ul class="dropdown-menu">
								<li><a href="###">Link</a></li>

								<li class="divider" />

								<li><a href="<?echo site_url("/auth/logout/");?>">Logout</a></li>
							</ul>
						</li>
					</ul>
					<?php } ?>

				</div>
				<!--/.nav-collapse -->


			</div>
		</div>
	</div>

	<div class="container">
		<div class="content">
			<div class="page-header">
				<?= $header ?>
			</div>
			<?= $content ?>
		</div>
		<hr />
		<footer>
			<p>
				&copy;
				<?echo $this->config->item('website_name');?>
				2012
			</p>
		</footer>

	</div>
	<?php display_js(array('jquery-1.7.1.min.js', 'bootstrap.min.js', 'index.js')); ?>
	<?php 
	if ($this->config->item('use_browser_reject')) {
		display_js('jquery.reject.js');
	?>
	<script type="text/javascript">
	$(function(){
	    $.reject({  
	        reject: { msie: true, // Microsoft Internet Explorer  
	            konqueror: true, // Konqueror (Linux)  
	            unknown: true // Everything else  
	            }, 
	        header: '您的浏览器不能很好的支持HTML5', // Header Text  
	        paragraph1: '很抱歉的告诉您，您的浏览器可能会不支持我们的所有功能;', // Paragraph 1  
	        paragraph2: '我们强烈建议您下载以下浏览器中的一个以获得更好的浏览体验.', // Paragraph 2  
	        closeLink: '关闭该窗口，继续浏览',
	        closeMessage:"",
	        imagePath: WEB_ROOT + '/../img/',
	        display: ['firefox','chrome','opera'] 
	    }); // Customized Text  		
	});
	</script>
	<?php 
	}
	?>
</body>
</html>


