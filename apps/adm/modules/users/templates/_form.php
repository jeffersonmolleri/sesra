<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>

<?php echo update_message('<i class="icon-ok-sign"></i> Os dados do usuário foram atualizados com sucesso.', '<i class="icon-remove-sign"></i> A atualização nos dados do usuário falhou.') ?>

<?php echo form_errors_display($form) ?>

<form class="form-horizontal" action="<?php echo url_for('users/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>

  <?php echo $form->renderHiddenFields() ?>

  <fieldset>
    <legend><?php echo __('Sobre este usuário') ?></legend>

    <div class="control-group">
      <label for="profile_name" class="control-label"><?php echo __('Nome') ?>*:</label>
       <div class="controls"><?php echo $form['name']->render(array('class' => 'input-xxlarge', 'required' => 'required')) ?></div>
    </div>

    <div class="control-group">
      <label for="profile_email" class="control-label"><?php echo __('E-mail') ?>*:</label>
       <div class="controls"><?php echo $form['email']->render(array('class' => 'input-xxlarge', 'required' => 'required')) ?></div>
    </div>

    <div class="control-group">
      <label for="profile_birthdate" class="control-label"><?php echo __('Nascimento') ?>*:</label>
        <div class="controls">
          <div class="datepicker input-append date">
            <?php echo $form['birthdate']->render(array('class' => 'input-xlarge', 'data-format' => 'dd/mm/yyyy', 'type' => 'text', 'required' => 'required')) ?>
            <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
          </div>
        </div>
    </div>
  </fieldset>

  <fieldset>
    <legend><?php echo __('Como o sistema o vê') ?></legend>

    <div class="control-group">
      <label for="username" class="control-label"><?php echo __('Login') ?>*:</label>
      <div class="controls"><?php echo $form['username']->render(array('class' => 'input-xlarge', 'required' => 'required',
        'readonly' => ($form->getObject()->getIsSuperAdmin() || ($form->getObject()->getId() == $sf_user->getId() && !$sf_request->hasParameter('token')))
      )) ?></div>
    </div>

    <?php if(!$form->getObject()->isNew() && !$recover): ?>
      <input type="hidden" name="password_check" id="password_check" value="" />

      <div class="control-group" id="password_label">
      <label>
        <label for="sf_guard_user_password" class="control-label"><?php echo __('Senha') ?>*:</label>
        <div class="controls"><a href="#" class="btn btn-warning" id="pwd"><?php echo __('Alterar senha') ?> <i class="icon-lock"></i></a></div>
      </label>
      </div>

      <div class="control-group" id="password_again_label" style="display: none">
      <label>
        <label for="sf_guard_user_password_again" class="control-label"><?php echo __('Confirmar senha') ?>*:</label>
        <div class="controls"></div>
      </label>
      </div>
    <?php else: ?>
      <input type="hidden" name="password_check" id="password_check" value="1" />

      <div class="control-group">
        <label for="sf_guard_user_password" class="control-label"><?php echo __('Senha') ?>*:</label>
        <div class="controls"><?php echo $form['password']->render(array('class' => 'input-xlarge', 'autocomplete' => 'off', 'required' => 'required')) ?></div>
      </div>

      <div class="control-group">
        <label for="sf_guard_user_password_again" class="control-label"><?php echo __('Confirmar senha') ?>*:</label>
        <div class="controls"><?php echo $form['password_again']->render(array('class' => 'input-xlarge', 'autocomplete' => 'off', 'required' => 'required')) ?></div>
      </div>
    <?php endif; ?>

    <?php if ($user->getIsSuperAdmin()) : ?>
      <input type="hidden" id="sf_guard_user_is_active" name="sf_guard_user[is_active]" value="1" />
    <?php else : ?>
    <div class="control-group">
      <div class="controls">
        <label for="is_active" class="checkbox">
          <?php echo $form['is_active']->render(array('required' => 'required')) ?> <?php echo __('Ativo') ?>?*
        </label>
      </div>
    </div>
    <?php endif; ?>
  </fieldset>

  <?php if ($recover) : foreach ($groups as $group) : ?>
    <input type="hidden" id="sf_guard_user_sf_guard_user_group_list_<?php echo $group->getId() ?>" name="sf_guard_user[sf_guard_user_group_list][<?php echo $group->getId() ?>]" value="<?php echo $group->getId() ?>">
  <?php endforeach; else : ?>
  <fieldset id="groups_list">
    <legend><?php echo __('Permissões') ?></legend>
    <div class="control-group">
      <?php if ($user->getIsSuperAdmin() || $user->getId() == $sf_user->getId()) : ?>
        <div class="controls">
        <?php if ($user->getIsSuperAdmin()) : ?>
          <label for="" class="checkbox"><input type="checkbox" checked="checked" readonly="readonly" /> <?php echo __('É o administrador principal do sistema') ?></label>
        <?php else : ?>
        <?php foreach ($groups as $group) : ?>
          <label for="" class="checkbox"><input type="checkbox" checked="checked" readonly="readonly" /> <?php echo $group->getDescription() ?></label>
        <?php endforeach; endif; ?>
        </div>
      <?php else : ?>
        <?php //echo $form['sf_guard_user_group_list']; ?>
        <?php echo $form['sf_guard_user_permission_list']->render(array('class'=>'perms', 'onclick'=>'turnOffAdmin()')); ?>
      <?php endif; ?>
    </div>
  </fieldset>
  <?php endif; ?>

  <fieldset>
    <legend><?php echo __('Sobre o pesquisador') ?></legend>

    <div class="control-group">
      <label for="sf_guard_user_institute" class="control-label"><?php echo __('Instituição de Pesquisa') ?>:</label>
       <div class="controls"><?php echo $form['institute']->render(array ('class' => 'input-xxlarge')) ?></div>
    </div>

    <div class="control-group">
      <label for="sf_guard_user_description" class="control-label"><?php echo __('Descrição do Pesquisador') ?>:</label>
      <div class="controls"><?php echo $form['description']->render(array ('class' => 'input-xxlarge')) ?></div>
    </div>

    <hr />
    <div class="control-group">
      <label class="control-label">&nbsp;</label>
      <div class="controls"><?php echo save_edit_controls($form->getObject(), 'este usuário') ?></div>
    </div>
  </fieldset>
</form>
<?php
  use_javascript('users');
?>

<script type="text/javascript">
  function addDatePicker()
  {
    $('.datepicker').datetimepicker({
      language: 'pt-BR',
      pickTime: false
    });
  }
  addDatePicker();
</script>