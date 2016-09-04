<div class="tab-pane" id="<?php echo $txtid ?>">
  <form method="post" action="<?php echo url_for('study/crawler');?>" class="form-horizontal">
    <fieldset>
      <legend><?php echo __('Busca automatizada de estudos na') ?> <?php echo $base_name ?>:</legend>
      <input type="hidden" id="txtid" name="txtid" value="<?php echo $txtid ?>" />
      <?php if (!empty($base_guidelines)) : ?>
      <div class="alert alert-block alert-info"><?php echo $base_guidelines ?></div>
      <?php endif; ?>
      <!-- <div class="control-group">
        <label class="control-label" for="string_<?php echo $txtid ?>"><?php echo __('String de busca') ?>:</label>
        <div class="controls">
          <textarea rows="6" class="input-block-level" id="string_<?php //echo $txtid ?>" name="search_string"><?php //echo htmlspecialchars($base_querystring) ?></textarea>
        </div>
      </div> -->
      <label class="" for="string_<?php echo $txtid ?>"><?php echo __('String de busca') ?>:</label>
      <textarea rows="6" class="input-block-level" id="string_<?php echo $txtid ?>" name="search_string"><?php echo htmlspecialchars($base_querystring) ?></textarea>
      <input type="hidden" name="review_id" value="<?php echo $review_id ?>"/>
      <div class="form-actions">
        <div class="btn-group">
          <a class="btn" data-context="preview" href="<?php echo $base_preview ?>" target="_blank"><i class="icon-external-link"></i> <?php echo __('Busca preliminar') ?></a>
          <button class="btn btn-success" type="submit" name="commit" data-context="crawled"><i class="icon-cogs"></i> <?php echo __('Importar') ?></button>
        </div>
      </div>
    </fieldset>
  </form>
</div>