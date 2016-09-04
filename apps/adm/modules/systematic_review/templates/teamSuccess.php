<?php include_component('systematic_review', 'submenu', array ('id' => $id)); ?>
<?php if ($sf_user->hasCredential('systematic')) : ?>
  <div>
  	<h2><?php echo __('Comissionamento da Revisão') ?></h2>

  	<?php include '_form_team.php' ?>
    
    <div class=""> <!-- form-horizontal -->
      <div class="form-actions">
        <div class="btn-group pull-left">
          <?php echo link_to('<i class="icon-ok"></i> '.__('Salvar'), 'systematic_review/team?id='.$id, array('class' => 'btn btn-success')) ?>
          <?php echo link_to('<i class="icon-check"></i> '.__('Salvar e concluir'), 'systematic_review/question?id='.$id, array('class' => 'btn finaliza')) ?>
        </div>
        <div class="btn-group-item pull-left"> <?php echo __('ou'); ?> <a href="/systematic_review" class="negate"><?php echo __('Cancelar') ?></a></div>
      </div>
    </div>
</div>
<?php else : ?>
  <?php include '_restricted.php' ?>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function (){
	$(document).on('click', "#cad_team", function(e) {
		e.preventDefault();
		var time = new Date();
		$.ajax({ type:'POST', dataType:'xml', data: $('form').serialize() , url: $('form').attr('action').concat('&time=', time.getTime()) });
	});
    
  $(".finaliza").click(function(e){
    $.post("<?php echo url_for('systematic_review/finalizaTarefa')?>", { id: <?php echo $id?>, activity: 3 });
  });

	$(document).on('click', 'a[data-action="remove-team-member"]', function (e) {
		$('#team-remove-error').remove();
		e.preventDefault();
		var time = new Date();
		var data = $(this).data();
		var that = $(this).parents('tr');
		$.post("<?php echo url_for('@update_team') ?>?_time=" + time.getTime(), { email: data.id, id: data.context, "do": "remove" })
		.done(function () {
			console.log(that);
			$('#table_list').before('<div id="team-remove-error" class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>Usuário <b>' + data.id + '</b> <?php echo __('removido do grupo de pesquisa') ?>.</div>');
			that.remove();
		})
		.fail(function () {
			$('#table_list').before('<div id="team-remove-error" class="alert alert-error"><a href="#" class="close" data-dismiss="alert">&times;</a><?php echo __('Não foi possível remover o usuário') ?> <b>' + data.id + '</b> <?php echo __('do grupo de pesquisa') ?>.</div>');
		});
	});
});
</script>