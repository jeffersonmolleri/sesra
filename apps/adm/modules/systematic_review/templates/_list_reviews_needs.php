<?php use_helper('Date', 'Text', 'I18N', 'enWidgets'); ?>

<section>

  <h3><?php echo __('Resultado da busca no repositório público da ferramenta ARS') ?>:</h3>

  <table class="table table-striped">
    <thead>
      <tr>
        <th><?php echo __('ID') ?></th>
        <th><?php echo __('Título') ?></th>
        <th><?php echo __('Criado em') ?>:</th>
      </tr>
    </thead>
    <tbody>

    <?php if (!$reviews->getNbResults()) : ?>
      <tr>
        <td colspan="2" class="emptyCell"><?php echo __('Nenhuma revisão encontrada') ?></td>
      </tr>
    <?php else : foreach ($reviews->getResults() as $review) : ?>
      <tr>
      	<td><strong><?php echo 'RSL'.$review[0] ?></strong></td>
        <td><strong><?php echo link_to($review[1], 'systematic_review/resultsView?id=' . $review[0], array ('target' => '_blank')) ?></strong>
        	<?php echo '<br /><small>'.$review[2].'</small>' ?>
        </td>
        <td><small><?php echo date('d/m/y',strtotime($review[4])); ?> <?php echo __('por') ?> <?php echo $review[6]; ?></small></td>
      </tr>
    <?php endforeach; endif; ?>
    </tbody>
  </table>

  <?php echo form_pager_display($reviews, "systematic_review/index?page="); ?>
 </section>