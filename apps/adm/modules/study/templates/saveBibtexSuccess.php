<?php if (!empty($error)) : ?>
<html select="#waitingModal .modal-body"><![CDATA[
<div class="row">
  <div class="span1 offset1"><i class="icon-warning-sign icon-3x"></i></div>
  <div class="span10"><?php echo __('Ocorreu um problema ao importar o conteúdo do BibTex fornecido') ?>.</div>
</div>
]]>
</html>
<html select="#waitingModal .modal-footer"><![CDATA[
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><?php echo __('Fechar') ?></button>
]]></html>
<?php else : ?>
<html select="#waitingModalLabel"><?php echo __('Busca concluída') ?></html>
<html select="#waitingModal .modal-body"><![CDATA[
<div class="row">
  <div class="span1 offset1"><i class="icon-thumbs-up icon-3x"></i></div>
  <div class="span10">Foram importados <?php echo count($success) ?> <?php echo __('estudos com sucesso') ?>.</div>
</div>
]]>
</html>
<html select="#waitingModal .modal-footer"><![CDATA[
<a class="btn btn-primary" href="<?php echo url_for("@studies_identification?id=" . $review_id) ?>"><?php echo __('Ver resultados') ?></a>
<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __('Fechar') ?></button>
]]></html>
<?php endif; ?>
