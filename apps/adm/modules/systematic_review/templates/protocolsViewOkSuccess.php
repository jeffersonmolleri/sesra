      <div class="span12">
        <div class="page-header">
          <h2><?php echo __('Validar Protocolo da Revisão') ?></h2>
        </div>

        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h4><?php echo __('Caro pesquisador(a)') ?>,</h4>
          <p><?php echo __('Obrigado por contribuir com sua avaliação.<br />
          A equipe de pesquisadores avaliará as suas considerações em breve') ?>.</p>
        </div>
          
        <p><?php echo __('Em caso de dúvidas, entre em contato com o coordenador da pesquisa') ?>:<br />
          <strong><?php echo $coordenadorNome; ?></strong><br />
          <a href="<?php echo $coordenadorEmail; ?>"><?php echo $coordenadorEmail; ?></a>
        </p>
        
        <hr />
        <a href="/index/index" class=btn><i class="icon-check"></i> <?php echo __('Concluir esta etapa') ?></a> <?php echo __('e retornar a tela inicial') ?>
      </div>

<?php 
    /*echo $id;
	echo "<br/>";
	echo $coordenador;*/
?>