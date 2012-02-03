<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<?php 
		# inc bootstrap
		$urlScript = Yii::app()->assetManager->publish(Yii::getPathOfAlias('backstage').'/bootstrap/js/bootstrap.min.js', false, -1, true);
		Yii::app()->clientScript->registerScriptFile($urlScript, CClientScript::POS_HEAD);
		$urlScript = Yii::app()->assetManager->publish(Yii::getPathOfAlias('backstage').'/bootstrap/css/bootstrap.css', false, -1, true);
		Yii::app()->clientScript->registerCssFile($urlScript);
	?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="#"><?php echo CHtml::encode(Yii::app()->name) ?></a>
			<div class="nav-collapse">
				<ul class="nav">
					<li class='active'><a href="/backstage">Dashboard</a></li>
					<li><a href="/backstage/faq">FAQ</a></li>
				</ul>
				<ul class="nav pull-right">
					<li ><a href="#" >Account Setting</a></li>
					<li ><a href="#" >View Front</a></li>
				</ul>
				<p class="navbar-text pull-right">Welcome Admin! </p>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>
<div class='clear' style='height:60px'></div>
<div >
	<?php foreach(Yii::app()->user->getFlashes() as $key => $message) {
		if ($key=='counters') {continue;} //no need next line since 1.1.7
		echo "<div class='alert alert-{$key}' style='margin:0 20px 20px 20px;'>".
			"<a class='close'>×</a>".
			"<h4 class='alert-heading'>{$key}</h4>".
			"{$message}".
			"</div>";
	} ?>
</div>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<ul class="breadcrumb">
			  <li>
			    <a href="#">User</a> <span class="divider">/</span>
			  </li>
			  <li class="active">
			    <a href="#">Search</a> 
			  </li>
			</ul>
			<div class="well sidebar-nav">
				<ul class="nav nav-list">
					<li class="nav-header">Search Table List</li>
					<li class="active"><a href="#">User</a></li>
					<li><a href="#">Article</a></li>
					<li class="nav-header">Create New</li>
					<li><a href="#">User</a></li>
					<li><a href="#">Article</a></li>
				</ul>
			</div><!--/.well -->
		</div>
		<div class="span10">
			<?php echo $content; ?>
		</div>
	</div>
	<div id="footer" style='text-align:center;font-size:8pt;color:#777'>
		<div class="clear"></div>
		Copyright &copy; <?php echo date('Y'); ?> by BackStage. All Rights Reserved.
	</div><!-- footer -->
</div>


</body>
</html>
