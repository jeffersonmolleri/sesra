<?php use_helper('Date', 'Text', 'I18N', 'enWidgets'); ?>

<?php ob_start();?>
<ul class="dropdown-menu">
  <li><a href="http://www.york.ac.uk/inst/crd/pdf/Systematic_Reviews.pdf" target="_blank"><i class="icon-external-link"></i> CRD’s guidance for undertaking reviews in health care<br />- Khan <em>et al.</em>, 2001'</a></li>
  <li class="divider"></li>
  <li><a href="http://handbook.cochrane.org/" target="_blank"><i class="icon-external-link"></i> Cochrane Reviewers’ Handbook<br /> - Green, Higgins, 2011</a></li>
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('support' => $support, 'review_id' => $review_id));
?>

<div id="myModal" class="modal hid fade">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3><?php echo __('Avaliação de Qualidade dos Estudos') ?></h3>
    </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button id="questionnaireSubmit" class="btn btn-success"><i class="icon-ok"></i> <?php echo __('Salvar') ?></button>
        <?php echo __('ou') ?> <a href="#" aria-hidden="true" data-dismiss="modal"><?php echo __('Cancelar') ?></a>
      </div>
</div>

<div class="rows-fuild">
  <div class="span9">
    <div class="page-header">
      <h2><?php echo __('Avaliação de Qualidade dos Estudos') ?></h2>
    </div>
    
    <div id="msg"></div>

    <p><?php echo __('Permite a utilização de uma lista com critérios de avaliação que devem ser respondidos, preferencialmente por valores booleanos. Desta forma, o estudo que obtiver uma quantidade maior de respostas verdadeiras, é mais significante frente a questão de pesquisa') ?>.</p>
    <?php if($review->getQuestionnaire() == null):?>
    <div id="questionnaires">
      <hr />
      <p><?php echo __('Selecione um modelo de listas de avaliação para estudos em engenharia de software abaixo, ou') ?> <?php echo link_to(__('crie seu próprio questionário de avaliação'), "@questionnaire_new?review_id={$review_id}", array('class'=>'')) ?>:</p>
  
  	<table class="table table-striped">
  	  <thead>
  	    <tr>
  	      <th><?php echo __('Lista de Avaliação') ?></th>
          <th><?php echo __('Ações') ?></th>
        </tr>
  	  </thead>
  	  <tbody>
  	    <?php foreach ($Questionnaires as $Questionnaire): ?>
  	    <tr>
  	      <td><strong><?php echo $Questionnaire->getName() ?></strong><br />
  	      <small><?php echo $Questionnaire->getDescription() ?></small></td>
  	      <td class="ctrls">
            <div class="btn-group">
              <?php echo link_to('<i class="icon-eye-open"></i> '.__('visualizar'), "questionnaire/edit?review_id={$review_id}&id={$Questionnaire->getId()}", array ('class' => 'btn btn-mini btn-info')) ?>
              <?php echo link_to('<i class="icon-ok"></i> '.__('selecionar'), "study/selectQuestionary?review_id={$review_id}&questionnaire_id={$Questionnaire->getId()}&page={$studies->getPage()}", array ('class' => 'btn btn-mini btn-success')) ?>
            </div>
  	      </td>
  	    </tr>
  	    <?php endforeach; ?>
  	  </tbody>
      <tfoot>
        <tr>
          <th colspan="4"></th>
        </tr>
      </tfoot>
  	</table>
    </div>
    <?php else: ?>
      <p><?php echo __('Classifique os estudos abaixo a partir da lista de avaliação selecionada') ?>:</p>
      <div class="alert alert-block alert-info">
    	<h4><?php echo $review->getQuestionnaire()->getName(); ?></h4>
    	<p><?php echo $review->getQuestionnaire()->getDescription(); ?></p>
    	<div class="btn-group">
        	<?php echo link_to('<i class="icon-eye-open"></i> '.__('visualizar'), "questionnaire/edit?review_id={$review_id}&id={$review->getQuestionnaire()->getId()}", array ('class' => 'btn btn-info')) ?>
        	<?php echo link_to('<i class="icon-list-alt"></i> '.__('selecionar outra'), "study/selectQuestionary?review_id={$review_id}&page={$studies->getPage()}&questionnaire_id=", array ('class' => 'btn btn-warning')) ?>
    	</div>
      </div>
    <?php endif; ?>
    <div id="studies">
      <?php if($review->getQuestionnaire() == null):?>
      	<div class="alert alert-block alert-info">
			<i class="icon-info"></i>
      		<?php echo __('Você precisa selecionar um questionário para avaliar os estudos') ?>.
      	</div>
      <?php else:?>
        <div id="msg"></div>
        <?php
          include_component('study', 'studylist', array ('filter' => $filter, 'title' => $title, 'review_id' => $review_id, 'studies' => $studies, 'showActions' => $review->getQuestionnaire() !=null, 'actionName' => $sf_context->getActionName()));
        ?>
      <?php endif;?>
      
      <div class=""> <!-- form-horizontal -->
        <div class="form-actions">
          <div class="btn-group pull-left">
            <?php echo link_to('<i class="icon-ok"></i> '.__('Salvar'), '@studies_assessment?id='.$review_id, array('class' => 'btn btn-success')) ?>
            <?php echo link_to('<i class="icon-check"></i> '.__('Salvar e concluir'), '@data_extraction?id='.$review_id, array('class' => 'btn finaliza')) ?>
          </div>
          <div class="btn-group-item pull-left"> <?php echo __('ou'); ?> <a href="/systematic_review" class="negate"><?php echo __('Cancelar') ?></a></div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="span3">
    <div class="well affix span3" style="padding: 8px 0;">
      <ul id="sidebar" class="nav nav-list">
        <?php if($review->getQuestionnaire() != null):?>
        <li class="nav-header"><?php echo __('Ações') ?></li>
        <li><?php echo link_to('<i class="icon-list-alt"></i> '.__('selecionar outra lista de avaliação'), "study/selectQuestionary?review_id={$review_id}&page={$studies->getPage()}&questionnaire_id=") ?></li>
        <?php endif; ?>      
        <li class="nav-header"><?php echo __('Filtrar') ?></li>
        <li><?php echo link_to('<i class="icon-circle-blank"></i> '.__('estudos não avaliados'), '@studies_assessment?filter=unassessed&id='.$review_id, array('class'=> 'text-success')) ?></li>
        <li><?php echo link_to('<i class="icon-ok-sign"></i> '.__('estudos já avaliados'), '@studies_assessment?filter=assessed&id='.$review_id, array('class'=> 'text-error')) ?></li>
        <li><?php echo link_to('<i class="icon-circle"></i> '.__('todos os estudos'), '@studies_assessment?id='.$review_id) ?></li>
        <li class="divider"></li>
        <li>
        <form action="<?php echo url_for( '@studies_assessment?id='. $review_id) ?>" class="element input-append" method="get">
          <input type="text" name="title" id="search" placeholder="<?php echo __('Pesquisar') ?>" class="span8" value="<?php echo $title ?>" />
          <?php echo button_tag('<i class="icon-search"></i>', 'class=btn') ?>
        </form>
        </li>
      </ul>
    </div>
  </div>
</div>

<script type="text/javascript">
$(window).load(function () {
  $('.activateModal').on('click', function () {
	$.ajax({ 
		type:'post', 
		dataType:'xml', 
		data:{ 
			study_id: $(this).attr('data-study'), 
			review_id: $(this).attr('data-review'), 
		}, 
		url:'<?php echo url_for('answer/form') ?>' 
	});			
  });
  $('#questionnaireSubmit').on('click', function() {
	  $('#answerForm').submit();
  });
});

$(document).ready(function () {
	$(".finaliza").click(function(e){
		$.post("<?php echo url_for('systematic_review/finalizaTarefa')?>", { id: <?php echo $review_id?>, activity: 12 });
	});
});
</script>