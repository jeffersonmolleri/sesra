<?php use_helper('Date', 'Text', 'I18N', 'enWidgets'); ?>

<?php ob_start();?>
<ul class="dropdown-menu">
	<li><?php echo link_to('<i class="icon-external-link"></i> Guidelines for performing Systematic Literature <br />Reviews in Software Engineering v.2.3<br />- Kitchenham e Charters, 2007', 'http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.154.1446&rep=rep1&type=pdf', array('target' => '_blank')) ?></li>
	<li class="divider"></li>
    <li><?php echo link_to('<i class="icon-external-link"></i> Systematic Review in Software Engineering<br />- Biolchini, Mian, Natali, Travassos, 2005', 'http://alarcos.inf-cr.uclm.es/doc/MetoTecInfInf/Articulos/es67905.pdf', array('target' => '_blank')) ?></li>
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('support' => $support, 'review_id' => $review_id));
?>

<div id="dataExtrationModal" class="modal hid fade">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3><?php echo __('Extração de Dados') ?></h3>
    </div>
    <form id="metadataForm" action="<?php echo url_for('@studies_extrat_metadata')?>" method="POST">
      <div class="modal-body" id="data_extation_modal_body"></div>
    </form>
    <div class="modal-footer">
      <button class="btn btn-success" id="extration_save"><i class="icon-ok"></i> <?php echo __('Salvar') ?></button>
      <?php echo __('ou') ?> <a href="#" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancelar') ?></a>
    </div>
</div>

<div class="rows-fuild">
  <div class="span9">
    <div class="page-header">
      <h2><?php echo __('Extração de Dados') ?></h2>
    </div>

    <p><?php echo __('Envolve o registro de dados específicos de cada estudo que possam ser utilizados para síntese e nos resultados da revisão') ?>.</p>

    <div id="msg"></div>

    <?php
	  include_component('study', 'studylist', array ('filter' => $filter, 'review_id' => $review_id, 'title' => $title, 'studies' => $studies, 'actionName' => $sf_context->getActionName()));
	?>
    
    <div class=""> <!-- form-horizontal -->
      <div class="form-actions">
        <div class="btn-group pull-left">
          <?php echo link_to('<i class="icon-ok"></i> '.__('Salvar'), '@data_extraction?id='.$review_id, array('class' => 'btn btn-success')) ?>
          <?php echo link_to('<i class="icon-check"></i> '.__('Salvar e concluir'), '@data_synthesis?id='.$review_id, array('class' => 'btn finaliza')) ?>
        </div>
        <div class="btn-group-item pull-left"> <?php echo __('ou'); ?> <a href="/systematic_review" class="negate"><?php echo __('Cancelar') ?></a></div>
      </div>
    </div>
  </div>
  <div class="span3">
    <div class="well affix span3" style="padding: 8px 0;">
      <ul id="sidebar" class="nav nav-list">
        <li class="nav-header"><?php echo __('Filtrar') ?></li>
        <li><?php echo link_to('<i class="icon-star-empty"></i> '.__('extração não iniciada'), '@data_extraction?filter=not_extracted&id='.$review_id) ?></li>
        <li><?php echo link_to('<i class="icon-star-half-full"></i> '.__('extração em andamento'), '@data_extraction?filter=initialized&id='.$review_id) ?></li>
        <li><?php echo link_to('<i class="icon-star"></i> '.__('extração concluída'), '@data_extraction?filter=extract&id='.$review_id) ?></li>
        <li><?php echo link_to('<i class="icon-circle"></i> '.__('todos os estudos'), '@data_extraction?id='.$review_id) ?></li>
        <li class="divider"></li>
        <li>
          <form action="<?php echo url_for( '@data_extraction?id='. $review_id) ?>" class="element input-append" method="get">
            <input type="text" name="title" id="search" placeholder="Pesquisar" class="span8" value="<?php echo $title ?>" />
            <?php echo button_tag('<i class="icon-search"></i>', 'class=btn') ?>
          </form>
        </li>
      </ul>
    </div>
  </div>
</div>


<script type="text/javascript">
$(window).load(function () {
	$('.avaliar').each(function(idx, item){
		alert('a');
		$(this).bind('change', function() {
			link = '<?php echo url_for('study/avaliar?study_id=s_id&criteria_id=c_id') ?>';
			$.get(link
				.replace('s_id', $(this).attr('data-estudo'))
				.replace('c_id', $(this).val())
			);
		});
	});

  $('#myModal').on('shown', function () {
  	 $('#answerForm').ajaxForm();
  });


});

$(document).ready(function () {
  $(".finaliza").click(function(e){
  	$.post("<?php echo url_for('systematic_review/finalizaTarefa')?>", { id: <?php echo $review_id?>, activity: 13 });
  });

  $('.dataExtration').click(function(e){
	  e.preventDefault();
      $.ajax({ type:'post',
        url:'<?php echo url_for('@studies_search_metadata') ?>',
        dataType:'xml',
        data:{ study_id: $(this).attr('data-study_id'),
        rsl_id:<?php echo $review_id ?> },
  	  });
  });

  $('#extration_save').click(function(e){
	e.preventDefault();
  	$('#metadataForm').ajaxSubmit();
  });

});

</script>