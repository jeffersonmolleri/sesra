<div class="span8">
  <h2><?php echo __('Bem-vindo ') . $sf_user->getProfile()->getFirstName() ?></h2>

  <p><?php echo __('O <abbr title="Automatização de Revisões Sistemáticas">ARS</abbr> é uma abordagem automatizada de apoio ao processo de Revisão Sistemática da Literatura a pesquisadores na área de engenharia de software. A ferramenta utiliza o modelo de processo proposto por Kitchenham e Charters (2007) e permite a condução do mesmo de acordo com um modelo de negócios definido') ?>.</p>
  
  <p><?php echo __('Para iniciar sua revisão sistemática da literatura, use as opções abaixo') ?>:</p>
  <div class="btn-group">
  <?php echo link_to('<i class="icon-plus-sign"></i> '.__('criar nova'), 'systematic_review/new', 'class=btn') ?>
  <?php echo link_to('<i class="icon-tasks"></i> '.__('em andamento'), 'systematic_review/index', 'class=btn') ?>
  </div>
</div>

<div class="span4">
  <div class="well affix span4" style="padding: 8px 0;">
    <ul id="sidebar" class="nav nav-list"> 
      <li class="nav-header"><?php echo __('Material de apoio') ?></li>
      <li><?php echo link_to(__('<i class="icon-external-link"></i> Guidelines for performing Systematic Literature Reviews in Software Engineering v.2.3<br />- Kitchenham e Charters, 2007'), 'http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.154.1446&rep=rep1&type=pdf', 'class=') ?></li>
      <li class="divider"></li>
      <li><?php echo link_to(__('<i class="icon-external-link"></i> Systematic Review in Software Engineering<br />- Biolchini, Mian, Natali, Travassos, 2005'), 'http://alarcos.inf-cr.uclm.es/doc/MetoTecInfInf/Articulos/es67905.pdf', 'class=') ?></li>
    </ul>
  </div>
</div>