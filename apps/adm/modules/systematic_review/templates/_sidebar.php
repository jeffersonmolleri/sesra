<div id="side">
	<div class="block" id="actions">
	<h2><?php echo __('Ações') ?></h2>
	<?php if($sf_params->get('action') != 'new') :?>
	      <?php echo link_to(image_tag('ico16/add') . __('incluir nova revisão sistemática'), 'systematic_review/new') ?>
	<?php endif;?>
	<?php echo link_to(image_tag('ico16/btprev') . __('retornar à lista'), 'systematic_review/index') ?>
	</div>
</div>

