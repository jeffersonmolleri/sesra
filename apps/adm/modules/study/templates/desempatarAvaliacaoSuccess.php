<?php include_component('systematic_review', 'submenu', array ('review_id' => $review_id)); ?>

<div class="rows-fuild">
  <div class="span12">
    <div class="page-header">
      <h2><?php echo __('Solucionar Divergências na Seleção de Estudos') ?></h2>
    </div>
    
    <p><?php echo __('Este estudo apresentou divergências em sua seleção') ?>:</p>
    
    <div class="alert alert-info">
      <h4><?php echo $study->getTitle() ?></h4>
      <?php echo ($study->getUrl())?'<a href="' . $study->getUrl() . '" target="_blank">' . $study->getUrl() . '</a><br/>':''; ?>
      <?php echo $study->getStudyAbstract() ?>
    </div>

    <ul class="icons-ul">
    	<?php foreach($avaliacoes as $a) :?>
    		<li class="<?php echo ($a->getRslCriteria()->getType() ? 'text-success' : 'text-error') ?>">
    		  <?php echo $a->getRslCriteria()->getType() ? '<i class="icon-plus-sign"></i>' : '<i class="icon-minus-sign"></i>' ?>
    		  <strong><?php echo $users[$a->getUserId()]->getProfile()->getName() ?></strong> 
    		  <?php echo $a->getRslCriteria()->getType() ? 'incluiu' : 'excluiu' ?> <?php echo __('o estudo segundo o critério') ?> 
              <strong><?php echo $a->getRslCriteria()->getName()?></strong>
    		</li>
    	<?php endforeach; ?>
    </ul>
    
	<hr />
	
	<p><?php echo __('Para solucionar este impasse, como mediador você deve selecionar uma das opções a seguir') ?>:</p>
	<div id="msgSave"></div>

    <?php foreach($criterios as $id => $c): ?>
    <label class="radio">
      <input name="criteria_id" type="radio" value='<?php echo $id ?>' > 
	  <?php //echo $c->type ? '<i class="icon-plus-sign" title="<?php echo __('Estudo Incluído') ?>"></i>' : '<i class="icon-minus-sign" title="<?php echo __('Estudo Excluído') ?>"></i>'; ?><a></a>
	  <?php echo $c->type ? '<strong>Inclusão:</strong> ' : '<strong>'.__('Exclusão').':</strong> '; ?><a></a>
      <?php echo $c->name ?>
    </label>
    <?php endforeach;?>
	
	<div class="form-actions">
	  <button id="enviar" class="btn btn-success"><?php echo __('Salvar') ?></button> <?php echo __('ou') ?> <?php echo link_to('Cancelar', '@studies_selection?id='.$review_id, array('class' => 'negate')) ?>
	</div>
  </div>
</div>

<script type="text/javascript">
$(window).load(function () {
	$('#enviar').on('click', function(idx, item) {
		$.post("<?php echo url_for('study/avaliar')?>", { study_id: <?php echo $study->getId() ?>,  criteria_id: $('input[name="criteria_id"]:checked').val() });
	});
});
</script>