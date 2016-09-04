<!DOCTYPE html>
<html lang="en">
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<meta http-equiv="X-Ua-Compatible" content="IE=edge" />
<?php include_title() ?>
<?php include_stylesheets(); ?>
<?php include_javascripts() ?>
</head>
<body>
    <header>
      <h1>ARS - <?php echo __('Automatização de Revisões Sistemáticas'); ?></h1>
    </header>

    <?php echo $sf_data->getRaw('sf_content') ?>

    <footer>
      <p><strong><?php echo sfConfig::get('app_company_name') ?></strong> <?php echo sfConfig::get('app_company_title') ?></p>
      <p>Desenvolvido por: <a href="mailto:jefferson@enova.com.br" target="_blank"><strong>Jefferson Seide Molléri</strong></a>.</p>
    </footer>
</body>
</html>
