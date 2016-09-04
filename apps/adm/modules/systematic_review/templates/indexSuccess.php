<?php if ($sf_user->hasCredential('systematic')) : ?>
  
  <div class="span9">
    <?php include '_list.php'; ?>
  </div>
  
  <div class="span3">
    <div class="well affix span3" style="padding: 8px 0; margin-top: 80px;">
      <ul id="sidebar" class="nav nav-list">
        <li class="nav-header"><?php echo __('Ações') ?></li>
        <li><?php echo link_to('<i class="icon-file"></i> '.__('nova revisão sistemática'), 'systematic_review/new', 'class=') ?></li>
       
        <li class="nav-header"><?php echo __('Filtros') ?></li>
        <li><?php echo link_to('<i class="icon-circle-blank"></i> '.__('em andamento'), 'systematic_review/index?filter=waiting') ?></li>
        <li><?php echo link_to('<i class="icon-circle"></i> '.__('concluídas'), 'systematic_review/index?filter=concluded') ?></li>
        
        <li class="divider"></li>
        <li>
          <form action="<?php echo url_for('systematic_review/index') ?>" class="element input-append" method="post">
            <input type="text" name="name" id="name" placeholder="<?php echo __('Pesquisar') ?>" class="span8" />
            <?php echo button_tag('<i class="icon-search"></i>', 'class=btn') ?>
          </form>
        </li>
      </ul>
    </div>
  </div>
<?php else : ?>
  <?php include '_restricted.php' ?>
<?php endif; ?>
<script type="text/javascript">
	$(".rowElem").jqTransform();

	var availableTags = [
    <?php foreach ($revisoes as $x => $revisao) : ?>
      <?php if ($x+1 == $count_reviews) : ?>
        <?php echo "'{$revisao}'"; ?>
      <?php else : ?>
        <?php echo "'{$revisao}',"; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  ];

  $( "#name" ).autocomplete({
    source: availableTags
  });
</script>