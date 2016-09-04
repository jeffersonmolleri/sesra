<?php use_helper('Date', 'Text', 'I18N', 'enWidgets'); ?>

<section>
  <div class="page-header">
    <h1><?php echo __('Revisões Sistemáticas') ?> 
    <?php switch ($filter) {
      case 'waiting': echo __('em Andamento'); break;
      case 'concluded': echo __('Concluídas'); break;
      default: echo '';
    }?></h1>
  </div>

  <?php if ($sf_request->hasParameter('name')) : ?>
    <div class="msg alert"><?php echo __('Procurando pelo termo') ?> <strong>"<?php echo $sf_request->getParameter('name')?>"</strong></div>
  <?php else: ?>
    <div class="alert alert-info"><?php echo __('Selecione a revisão sistemática para visualizar seu andamento') ?>:</div>
  <?php endif ?>

  <table class="table table-striped">
    <thead>
      <tr>
        <?php $dir = ($dir == 'asc')?'desc':'asc'; ?>
        <th></th>
        <th><?php echo link_to(__('ID'), 'systematic_review/index?order='.SystematicReviewPeer::ID.'&dir='.$dir, array ('class' => ($order == SystematicReviewPeer::ID ? $dir : ''))) ?></th>
        <th><?php echo link_to(__('Título'), 'systematic_review/index?order='.SystematicReviewPeer::TITLE.'&dir='.$dir, array ('class' => ($order == SystematicReviewPeer::TITLE ? $dir : ''))) ?></th>
        <th><?php echo link_to(__('Papel'), 'systematic_review/index?order='.SystematicReviewUserPeer::LEVEL.'&dir='.$dir, array ('class' => ($order == SystematicReviewUserPeer::LEVEL ? $dir : ''))) ?></th>
        <th><?php echo link_to(__('Criado em'), 'systematic_review/index?order='.SystematicReviewPeer::CREATED_AT.'&dir='.$dir, array ('class' => ($order == SystematicReviewPeer::CREATED_AT ? $dir : ''))) ?></th>
        <th><?php echo __('Ações') ?></th>
      </tr>
    </thead>
    <tbody>

    <?php foreach ($reviews->getResults() as $review) : ?>
      <tr>
      	<th><i class="<?php echo $review[8] ? 'icon-circle' : 'icon-circle-blank' ?>"></i></th>
        <td>
          <small><strong><?php echo link_to('RSL'.$review[0], 'systematic_review/edit?id=' . $review[0]) ?></strong></small><br />
          <div class="progress" style="height:4px; margin: 0 0 4px 0; border-radius: 0;">
          	<div class="bar" style="width: <?php echo 100/13*$review[9] ?>%;"></div>
          </div>
        </td>
        <td><small><strong><?php echo link_to($review[1], 'systematic_review/edit?id=' . $review[0]) ?></strong></small>
        </td>
        <td><small><?php echo $levels[$review[7]]; ?></small></td>
        <td><small><?php echo date('d/m/y',strtotime($review[4])); ?> <?php echo __('por') ?> <?php echo $review[6]; ?></small></td>
        <td class="ctrls">
          <div class="btn-group">
            <?php echo link_to('<i class="icon-pencil"></i> '.__('editar'), 'systematic_review/edit?id=' . $review[0], array ('class' => 'btn btn-mini btn-info')) ?>
            <!-- echo ($user[1] == 'admin') ? '' : -->
            <?php echo link_to('<i class="icon-remove-sign"></i> '.__('excluir'), 'systematic_review/delete?id=' . $review[0], array ('class' => 'btn btn-mini btn-danger')) ?>
          </div>
        </td>
      </tr>
        <?php //echo count(array_intersect($jobs, array(2,3,5,6,7)))*20 ?>
    <?php endforeach; ?>
    <?php if (!$reviews->getNbResults()) : ?>
      <tr>
        <td colspan="6" class="emptyCell"><?php echo __('Nenhuma revisão cadastrada') ?>.</td>
      </tr>
    <?php endif; ?>
    </tbody>
    <tfoot>
      <tr> <!-- TODO: -->
        <th colspan="6"><?php echo format_number_choice('[0]nenhum resultado|[1]um resultado|(1,Inf]%1% resultados', array ('%1%' => $reviews->getNbResults()), $reviews->getNbResults()) ?></th>
      </tr>
    </tfoot>
  </table>

  <?php echo form_pager_display($reviews, "systematic_review/index?page="); ?>
 </section>