<?php //$linked = $folder->getNoveltyGallerysJoinNovelty(); if (!empty($linked)) : ?>
<?php $linked = false; if (!empty($linked)) : ?>
<div class="msg info">
  <?php if (sizeof($linked) > 1) : ?>
  Esta pasta está relacionada com as seguintes novidades: 
  <ul>
    <?php foreach ($linked as $rel) : ?>
    <li><?php echo link_to($rel->getNovelty()->getTitle(), 'novelties/edit?id=' . $rel->getNoveltyId()) ?></li>
    <?php endforeach; ?>
  </ul>
  <?php else : ?>
    Esta pasta está relacionada com a seguinte novidade: <?php echo link_to($linked[0]->getNovelty()->getTitle(), 'novelties/edit?id=' . $linked[0]->getNoveltyId()) ?>
  <?php endif; ?>
</div>
<?php endif; ?>