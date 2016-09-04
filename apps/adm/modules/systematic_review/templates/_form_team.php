<form action="<?php echo url_for('@update_team?id='.$id) ?>" method="post">
  <fieldset>

    <p><?php echo __('Caso a revisão sistemática seja conduzida por um grupo, gerencie os integrantes abaixo, atribuindo a cada qual o papel adequado na condução do processo') ?>:</p>
    
    <!-- <div class="alert alert-block alert-info">
      <i class="icon-info-sign"></i> <?php //echo __('<strong>Sugestão:</strong> durante a avaliação da ferramenta, adicione <strong>jefferson.molleri@univali.br</strong> como <strong>mediador') ?></strong>.
    </div> -->

    <div id="table_list">
      <?php include '_list_team.php' ?>
    </div>
  </fieldset>
</form>