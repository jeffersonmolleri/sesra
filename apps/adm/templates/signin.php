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
<body id="front">
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
				<ul class="nav pull-right">
				  <li><?php if($sf_user->getCulture() == 'en') : ?>
						<a href="?sf_culture=pt_BR" title="SESRA em português"><span class="icon-globe"></span> Português</a>
					<?php else: ?>
						<a href="?sf_culture=en" title="SESRA in English"><span class="icon-globe"></span> English</a>
					<?php endif; ?>
				  </li>
				</ul>
			  </div><!--/.nav-collapse -->
			</div>
		  </div>
		</header>

		<div class="jumbotron">
          <div class="container">

    		<?php if ($sf_user->hasFlash('invalid_token')) : ?>
    		<div class="container row-fluid">
    		  <div class="alert alert-large alert-error">
    		    <h2><i class="icon-warning-sign"></i> <?php echo __('O TOKEN informado não é válido'); ?>.</h2>
    		    <p><?php echo __('Contate o administrador do site e requira uma nova chave de acesso'); ?>.</p>
    		  </div>
    		</div>
    		<?php endif; ?>

            <?php echo $sf_content ?>

            <h1 class="heading"><?php echo __('Automatização de Revisões Sistemáticas em Engenharia de Software'); ?></h1>
            <p class="subheading"><?php echo __('Participação de diversos pesquisadores, automatização de buscas, gestão de referências online, suporte a todos os estágios do processo'); ?>.<br />
              <small><a href="<?php echo url_for('index/about'); ?>" title="<?php echo __('Saiba mais'); ?>"><?php echo __('Saiba mais'); ?></a></small></p>
          </div>
        </div>

		<div class="container">
          <div class="teasers">
            <div class="teaser">
              <span class="icon text-info"><i class="icon-group"></i></span>
              <h3><?php echo __('Participação de diversos pesquisadores'); ?></h3>
              <p><?php echo __('Usuários podem participar como pesquisadores ou mediadores na condução de revisões sistemáticas'); ?>.</p>
            </div>
            <div class="teaser">
              <span class="icon text-info"><i class="icon-cogs"></i></span>
              <h3><?php echo __('Automatização de buscas e gestão de referências'); ?></h3>
              <p><?php echo __('Importação de arquivos de referência e busca automatizada em bases de estudos relacionados a Engenharia de Software'); ?>.</p>
            </div>
            <div class="teaser">
              <span class="icon text-info"><i class="icon-sitemap"></i></span>
              <h3><?php echo __('Suporte a todos os estágios do processo'); ?></h3>
              <p><?php echo __('Conforme diretrizes propostas por'); ?> <a href="http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.154.1446&rep=rep1&type=pdf" target="_blank"><?php echo __('Kitchenham e Charters (2007)'); ?></a> <?php echo __('e outros autores'); ?>.</p>
            </div>
          </div>
        </div>
        <div id="passrec-modal" class="modal hide fade">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?php echo __('Esqueci minha senha'); ?>!</h3>
          </div>
          <div class="modal-body">
            <div id="passrec-form">
            <p><?php echo __('Para obter uma chave de acesso temporária, preencha o e-mail associado ao seu cadastro'); ?>:</p>
            <form action="" method="post">
              <input type="text" name="email" id="email" class="input-block-level" placeholder="seu endereço de e-mail" required="required">
            </form>
            </div>
            <h4 class="hide"><img alt="enviando..." src="/img/preloader.gif"> <?php echo __('enviando...'); ?></h4>
            <div id="passrec-response"></div>
          </div>
          <div class="modal-footer">
            <button id="passrec-close" class="btn btn-primary hide" data-dismiss="modal" aria-hidden="true"><?php echo __('Fechar'); ?></button>
            <a id="passrec-send" href="#" class="btn btn-primary"><?php echo __('Enviar chave de acesso'); ?></a>
          </div>
        </div>
      <div id="push"></div>
	</div>

	<?php include_partial('bar/footer'); ?>
</body>
</html>
