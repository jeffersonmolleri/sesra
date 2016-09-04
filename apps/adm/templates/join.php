<!DOCTYPE html>
<html lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>
<meta http-equiv="X-Ua-Compatible" content="IE=edge" />
<?php include_title() ?>

<link rel="shortcut icon" href="" type="image/x-icon" />

<?php include_stylesheets(); ?>
<?php /*
<!--[if lt IE 7]>
  <link href="/adm/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if IE]>
  <link href="/adm/css/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
*/?>
<!-- <script type="text/javascript" src="<?php //echo url_for('bar/defaultJavascript') ?>"></script> -->

<?php include_javascripts() ?>

</head>
<body>
	<div id="wrap">
		<header class="navbar navbar-inverse">
		  <div class="navbar-inner">
			<div class="container">
			  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </a>
			  <a class="brand" href="/index/index" title="<?php echo __('ARS'); ?> - <?php echo __('Automatização de Revisões Sistemáticas'); ?>"><?php echo __('ARS'); ?></a>
			  <div class="nav-collapse collapse">
				<ul class="nav">
				  <li><a href="<?php echo url_for('index/about'); ?>" title="<?php echo __('Sobre a ferramenta'); ?>"><?php echo __('Sobre'); ?></a></li>
				  <li><a href="<?php echo url_for('index/contacts'); ?>" title="<?php echo __('Entre em contato'); ?>"><?php echo __('Contato'); ?></a></li>
				</ul>
			  </div><!--/.nav-collapse -->
			</div>
		  </div>
		</header>

		<div class="container row-fluid">
			<?php echo $sf_data->getRaw('sf_content') ?>
      <div id="push"></div>
		</div>
	</div>

	<?php include_partial('bar/footer'); ?>
</body>
</html>
