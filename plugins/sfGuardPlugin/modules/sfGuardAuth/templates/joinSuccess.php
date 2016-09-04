<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>
<?php echo update_message('<i class="icon-ok-sign"></i> Usuário criado com sucesso! <a href="'.url_for('@homepage').'" class="btn btn-success">Retornar a página de Login</a>', '<i class="icon-remove-sign"></i> Houve um erro na criação do usuário') ?>
  <?php if (!isset($has_email)) : ?>
      <?php echo form_errors_display($form) ?>
    <?php else : ?>
      <?php if ($form->hasErrors()) : ?>
        <?php echo form_errors_display($form,true,true,true) ?>
      <?php else : ?>
        <div id="messages_holder">
          <div class="msg alert alert-block alert-info">
            <h4><?php echo __('E-MAIL já cadastrado!'); ?></h4>
            <?php echo __('Esqueceu sua senha ou não sabe se já foi convidado? Obtenha aqui uma'); ?> <a href="#" class="btn btn-primary btn-large" style="margin-top: -4px" data-target="newtoken"><?php echo __('nova chave de acesso'); ?></a>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  <form class="form-horizontal" action="<?php echo url_for('@sf_guard_create_user') ?>" method="post">
    <fieldset>
      <legend><?php echo __('Sobre o usuário'); ?></legend>

      <div class="control-group">
        <label for="profile_name" class="control-label"><?php echo __('Nome'); ?>*:</label>
         <div class="controls"><?php echo $form['name']->render(array('class' => 'input-xxlarge', 'required' => 'required')) ?></div>
      </div>

      <div class="control-group">
        <label for="profile_email" class="control-label"><?php echo __('E-mail'); ?>*:</label>
         <div class="controls"><?php echo $form['email']->render(array('class' => 'input-xxlarge', 'required' => 'required')) ?></div>
      </div>

      <div class="control-group">
        <label for="profile_birthdate" class="control-label"><?php echo __('Nascimento'); ?>:</label>
          <div class="controls">
            <div class="input-append datepicker date">
              <?php echo $form['birthdate']->render(array('class' => 'input-large', 'data-format' => 'dd/MM/yyyy')) ?>
              <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
            </div>
            <span class="help-inline"><?php echo __('Formato: dd/mm/aaaa'); ?></span>
          </div>
      </div>
    </fieldset>

  <fieldset>
    <legend><?php echo __('Como o sistema o vê'); ?></legend>
    <div class="control-group">
      <label for="username" class="control-label"><?php echo __('Login'); ?>*:</label>
       <div class="controls"><?php echo $form['username']->render(array('class' => 'input-large', 'required' => 'required', 'autocomplete' => 'off')) ?></div>
    </div>

    <?php if(!$form->getObject()->isNew() && $form->getObject()->getLastLogin()): ?>
      <input type="hidden" name="password_check" id="password_check" value="" />

      <div class="control-group">
      <label id="password_label">
        <label for="sf_guard_user_password" class="control-label"><?php echo __('Senha'); ?>*:</label>
        <div class="controls"><a href="#" class="btn" id="pwd"><?php echo __('Alterar senha'); ?> <i class="icon-lock"></i></a></div>
      </label>
      </div>

      <div class="control-group">
      <label id="password_again_label" style="display: none">
        <label for="sf_guard_user_password_again" class="control-label"><?php echo __('Confirmar senha'); ?>*:</label>
        <div class="controls"></div>
      </label>
      </div>
    <?php else: ?>
      <input type="hidden" name="password_check" id="password_check" value="1" />

      <div class="control-group">
        <label for="sf_guard_user_password" class="control-label"><?php echo __('Senha'); ?>*:</label>
         <div class="controls"><?php echo $form['password']->render(array('class' => 'input-large', 'autocomplete' => 'off', 'required' => 'required')) ?></div>
      </div>

      <div class="control-group">
        <label for="sf_guard_user_password_again" class="control-label"><?php echo __('Confirmar senha'); ?>*:</label>
         <div class="controls"><?php echo $form['password_again']->render(array('class' => 'input-large', 'autocomplete' => 'off', 'required' => 'required')) ?></div>
      </div>
    <?php endif; ?>

    <?php echo $form['is_active']->render(array('required' => 'required', 'type' => 'hidden')) ?>
  </fieldset>

  <fieldset>
    <legend><?php echo __('Sobre o pesquisador'); ?></legend>

    <div class="control-group">
      <label for="sf_guard_user_institute" class="control-label"><?php echo __('Instituição de Pesquisa'); ?>:</label>
       <div class="controls"><?php echo $form['institute']->render(array ('class' => 'input-xxlarge')) ?></div>
    </div>

    <div class="control-group">
      <label for="sf_guard_user_description" class="control-label"><?php echo __('Descrição do Pesquisador'); ?>:</label>
      <div class="controls"><?php echo $form['description']->render(array ('class' => 'input-xxlarge')) ?></div>
    </div>

    <hr />

    <div class="control-group">
      <label class="control-label">&nbsp;</label>
      <div class="controls"><?php echo save_edit_controls($form->getObject(), __('este usuário')) ?></div>
    </div>
  </fieldset>
</form>
<div class="hide" id="token"></div>
<?php
  use_javascript('users');
  use_javascript('jquery/jquery.maskedinput.js');
?>
<script type="text/javascript">
  $(document).ready(function(){
    $('a[data-target="newtoken"]').on('click', function (e) {
      e.preventDefault();
      $("#token").html($('<form id="form-token" method="post" action="<?php echo url_for('sfGuardAuth/retrieveNewToken') ?>"><input type="hidden" name="email" value="' + $('#sf_guard_user_email').val() + '"></form>'));
      $('#form-token').submit();
    });
    $('.datepicker').datetimepicker({
      language: 'pt-BR',
      pickTime: false
    });
    $('#sf_guard_user_birthdate').mask('99/99/9999');
  });
</script>
