<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>

<?php $culture = sfContext::getInstance()->getUser()->getCulture(); ?>
<?php $data_format = ($culture == 'en') ? 'yyyy-MM-dd' : 'dd/MM/yyyy' ; ?>

<table class="table table-striped">
  <thead>
    <tr>
      <th><?php echo __('Nome') ?></th>
      <th><?php echo __('Data') ?></th>
      <th><?php echo __('Responsável') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $root = 0; $child = 0; foreach($activities as $ac) : if ($ac->getActivityParent() == null) { $root++; $child = 0; } else { $child++; } $job = $ac->getCachedJobs(); ?>
    <?php if ($child == 0): ?>
    <tr class="info">
      <td colspan="3"><?php echo ($root + $child / 10), '. ', __($ac->getNamePt()); ?></td>
    </tr>
    <?php else : ?>
    <tr>
      <td><?php echo ($root + $child / 10), '. ', __($ac->getNamePt()); ?></td>
      <?php if(!empty($job[0]) && $job[0]->getFinishedAt()) : ?>
      <td><?php echo format_date($job[0]->getDate(), $data_format) ?></td>
      <td><?php echo __($job[0]->getUserIdProfile()->getName()); ?></td>
      <?php else : ?>
      <td>
        <div class="date_framework input-append date">
          <input data-format="dd/MM/yyyy" type="text" id="" name="activity_date[<?php echo $ac->getId()?>]" <?php echo !empty($job[0]) ? ('value="' . format_date($job[0]->getDate(), $data_format) . '"') : '' ; ?> />
          <span class="add-on">
            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
          </span>
        </div>
      </td>
      <td>
        <select name="framework_users[<?php echo $ac->getId()?>]"> <!-- multiple="multiple" -->
          <option value="">- <?php echo __('selecionar') ?> -</option>
          <?php foreach($systematic_users as $user) : ?>
          <option value="<?php echo $user->getUserId();?>" <?php echo !empty($job[0]) ? ($job[0]->getUserId() == $user->getUserId() ? 'selected="selected"' : '' ) : ''?>><?php echo __($user->getsfGuardUser()->getProfile()->getName()) ?> </option>
          <?php endforeach;?>
        </select>
      </td>
      <?php endif; ?>
    </tr>
    <?php endif; endforeach; ?>
  </tbody>
</table>
<script type="text/javascript">
  addDatePicker();
</script>