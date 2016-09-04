<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>
<?php 
	$user = sfContext::getInstance()->getUser();
	if($user->hasFlash('update'))
		if($user->getFlash('update') == 'not_send_email')
			echo msbox_alert(__('Pesquisador cadastrado com sucesso, no entanto o convite para <strong>%c1</strong> não pôde ser enviado.'), array('%c1%' => empty($email) ? '' : $email));
		else if($user->getFlash('update') == 'error')
			echo msbox_error(__('Ocorreu um erro ao cadastrar o email <strong>%c1</strong>, tente cadastrar novamente mais tarde.'), array('%c1%' => empty($email) ? '' : $email));
		else
			echo msbox_success(__('Convite enviado para <strong>%c1</strong> com sucesso'), array('%c1%' => empty($email) ? '' : $email));
?>
<?php echo form_errors_display($form) ?>
<?php if ($sf_user->hasFlash('has_email')) : ?>
	<div id="messages_holder">
		<div class="alert alert-error"><?php $email = $sf_request->getParameter('email'); echo __('O e-mail <strong>%c1%</strong> já está na equipe de pesquisa ou esperando confirmação', array('%c1%' => empty($email) ? '' : $email)) ?>.</div>
	</div>
<?php endif; ?>
<form action="<?php echo url_for('@update_team?id='.$id) ?>" method="post">
	<input type="hidden" name="do" value="add">
	<table class="table table-striped">
		<thead>
		<tr>
			<th style="width: 5%;"></th>
			<th style="width: 30%;"><?php echo __('Nome') ?></th>
			<th style="width: 25%;"><?php echo __('E-mail') ?></th>
			<th style="width: 20%;"><?php echo __('Papel') ?></th>
			<th style="width: 20%;"></th>
		</tr>
		</thead>
		<tbody>
			<tr class="success">
				<td>&nbsp;</td>
				<td class="valign-middle"><label for="email" class="pull-right"><?php echo __('Incluir integrante') ?>:</label></td>
				<td><input type="text" name="email" id="email" /></td>
				<td>
					<select name="level" id="level">
						<?php foreach ($levels as $x => $level) : ?>
							<option value="<?php echo $x ?>"><?php echo __($level); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td><a class="btn btn-success" id="cad_team"><i class="icon-plus-sign"></i> <?php echo __('adicionar') ?></a></td>
			</tr>
		<?php if (!empty($users)) : foreach ($users as $user) : ?>
			<tr id="team-member-<?php echo $user->getUserId() ?>">
				<?php $last_login = $user->getsfGuardUser()->getLastLogin(); ?>
				<td class="ctrls"><?php echo (empty($last_login))?'<i class="icon-question-sign" title="'. __('Aguardando confirmação') .'"></i>':'<i class="icon-ok-sign" title="'. __('Integrado à equipe') .'"></i>'; ?></td>
				<td><strong><?php echo $user->getsfGuardUser()->getProfile()->getName(); ?></strong></td>
				<td><?php echo $user->getsfGuardUser()->getProfile()->getEmail(); ?></td>
				<td><?php echo __($all_levels[$user->getLevel()]); ?></td>
				<td class="ctrls">
				<?php if ($user->getLevel() != SystematicReview::COORDENADOR) : ?>
				<div class="btn-group">
					<a href="#" data-action="remove-team-member" data-context="<?php echo $id ?>" data-id="<?php echo $user->getsfGuardUser()->getProfile()->getEmail() ?>" class="btn btn-mini btn-danger"><i class="icon-remove-sign"></i> <?php echo __('remover') ?></a>
				</div>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; else : ?>
			<tr>
				<td colspan="5"><?php echo __('Nenhum integrante para esta revisão sistemática') ?></td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
</form>