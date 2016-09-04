<?php ob_start();?>
<ul class="dropdown-menu">
  <li><a href="http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.154.1446&amp;rep=rep1&amp;type=pdf" target="_blank"><i class="icon-external-link"></i> Guidelines for performing Systematic Literature <br/>Reviews in Software Engineering v.2.3<br>- Kitchenham e Charters, 2007</a></li>
  <li class="divider"></li>
  <li><a href="http://alarcos.inf-cr.uclm.es/doc/MetoTecInfInf/Articulos/es67905.pdf" target="_blank"><i class="icon-external-link"></i> Systematic Review in Software Engineering<br/>- Biolchini, Mian, Natali, Travassos, 2005</a></li>
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('support' => $support, 'id' => $id));
?>
<?php if ($sf_user->hasCredential('systematic')) : ?>
  <div class="rows-fluid">

    <div class="span3 bs-docs-sidebar">
      <ul id="submenu" class="nav nav-list bs-docs-sidenav affix span3">
        <li><a href="#arevisao"><i class="icon-chevron-right"></i> <?php echo __('Sobre a Revisão') ?></a></li>
        <li><a href="#questaopesquisa"><i class="icon-chevron-right"></i> <?php echo __('Questão de Pesquisa') ?></a></li>
        <li><a href="#criteriosselecao"><i class="icon-chevron-right"></i> <?php echo __('Critérios de Seleção') ?></a></li>
        <li><a href="#estrategiaselecao"><i class="icon-chevron-right"></i> <?php echo __('Estratégia de Seleção') ?></a></li>
        <li><a href="#processopesquisa"><i class="icon-chevron-right"></i> <?php echo __('Processo de Pesquisa') ?></a></li>
        <li><a href="#sintesedados"><i class="icon-chevron-right"></i> <?php echo __('Síntese dos Dados') ?></a></li>
        <li><a href="#fontespesquisa"><i class="icon-chevron-right"></i> <?php echo __('Fontes de Pesquisa') ?></a></li>
        <li><a href="#cronogramapesquisa"><i class="icon-chevron-right"></i> <?php echo __('Cronograma de Pesquisa') ?></a></li>
        <li class="active"><a data-affix="no_affix" href="<?php echo url_for('systematic_review/protocolDownload?id=' . $id)?>"><i class="icon-download"></i> <?php echo __('Download do Protocolo (.docx)') ?></a></li>
      </ul>
    </div>

    <div class="span9">
      <div class="page-header">
        <h2><?php echo __('Protocolo da Revisão') ?></h2>
      </div>

      <p><?php echo __('O desenvolvimento do protocolo de revisão envolve a documentação dos elementos da <abbr title="Revisão Sistemática da Literatura">RSL</abbr> e algumas informações de planejamento adicionais') ?>:</p>

      <?php include '_form_protocols.php' ?>
    </div>
  </div>
<?php else : ?>
  <?php include '_restricted.php' ?>
<?php endif; ?>
