    <div class="alert alert-error alert-block">
      <h2><i class="icon-lock"></i> <?php echo __('Acesso Restrito') ?></h2>
      <p><?php echo __('Você não tem as permissões necessárias para acessar este local') ?>.<br />
      <a href="<?php echo url_for('@sf_guard_join'); ?>" class="btn"><i class="icon-user"></i> <?php echo __('Cadastre-se agora') ?></a> <?php echo __('ou') ?> <a href="mailto:jefferson.molleri@univali.br"><?php echo __('entre em contato') ?></a></p>
    </div>