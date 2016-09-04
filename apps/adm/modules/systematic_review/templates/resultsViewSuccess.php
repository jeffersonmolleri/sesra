
<?php if ($sf_user->hasCredential('systematic')) : ?>
  <?php if (!$partial) : ?>
  <div class="rows-fluid">

    <div class="span12">
      <div class="page-header">
        <h2><?php echo __('Relatório da Revisão') ?></h2>
      </div>
  <?php endif; ?>

      <?php include '_view_results.php' ?>
  <?php if (!$partial) : ?>
      <?php //var_dump($metadata); ?>

      <div class="modal hide fade" id="myModal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3><?php echo __('Inserir Anotação') ?></h3>
        </div>
        <form method="post" action="#" id="observacaoForm">
	        <div class="modal-body">
	          <h4 id="columnTitle"><?php echo __('Título da Área') ?></h4>
	          <textarea name="observation" id="observation" class="span12"></textarea>
	        </div>
	        <?php if(!empty($rid)): ?>
	        <input type="hidden" name="owner_id" value="<?php echo $rid;?>"></input>
	        <input type="hidden" name="owner_model" value="rsl_results"></input>
	        <?php else: ?>
	        <input type="hidden" name="owner_id" value="<?php echo $pid;?>"></input>
	        <input type="hidden" name="owner_model" value="protocol"></input>
	        <?php endif; ?>
	        <input type="hidden" id="owner_column" name="owner_column" value=""></input>
	        <div class="modal-footer">
	          <button type="submit" class="btn btn-success submit"><?php echo __('Salvar anotação') ?></button>
	          <div class="btn-group-item pull-right"> <?php echo __('ou') ?> <a href="#" data-dismiss="modal"><?php echo __('Cancelar') ?></a></div>
	        </div>
	    </form>
      </div>
    </div>
  </div>
<?php
  use_javascript('wysihtml5/wysihtml5-0.3.0.js');
  use_javascript('bootstrap/bootstrap-wysihtml5.js');
  use_javascript('bootstrap/bootstrap-wysihtml5.pt-BR.js');
?>

<?php $culture = (sfContext::getInstance()->getUser()->getCulture() == 'pt_BR')?'pt-BR':'en'; ?>

<script type="text/javascript">
	$('#observation').wysihtml5({locale: "<?php echo $culture; ?>"});

	$("#myModal").modal({show:false});
	$(document).ready(function(){
		  $('a[data-context="addanotacao"]').click(function(e){
			  e.preventDefault();
			  var data = $(this).data();
			  var label = $(this).parent().text();
			  $('#columnTitle').text(label.substring(0,label.lastIndexOf(' ')));
			  $('#owner_column').val($(this).data('target'));
			  $('#myModal').modal("show");
		  });

		  $(".submit").click(function(e){
	    	  e.preventDefault();
	    	  $.post("<?php echo url_for('add_observacao')?>", $('#observacaoForm').serialize());
			  $('#myModal').modal("hide");
	    });
	});
</script>
<?php endif; ?>
<?php else : ?>
  <?php include '_restricted.php' ?>
<?php endif; ?>