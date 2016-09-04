<header class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
  <?php if ($sf_user->isAuthenticated()) : ?>
    <?php
    $systematic_review = $studies = $users = $contacts = '';
    $m = $sf_context->getModuleName();
    $$m = 'selected';
    ?>
    <div class="container-fluid">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
      <span class="icon-bar"></span>
      </a>
      <a class="brand" href="<?php echo url_for('@homepage')?>" title="<?php echo __('ARS'); ?> - <?php echo __('Automatização de Revisões Sistemáticas'); ?>"><?php echo __('ARS'); ?></a>
      <div class="nav-collapse collapse">
        <ul class="nav">

          <li><?php echo link_to(__('Sobre'), 'index/about', array ('class' => 'about', 'title' => __('Sobre a ferramenta'))) ?></li>

          <?php if ($sf_user->hasCredential('systematic')): ?>
            <li><?php echo link_to(__('Revisões Sistemáticas'), 'systematic_review/index', array ('class' => $systematic_review, 'title' => __('RSLs em andamento'))) ?></li>
          <?php endif; ?>

          <?php if ($sf_user->hasCredential('users')): ?>
            <li><?php echo link_to(__('Usuários'),'users/index', array ('class' => $users, 'title' => __('Usuários do sistema'))); ?></li>
          <?php endif; ?>

          <li><?php echo link_to(__('Contato'), 'index/contacts', array ('class' => 'contacts', 'title' => __('Entre em contato'))) ?></li>
		  
        </ul>
		<ul class="nav pull-right">
		  <li><?php if($sf_user->getCulture() == 'en') : ?>
				<a href="?sf_culture=pt_BR" title="SESRA em português"><span class="icon-globe"></span> Português</a>
			<?php else: ?>
				<a href="?sf_culture=en" title="SESRA in English"><span class="icon-globe"></span> English</a>
			<?php endif; ?>
		  </li>
		  
          <?php if ($sf_user->hasCredential('systematic')): ?>
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $sf_user->getProfile()->getFirstName() ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><?php echo link_to(__('Editar Usuário'), '@editme?id='.$sf_user->getId()) ?></li>
              <li><?php echo link_to(__('Sair'),'@sf_guard_signout', array ()); ?></li>
            </ul>
          </li>
          <?php endif; ?>

        </ul>
      </div>
    </div>
  <?php else: ?>
    <div class="container row-fluid">
      <div class="span12">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        </a>
        <a class="brand" href="/index/index" title="<?php echo __('ARS'); ?> - <?php echo __('Automatização de Revisões Sistemáticas'); ?>"><?php echo __('ARS'); ?></a>
        <div class="nav-collapse collapse">
        <ul class="nav">
          <li><?php echo link_to(__('Sobre'), '/index/about', array ('class' => 'about', 'title' => __('Sobre a ferramenta'))) ?></li>
          <li><?php echo link_to(__('Contate-nos'), '/index/contacts', array ('class' => 'contacts', 'title' => __('Entre em contato'))) ?></li>
        </ul>
		<ul class="nav pull-right">
		  <li><?php if($sf_user->getCulture() == 'en') : ?>
				<a href="?sf_culture=pt_BR" title="SESRA em português"><span class="icon-globe"></span> Português</a>
			<?php else: ?>
				<a href="?sf_culture=en" title="SESRA in English"><span class="icon-globe"></span> English</a>
			<?php endif; ?>
		  </li>
        </ul>
        </div>
      </div>
    </div>
  <?php endif; ?>
  </div>
</header>