<?php use_helper('Text'); ?>

<html select="#msgSave">
<![CDATA[
  <?php if(empty($criteria)) :?>
  <div class='alert alert-warning'>
  	<p><i class="icon-info-sign"></i> <?php echo __('Você removeu sua avaliação perante o estudo') ?>.</p>
  </div>
  <?php else :?>
  <div class='alert alert-success'>
  	<p><i class="icon-ok-sign"></i> <?php echo __('Você avaliou o estudo com o critério') ?> "<strong><?php echo $criteria->getName() ?></strong>".</p>
  </div>
  <?php endif;?>
]]>
</html>