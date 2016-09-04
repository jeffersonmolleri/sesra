<div class="subnav">
  <div class="subnav-inner">
    <div class="row-fluid">
      <div class="span12">
      <?php if (!empty($support)) : ?>
        <ul class="pull-right" id="helper"> <!-- nav pull-right -->
          <li><button data-toggle="dropdown" class="btn btn-large btn-info dropdown-toggle"><i class="icon-book icon-white"></i><br /><?php echo __('Material de Apoio') ?> <span class="caret"></span></button>
            <?php echo $support ?>
          </li>
        </ul>
      <?php endif; ?>


      <?php if(isset($review)): ?>
        <?php $review_id = $review->getId(); ?>
        <h1 title="<?php echo __('#'). $review->getId().'. '.$review->getTitle() ?>"><?php echo '#'. $review->getId().'. '.$review->getTitle() ?></h1>
      <?php else: ?>
        <h1><?php echo __('Título da Revisão') ?></h1>
      <?php endif; ?>
        <ul class="nav nav-pills pull-left">
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo __('Planejamento da Revisão') ?> <b class="caret"></b></a>
            <div class="progress" style="height:4px; margin: 0 0 4px 0; border-radius: 0;"><div class="bar" style="width: <?php echo count(array_intersect($jobs, array(2,3,5,6,7)))*20 ?>%;"></div></div>
            <ul class="dropdown-menu">
              <li><?php echo link_to((in_array(2, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Identificação da Necessidade da Revisão'), $urls[2] . $review_id) ?></li>
              <li><?php echo link_to((in_array(3, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Comissionamento da Revisão'), $urls[3] . $review_id) ?></li>
              <li><?php echo link_to((in_array(5, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Especificar Questões de Pesquisa'), $urls[5] . $review_id) ?></li>
              <li><?php echo link_to((in_array(6, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Desenvolver Protocolo da Revisão'), $urls[6] . $review_id) ?></li>
              <li><?php echo link_to((in_array(7, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Validar Protocolo da Revisão'), $urls[7] . $review_id) ?></li>
            </ul>
          </li>
          <?php //if($sf_context->getConfiguration()->getEnvironment() == 'dev'): ?>
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo __('Execução da Revisão') ?> <b class="caret"></b></a>
            <div class="progress" style="height:4px; margin: 0 0 4px 0; border-radius: 0;"><div class="bar" style="width: <?php echo count(array_intersect($jobs, array(10,11,12,13,14)))*20 ?>%;"></div></div>
            <ul class="dropdown-menu">
              <li><?php echo link_to((in_array(10, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Identificação da Pesquisa'), $urls[10] . $review_id) ?></li>
              <li><?php echo link_to((in_array(11, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Seleção dos Estudos Primários'), $urls[11] . $review_id) ?></li>
              <li><?php echo link_to((in_array(12, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Avaliação da Qualidade dos Estudos'), $urls[12] . $review_id) ?></li>
              <li><?php echo link_to((in_array(13, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Extração e Monitoramento dos Dados'), $urls[13] . $review_id) ?></li>
              <li><?php echo link_to((in_array(14, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Síntese dos Dados'), $urls[14] . $review_id) ?></li>
            </ul>
          </li>
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo __('Análise dos Resultados') ?> <b class="caret"></b></a>
            <div class="progress" style="height:4px; margin: 0 0 4px 0; border-radius: 0;"><div class="bar" style="width: <?php echo count(array_intersect($jobs, array(16,17,18)))*33.3 ?>%;"></div></div>
            <ul class="dropdown-menu">
              <li><?php echo link_to((in_array(16, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Especificar Mecanismos de Disseminação'), $urls[16] . $review_id) ?></li>
              <li><?php echo link_to((in_array(17, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Formatar o Relatório Principal'), $urls[17] . $review_id) ?></li>
              <li><?php echo link_to((in_array(18, $jobs)?'<i class="icon-check"></i>':'<i class="icon-check-empty"></i> ').__('Validar o Relatório'), $urls[18] . $review_id) ?></li>
            </ul>
          </li>
          <?php //endif; ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="subnav-push"></div>

<!--
1;"Planning the Review"
2;"Identification of the need for a review"
3;"Commissioning a review"
5;"Specifying the research question(s)"
6;"Developing a review protocol"
7;"Evaluating the review protocol"

8;"Conducting the Review"
10;"Identification of research"
11;"Selection of primary studies"
12;"Study quality assessment"
13;"Data extraction and monitoring"
14;"Data synthesis"

15;"Reporting the Review"
16;"Specifying dissemination mechanisms"
17;"Formatting the main report"
18;"Evaluating the report"
-->