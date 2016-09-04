<?php use_helper('Date', 'Text', 'I18N', 'enWidgets'); ?>

<?php ob_start();?>
<ul class="dropdown-menu">
  <li class="divider"></li>
  <li><a href="http://www.york.ac.uk/inst/crd/pdf/Systematic_Reviews.pdf" target="_blank"><i class="icon-external-link"></i> CRD’s guidance for undertaking reviews in health care<br />- Khan <em>et al.</em>, 2001'</a></li>
  <li class="divider"></li>
  <li><a href="http://handbook.cochrane.org/" target="_blank"><i class="icon-external-link"></i> Cochrane Reviewers’ Handbook<br /> - Green, Higgins, 2011</a></li>
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('review_id' => $review_id));
?>

<div class="row-fluid">
  <div class="span12">
	<h2><?php echo __('Avaliação de Qualidade dos Estudos') ?></h2>
    
    <p><?php echo __('Permite a utilização de uma lista com critérios de avaliação que devem ser respondidos, preferencialmente por valores booleanos. Desta forma, o estudo que obtiver uma quantidade maior de respostas verdadeiras, é mais significante frente a questão de pesquisa') ?>:</p>
    
    <p><?php echo __('Selecione um modelo de listas de avaliação para estudos em engenharia de software abaixo, ou') . link_to(__('crie seu próprio questionário de avaliação'), "@questionnaire_new?review_id={$review_id}", array('class'=>'')) ?>:</p>

	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th><?php echo __('Nome') ?></th>
	      <th><?php echo __('Descrição') ?></th>
	      <th><?php echo __('Ações') ?></th>
        </tr>
	  </thead>
	  <tbody>
	    <?php foreach ($Questionnaires as $Questionnaire): ?>
	    <tr>
	      <td><?php echo $Questionnaire->getName() ?></td>
	      <td><?php echo $Questionnaire->getDescription() ?></td>
	      <td class="ctrls">
          <div class="btn-group">
            <?php echo link_to('<i class="icon-pencil"></i> editar', 'questionnaire/edit?id=' . $Questionnaire->getId(), array ('class' => 'btn btn-mini btn-info')) ?>
            <?php echo link_to('<i class="icon-remove-sign"></i> excluir', 'questionnaire/delete?id=' . $Questionnaire->getId(), array ('class' => 'btn btn-mini btn-danger')) ?>
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
</div>
