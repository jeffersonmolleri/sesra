<?php use_helper('Date', 'Text', 'I18N', 'enWidgets'); ?>

<h1><?php echo __('Metadados') ?></h1>

<br />
<?php if ($sf_request->hasParameter('name')) : ?>
  <div class="msg alert"><?php echo __('Procurando pelo termo') ?> <strong>"<?php echo $sf_request->getParameter('name')?>"</strong></div>
<?php endif ?>

<table>
  <thead>
  <tr>
    <?php $dir = ($dir == 'asc')?'desc':'asc'; ?>
    <th><?php echo link_to('Nome', 'metadata/index?order='.MetadataPeer::NAME.'&dir='.$dir, array ('class' => ($order == MetadataPeer::NAME ? $dir : ''))) ?></th>
    <th><?php echo __('Ações') ?></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($metadata->getResults() as $metadata) : ?>
    <tr>
      <td><?php echo $metadata[1]; ?></td>
      <td class="ctrls"><?php echo link_to(image_tag('ico16/edit') . 'editar', 'metadata/edit?id=' . $metadata[0]) ?>
      <?php echo link_to(image_tag('ico16/remove') . 'remover', 'metadata/delete?id=' . $metadata[0], array ('class' => '')) ?></td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$metadata->getNbResults()) : ?>
    <tr>
      <td colspan="6" class="emptyCell"><?php echo __('Nenhum metadado cadastrado') ?>.</td>
    </tr>
  <?php endif; ?>
  </tbody>
  <!-- <tfoot>
    <tr>
      <th colspan="6"><?php echo format_number_choice('[0]nenhum resultado|[1]um resultado|(1,Inf]%1% resultados', array ('%1%' => $metadata->getNbResults()), $metadata->getNbResults()) ?></th>
    </tr>
  </tfoot>-->
</table>

<?php echo form_pager_display($metadata, "metadata/index?page="); ?>