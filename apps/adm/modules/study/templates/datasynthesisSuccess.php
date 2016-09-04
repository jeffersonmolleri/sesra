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

<div class="rows-fuild">
  <div class="span12">
    <div class="page-header">
      <h2><?php echo __('Síntese dos Dados') ?></h2>
    </div>

    <p><?php echo __('Contempla a sumarização dos dados extraídos na etapa anterior em forma de tabelas e gráficos que possam demonstrar de forma mais natural os resultados dos estudos primários') ?>.</p>

    <div id="msg"></div>

    <?php
	  include_component('study', 'studylist', array ('review_id' => $review_id, 'studies' => $studies, 'metadata' => $metadata, 'actionName' => $sf_context->getActionName()));
	?>

    <div class=""> <!-- form-horizontal -->
      <div class="form-actions">
        <div class="btn-group pull-left">
          <?php echo link_to('<i class="icon-ok"></i> '.__('Salvar'), '@data_synthesis?id='.$review_id, array('class' => 'btn btn-success')) ?>
          <?php echo link_to('<i class="icon-check"></i> '.__('Salvar e concluir'), 'systematic_review/dissemination?id='.$review_id, array('class' => 'btn finaliza')) ?>
        </div>
        <div class="btn-group-item pull-left"> <?php echo __('ou') ?> <a href="/systematic_review" class="negate"><?php echo __('Cancelar') ?></a></div>
      </div>
    </div>
  </div>


  <!-- <div class="span3">
    <div class="well affix span3" style="padding: 8px 0;">
      <ul id="sidebar" class="nav nav-list">
        <li class="nav-header"><?php echo __('Ações') ?></li>
        <li><a href="#"><i class="icon-table"></i> <?php echo __('nova tabela') ?></a></li>
        <li><a href="#"><i class="icon-bar-chart"></i> <?php echo __('novo gráfico') ?></a></li>
      </ul>
    </div>
  </div> -->
</div>


<script type="text/javascript">

$(document).ready(function () {
	$(".finaliza").click(function(e){
		$.post("<?php echo url_for('systematic_review/finalizaTarefa')?>", { id: <?php echo $review_id?>, activity: 14 });
	});
});

</script>