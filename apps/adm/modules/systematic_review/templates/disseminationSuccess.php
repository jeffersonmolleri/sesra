<?php ob_start();?>
<ul class="dropdown-menu">
  <li><a href="http://www.lbd.dcc.ufmg.br/colecoes/eselaw/2008/0010.pdf" target="_blank"><i class="icon-external-link"></i> <?php echo __('Infra-estrutura Conceitual para Ambientes de <br /> Experimentação em Engenharia de Software<br>- Lopes e Travassos, 2008') ?></a></li>
  <li class="divider"></li>
  <li><a href="http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.154.1446&amp;rep=rep1&amp;type=pdf" target="_blank"><i class="icon-external-link"></i> Guidelines for performing Systematic Literature <br />Reviews in Software Engineering v.2.3<br>- Kitchenham e Charters, 2007</a></li>
  <li class="divider"></li>
  <li><a href="http://alarcos.inf-cr.uclm.es/doc/MetoTecInfInf/Articulos/es67905.pdf" target="_blank"><i class="icon-external-link"></i> Systematic Review in Software Engineering<br>- Biolchini, Mian, Natali, Travassos, 2005</a></li>
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('support' => $support, 'id' => $id));
?>
<div class="row-fluid">
  <?php if ($sf_user->hasCredential('systematic')) : ?>
  <div class="span12">
    <div class="page-header">
      <h2><?php echo __('Especificar Mecanismos de Disseminação') ?></h2>
    </div>

    <p><?php echo __('É importante comunicar os resultados de uma revisão sistemática de forma eficaz. Para tanto recomenda-se seguir as estratégias de disseminação definidas no protocolo da revisão') ?>:</p>

    <?php if (trim($protocol->getDissemination()) == "") : ?>
    <div class="alert">
      <b><?php echo __('Atenção') ?>!</b>
      <?php echo __('Nenhuma estratégia foi definida na revisão') ?>. <a href="<?php echo url_for('systematic_review/protocols?id=' . $review->getId()) ?>#processopesquisa"><?php echo __('Clique aqui') ?></a> <?php echo __('para definir') ?>.
    </div>
    <?php else : ?>
    <div class="alert alert-info">
      <h4><?php echo __('Disseminação') ?>:</h4>
      <?php echo $protocol->getDissemination() ?>
    </div>
    <?php endif; ?>

    <p><?php echo __('A publicação do relatório se dará na forma de') ?>:</p>

    <form method="post" class="element input-append" action="#">
      <label class="checkbox">
        <input type="checkbox"> <?php echo __('Artigo para periódicos e conferências (formato IEEE)') ?>
      </label>
      <label class="checkbox">
        <input type="checkbox"> <?php echo __('Relatório Técnico') ?>
      </label>
      <label class="checkbox">
        <input type="checkbox" checked="checked"> <?php echo __('Repositório de conhecimento da ferramenta ARS') ?>
      </label>
    </form>

    <div class=""> <!-- form-horizontal -->
      <div class="form-actions">
        <div class="btn-group pull-left">
          <?php echo link_to('<i class="icon-ok"></i> '.__('Salvar'), 'systematic_review/dissemination?id='.$id, array('class' => 'btn btn-success')) ?>
          <?php echo link_to('<i class="icon-check"></i> '.__('Salvar e concluir'), 'systematic_review/results?id='.$id, array('class' => 'btn finaliza')) ?>
        </div>
        <div class="btn-group-item pull-left"> <?php echo __('ou'); ?> <a href="/systematic_review" class="negate"><?php echo __('Cancelar') ?></a></div>
      </div>
    </div>
  </div>
  <?php else : ?>
  	<?php include '_restricted.php' ?>
  <?php endif; ?>
</div>

<script type="text/javascript">
$(document).ready(function (){
  $(".finaliza").click(function(e){
    $.post("<?php echo url_for('systematic_review/finalizaTarefa')?>", { id: <?php echo $id?>, activity: 16 });
  });
});
</script>