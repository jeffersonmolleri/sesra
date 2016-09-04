<?php use_helper('Text'); ?>
<empty select="#msg" />
<?php if (!isset($save)) : ?>
<html select="#data_extation_modal_body">
<![CDATA[
<table class="table">
  <thead>
    <tr>
      <th><?php echo __('Metadado') ?></th>
      <th><?php echo __('Valor') ?></th>
    <th>
  </thead>
  <tbody>
  <?php if(empty($metadatas_info)) :?>
  <tr>
    <td colspan="2">
      <div class='alert alert-warning'>
      	<p><i class="icon-info-sign"></i> <?php echo __('Nenhum metadado encontrado') ?> </p>
      </div>
    <td>
  </tr>
  <?php else :?>
    <?php foreach($metadatas_info as $metadado) : ?>
      <tr>
        <td>
          <?php echo $metadado['name']; ?>
        </td>
        <td>
          <?php echo $metadado['input'] ? $metadado['input'] : ' - '?>
        </td>
      </tr>
    <?php endforeach;?>
  <?php endif;?>
  </tbody>
</table
]]>
</html>
<?php else : ?>
<eval>
$('#dataExtrationModal').modal('toggle');
</eval>
<empty select="#data_extation_modal_body" />
<html select="#msg"><![CDATA[
<?php if ($save) : ?>
<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><i class="icon-ok"></i> <?php echo __('Dados salvos com sucesso') ?>.</div>
<?php else : ?>
<div class="alert alert-error">
<a href="#" class="close" data-dismiss="alert">&times;</a><i class="icon-ok"></i> <?php echo __('Ocorreu um problema ao salvar os dados') ?>.
<!-- <?php echo $debug ?> -->
</div>
<?php endif; ?>
]]>
</html>
<?php endif;?>