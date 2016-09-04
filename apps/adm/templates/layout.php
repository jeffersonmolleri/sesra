<!DOCTYPE html>
<html lang="en">
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<meta http-equiv="X-Ua-Compatible" content="IE=edge" />

<?php include_title() ?>

<link rel="shortcut icon" href="" type="image/x-icon" />
<?php include_stylesheets(); ?>

<?php //use_dynamic_javascript('bar/defaultJavascript', 'first') ?>

<?php include_javascripts() ?>

<?php include_slot('headscript') ?>

</head>
<body>
  <div id="wrap">
    <?php include_partial('bar/headerfull'); ?>
    <div class="container-fluid">
      <div class="row-fluid" id="content-holder">
         <?php echo $sf_data->getRaw('sf_content') ?>
      </div>
    </div>
    <div id="push"></div>
  </div>

  <?php include_partial('bar/footer'); ?>

  <?php include_slot('form_errors') ?>

  <?php if (sfConfig::get('sf_environment') == 'dev') : ?>
    <script type="text/javascript">
    $(document).ready(function () {
      try { $.taconite.debug = true; } catch (e) {}
    });
    </script>
  <?php endif; ?>
</body>
</html>