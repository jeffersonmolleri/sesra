<?php use_helper('I18N') ?>
<?php $column = '' ?>
<?php $userArray = array(); ?>

<h3><?php echo __('Observações') ?>:</h3>

<table id="observations" class="table table-striped">
  <thead>
    <tr>
      <th><span class="pull-right"><?php echo __('Revisor') ?></span></th>
      <th><?php echo __('Observação') ?></th>
      <th><?php echo __('Finalizada em') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $oid = 0; while ($obs = $observations->fetch(PDO::FETCH_OBJ)): ++$oid; ?>
    <?php if($obs->owner_column != $column): ?>
    <?php $column = $obs->owner_column; ?>
    <tr class="info">
      <td>&nbsp;</td>
      <td colspan="2"><strong><?php echo __($obs->owner_column); ?></strong></td>
    </tr>
    <?php endif; ?>
    <?php if(!in_array($obs->creator, $userArray)) { array_push($userArray, $obs->creator); $keyArray = array_keys($userArray); } ?>
    <tr id="observation-<?php echo $oid; $obs->situacao == Observacao::STATUS_FINISHED and print '" class="muted' ?>">
      <td><span class="label label-color-<?php echo array_search($obs->creator, $userArray) ?> pull-right"><?php echo $obs->creator; ?></span></td>
      <td><?php echo $obs->observacao; ?></td>
      <?php if ($obs->situacao == Observacao::STATUS_FINISHED) : ?>
      <td><?php echo format_date($obs->updated_at), ' por ', $obs->updater ?></td>
      <?php else : ?>
      <td class="ctrls"><div class="btn-group"><a class="btn btn-mini" href="#" data-context="finish" data-target="<?php echo $obs->id; ?>"><i class="icon-check"></i> <?php echo __('finalizar') ?></a></div></td>
      <?php endif; ?>
    </tr>
    <?php //var_dump($obs); ?>
    <?php endwhile; ?>
    <?php if($oid == 0): ?>
    <tr class="warning">
      <td colspan="3"><?php echo __('Nenhuma observação cadastrada até o momento') ?>.</td>
    </tr>
    <?php endif; ?>
  </tbody>
</table>