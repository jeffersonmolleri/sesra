<?php use_helper('Date', 'Text', 'I18N', 'myWidgets', 'enMessageBox'); ?>

<h1><?php echo __('Grupos de Usuários') ?></h1>

<?php if ($sf_request->hasParameter('name')) : ?>
  <div class="msg alert"><?php echo __('Procurando pelo termo') ?> <strong>"<?php echo $sf_request->getParameter('name')?>"</strong></div>
<?php endif ?>

<table>
  <thead>
    <tr>
      <?php $dir = ($dir == 'asc')?'desc':'asc'; ?>
      <th><?php echo link_to(__('Nome'), 'users/groups?order='.sfGuardGroupPeer::NAME.'&dir='.$dir, array ('class' => ($order == sfGuardGroupPeer::NAME ? $dir : ''))) ?></th>
      <th><?php echo link_to(__('Descrição'), 'users/groups?order='.sfGuardGroupPeer::DESCRIPTION.'&dir='.$dir, array ('class' => ($order == sfGuardGroupPeer::DESCRIPTION ? $dir : ''))) ?></th>
      <th><?php echo __('Ações') ?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($groups->getResults() as $group) : ?>
	    <tr>
	      	  <td><?php echo $group[1] ?></td>
		      <td><?php echo substr($group[2],0,50); ?><?php echo (strlen($group[2]) > 50)?'...':''; ?></td>
		      <?php if ($sf_user->hasCredential('users')) : ?>
			      <td class="ctrls"><?php echo link_to(image_tag('ico16/edit') . 'editar', '@edit_group?id=' . $group[0]) ?>
			      <?php echo ($group[1] == 'administrador') ? '' : link_to(image_tag('ico16/remove') . 'remover', '@delete_group?id=' . $group[0], array ('class' => '')) ?></td>
		      <?php else : ?>
		      	  <td class="ctrls"><?php echo link_to(image_tag('ico16/show.png') . __('visualizar'), '@view_group?id=' . $group[0]) ?></td>
		      <?php endif; ?>
	    </tr>	
	 <?php //endif; ?>
  <?php endforeach; ?>
  <?php if (!$groups->getNbResults()) : ?>
    <tr>
      <td colspan="5" class="emptyCell"><?php echo __('Nenhum grupo encontrado') ?></td>
    </tr>
  <?php endif; ?>
  </tbody>
</table>

<?php echo form_pager_display($groups, "users/groups?page="); ?>
