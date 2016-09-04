<?php use_helper('Date', 'Text', 'I18N', 'myWidgets', 'enMessageBox'); ?>

<div class="page-header">
  <h1><?php echo __('Usuários do sistema') ?></h1>
</div>

<?php if ($sf_request->hasParameter('name')) : ?>
  <div class="msg alert"><?php echo __('Procurando pelo termo') ?> <strong>"<?php echo $sf_request->getParameter('name')?>"</strong></div>
<?php endif ?>

<table class="table table-striped">
  <thead>
    <tr>
      <?php $dir = ($dir == 'asc')?'desc':'asc'; ?>
      <th><?php echo link_to(__('Usuário'), 'users/index?order='.sfGuardUserPeer::USERNAME.'&dir='.$dir, array ('class' => ($order == sfGuardUserPeer::USERNAME ? $dir : ''))) ?></th>
      <th><?php echo link_to(__('Nome'), 'users/index?order='.sfGuardUserProfilePeer::NAME.'&dir='.$dir, array ('class' => ($order == sfGuardUserProfilePeer::NAME ? $dir : ''))) ?></th>
      <th><?php echo link_to(__('Ativo?'), 'users/index?order='.sfGuardUserPeer::IS_ACTIVE.'&dir='.$dir, array ('class' => ($order == sfGuardUserPeer::IS_ACTIVE ? $dir : ''))) ?></th>
      <th><?php echo link_to(__('Último acesso'), 'users/index?order='.sfGuardUserPeer::LAST_LOGIN.'&dir='.$dir, array ('class' => ($order == sfGuardUserPeer::LAST_LOGIN ? $dir : ''))) ?></th>
      <th><?php echo __('Ações') ?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($users->getResults() as $user) : ?>
			<tr>
		      <td><?php echo $user[1] ?></td>
			      <td><?php echo truncate_text($user[3]) ?></td>
			      <td><?php echo ($user[5] ? '<i class="icon-ok-sign"></i>' : '<i class="icon-remove-sign"></i>') ?></td>
			      <td><?php echo en_distance_of_time_in_words($user[4]) ?></td>
			      <?php if ($sf_user->hasCredential('users')) : ?>
            
              <td class="ctrls">
                <div class="btn-group">
                  <?php echo link_to('<i class="icon-pencil"></i> editar', 'users/edit?id=' . $user[0], array ('class' => 'btn btn-mini btn-info')) ?>
                  <?php echo ($user[1] == 'admin') ? '' : link_to('<i class="icon-remove-sign"></i> excluir', 'users/delete?id=' . $user[0], array ('class' => 'btn btn-mini btn-danger')) ?>
                </div>
              </td>
              
			      <?php else : ?>
			        <td></td>
			      <?php endif; ?>
		    </tr>
  <?php endforeach; ?>
  <?php if (!$users->getNbResults()) : ?>
    <tr>
      <td colspan="5" class="emptyCell"><?php echo __('Nenhum usuário encontrado') ?></td>
    </tr>
  <?php endif; ?>
  </tbody>
</table>

<?php echo form_pager_display($users, "users/index?page="); ?>
