<?php if (empty($data)) : ?>
<attr select="<?php echo $target ?>" name="disabled" value="disabled" />
<html select="<?php echo $target ?>">
  <option value=""><?php echo $noresult ?></option>
</html>
<?php else : ?>
<?php use_helper('Object') ?>
<attr select="<?php echo $target ?>" name="disabled" value="" />
<html select="<?php echo $target ?>">
<?php if ($selected == null) : ?>
  <?php echo objects_for_select($data, 'getId', 'getName', null, array ('include_blank' => true)) ?>
<?php else : ?>
  <?php echo objects_for_select($data, 'getId', 'getName', $selected, array ('include_blank' => true)) ?>
<?php endif; ?>
</html>
<?php endif; ?>