<html select="#<?php echo $display_in ?>"><?php echo '<![CDATA[' ?>
<div class="alert alert-info span11">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php if(empty($onthologies)): ?>
	<?php echo __('Não foi encontrado termos semelhantes a esta(s) palavra(s)') ?>
	<?php else: ?>
	<strong><?php echo __('Termos sugeridos') ?>:</strong>
	<?php foreach($onthologies as $ont): ?>
		<a class='_<?php echo $target?>' href='#' nowrap='nowrap'><?php echo $ont ?></a>
	<?php endforeach; ?>
	<?php endif;?>
</div>
]]>
</html>
<eval>
$('._<?php echo $target?>').on('click', function(e) {
	e.preventDefault();
	$('#<?php echo $target?>').val($('#<?php echo $target?>').val() + ', ' + $(this).html());
	$(this).remove();
});
</eval>