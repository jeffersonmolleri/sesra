	<?php use_helper('Date', 'Text', 'I18N', 'enWidgets'); ?>
	<?php $method = 'get'.$sf_request->getParameter('message','ValidationInvite'); ?>
	
	
	<table class="table table-striped">
		<tbody>
		<?php if (!empty($users)) : foreach ($users as $user) : ?>
			<tr id="team-member-<?php echo $user->getUserId() ?>">
				<?php $last_login = $user->getsfGuardUser()->getLastLogin(); ?>
				<td>
					<strong><?php echo __($user->getsfGuardUser()->getProfile()->getName()); ?></strong>
				</td>
				<td><a href="mailto:<?php echo $user->getsfGuardUser()->getProfile()->getEmail(); ?>"><?php echo $user->getsfGuardUser()->getProfile()->getEmail(); ?></a></td>
				<td>
					<?php echo ($user->$method())?'<i class="icon-ok-sign"></i> '. __('solicitado em ').date('d/m/Y',strtotime($user->$method())):''; ?>
				</td>
			</tr>
		<?php endforeach; else : ?>
			<tr>
				<td colspan="3"><?php echo __('Nenhum mediador/revisor foi cadastrado para esta revisão sistemática') ?></td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
