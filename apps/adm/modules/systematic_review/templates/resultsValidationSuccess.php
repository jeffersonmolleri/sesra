<?php include_component('systematic_review', 'submenu', array ('id' => $id)); ?>
<?php if ($sf_user->hasCredential('systematic')) : ?>
  <div class="row-fluid">
    <div class="span9">
      <div class="page-header">
        <h2><?php echo __('Validar o Relatório da Revisão') ?></h2>
        <?php //echo $sf_request->getParameter('message') ?>
      </div>

      <?php if (empty($users)) : ?>
      <div class="alert alert-block"><h4><?php echo __('Atenção') ?>!</h4>
        <?php echo __('Para validar o relatório da pesquisa é necessário possuir mediadores/revisores vinculados à revisão') ?>.<br />
        <a href="<?php echo url_for('systematic_review/team?id='.$id); ?>"><?php echo __('Clique aqui') ?></a> <?php echo __('para gerenciar os integrantes da equipe de pesquisa') ?>.
      </div>
      <?php else: ?>
      <div class="alert alert-block alert-info">
      	<p><?php echo __('O <strong>relatório da revisão</strong> deve ser enviado aos mediadores/revisores para que façam suas avaliações:') ?></p><br />
      	<div id="teamList"><?php include "_list_team_revision.php";?></div>
      	<a class="btn btn-info" id="validationInvite" <?php echo (!$invitationButton)?'disabled':''; ?> href="<?php echo url_for('@results_validation_invite?id='.$id)?>"><i class="icon-envelope"></i> <?php echo __('solicitar validação') ?></a>
      </div>

      <?php include "_list_observacoes.php"; ?>
      
      <?php endif; ?>

    </div>
    <div class="span3">
      <div class="well affix span3" style="padding: 8px 0;">
        <ul id="sidebar" class="nav nav-list">
          <li class="nav-header"><?php echo __('Relatório da Pesquisa') ?></li>
          <li><a href="<?php echo url_for('systematic_review/resultsView?id=' . $id)?>" target="_blank"><i class="icon-eye-open"></i> <?php echo __('Visualizar') ?></a></li>
          <li><a href="<?php echo url_for('systematic_review/resultsDownload?id=' . $id)?>"><i class="icon-download"></i> <?php echo __('Download (.docx)') ?></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class=""> <!-- form-horizontal -->
    <div class="form-actions">
      <div class="btn-group pull-left">
        <?php //echo link_to('<i class="icon-ok"></i> '.__('Salvar'), 'systematic_review/question?id='.$id, array('class' => 'btn btn-success')) ?>
        <?php echo link_to('<i class="icon-check"></i> '.__('Concluir a Revisão Sistemática'), 'systematic_review/index?filter=concluded', array('class' => 'btn finaliza')) ?>
      </div>
      <div class="btn-group-item pull-left"> <?php echo __('ou') ?> <a href="/systematic_review" class="negate"><?php echo __('Cancelar') ?></a></div>
    </div>
  </div>

<?php else : ?>
  <?php include '_restricted.php' ?>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function (){
  $(".finaliza").click(function(e){
    //e.preventDefault();
    $.post("<?php echo url_for('systematic_review/finalizaTarefa')?>", { id: <?php echo $id?>, activity: 18 }).done(function(data){ });
  });

  $("#validationInvite").click(function(e){
	  e.preventDefault();
	  $.get($(this).attr('href'));
  });

  $('#observations a[data-context="finish"]').on('click', function (e) {
    e.preventDefault();
    $('#fin-error').remove();
    var that = $(this);
    $.get("<?php echo url_for('systematic_review/finalizeObservation') ?>", { id: $(this).attr('data-target') }, function (data, status, jqxhr) {
      var rs = jqxhr.getResponseHeader('Success');
      if (rs != null) {
        $('#observations a[data-target="' + rs + '"]').parents('tr').addClass('muted finished');
        that.remove();
      }
      else {
        $('#observations').before('<div id="fin-error" class="alert alert-error"><a href="#" class="close" data-dismiss="alert">&times;</a><strong><?php echo __('Erro') ?>!</strong> <?php echo __('Ocorreu um problema ao finalizar esta observação. Aguarde um momento e tente novamente. Se o problema persistir, contate o suporte.') ?></div>');
      }
    });
  });

});
</script>