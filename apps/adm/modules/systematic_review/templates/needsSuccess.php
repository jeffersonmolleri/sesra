<?php ob_start();?>
<ul class="dropdown-menu">
  <li><a href="http://www.lbd.dcc.ufmg.br/colecoes/eselaw/2008/0010.pdf" target="_blank"><i class="icon-external-link"></i> <?php echo __('Infra-estrutura Conceitual para Ambientes de <br />Experimentação em Engenharia de Software<br />- Lopes e Travassos, 2008') ?></a></li>
  <li class="divider"></li>
  <li><a href="http://www.crd.york.ac.uk/CRDWeb/AboutDare.asp" target="_blank"><i class="icon-external-link"></i> Database of Abstracts of Reviews of Effects (DARE)</a></li>
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('support' => $support, 'id' => $id));
?>
<?php if ($sf_user->hasCredential('systematic')) : ?>
  <div class="row-fluid">
    <div class="span12">
        <div class="page-header">
          <h2><?php echo __('Identificação da Necessidade da Revisão') ?></h2>
        </div>

        <p class="alert alert-info alert-block"><?php echo __('Antes de empreender uma revisão sistemática, faz-se necessária a consulta a um repositório de conhecimento para 
          garantir a individualidade do estudo proposto') ?>.
        <p>
        
				<!--
        <p><?php //echo __('Utilize o campo abaixo para realizar a busca no repositório público da ferramenta ARS e outros estudos publicados') ?>:
        </p>
				-->

        <!-- <form class="form-horizontal" action="<?php echo url_for('systematic_review/searchNeeds') ?>" class="element input-append" method="post">
        
          <div class="control-group">
            <label for="name" class="control-label"><?php echo __('Foco da Pesquisa') ?>:</label>
            <div class="controls"><input type="text" name="name" id="name" class="input-xxlarge" value="<?php echo $string ?>" /></div>
          </div>

          <div class="control-group">
            <label for="tipo" class="control-label"><?php echo __('Tipo de Estudo') ?>:</label>
            <div class="controls"><input type="text" name="tipo" id="tipo" class="input-xxlarge" value="'systematic review', 'systematic mapping', 'secondary study'" /></div>
          </div>

          <div class="control-group">
            <div class="controls"><button type="submit" class="btn btn-primary" id="commit"><i class="icon-search"></i> <?php echo __('Buscar') ?></button></div>
          </div>
        </form> -->

        <!--<div class="span9 hide" id="list"></div>-->
        <div id="result" class="hide well"></div>
        
        <div id="analysis"> <!-- class="hide" -->
          <!-- <h3><?php //echo __('Analisando as Revisões Sistemáticas Existentes') ?></h3> -->
  
          <p><?php echo __('Para analisar se as revisões sistemáticas existentes são suficientes, faz-se uso de critérios de avaliação como o CRD <abbr title="Database of Abstracts of Reviews of Effects">DARE</abbr> (veja material de apoio).<br />Para tanto, responda as questões abaixo') ?>:</p>
  
          <form action="#" class="form-horizontal" method="post">
            <div class="control-group">
              <div class="controls">
                <label><strong><?php echo __('As revisões sistemáticas listadas acima...') ?></strong></label>
                <label class="checkbox">
                  <input type="checkbox" id="dare1" name="dare" value="1"> <?php echo __('apresentam critérios adequados para seleção dos estudos.') ?>
                </label>
                <label class="checkbox">
                  <input type="checkbox" id="dare2" name="dare" value="2"> <?php echo __('cobriram todos os estudos primários relevantes.') ?>
                </label>
                <label class="checkbox">
                  <input type="checkbox" id="dare3" name="dare" value="3"> <?php echo __('apresentam avaliação a qualidade/validade dos estudos incluídos.') ?>
                </label>
                <label class="checkbox">
                  <input type="checkbox" id="dare4" name="dare" value="4"> <?php echo __('descrevem os dados básicos/estudos adequadamente.') ?>
                </label>
              </div>
            </div>
            <div class="form-actions">
              <div class="btn-group pull-left">
                 <button type="button" class="btn btn-success checkDare"><i class="icon-ok"></i> <?php echo __('Salvar e analisar') ?></button>
              </div>
              <div class="btn-group-item pull-left">
                 <?php echo __('ou') ?> <a href="/systematic_review" class="negate"><?php echo __('Cancelar') ?></a>
              </div>
            </div>
          </form>
        </div>

        <!-- Em caso de sucesso: todas as respostas preenchidas -->

        <div class="alert alert-block" id="needWarning">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h4><?php echo __('Não há necessidade de uma revisão sistemática neste contexto') ?>!</h4>
          <p><?php echo __('No entanto é possível repetir a revisão sistemática num novo contexto ou iteração, a fim de contribuir para o conhecimento anteriormente obtido. Esta repetição é uma das premissas básicas para a garantia de qualidade de uma revisão sistemática') ?>.</p>
          <div class="btn-group">
            <?php echo link_to('<i class="icon-trash"></i> '.__('Cancelar esta revisão'), 'systematic_review/delete?id='.$id, 'class=btn btn-warning') ?>
            <!-- TODO: Adicionar confirmação -->
            <?php echo link_to('<i class="icon-check"></i> '.__('Seguir com o planejamento'), 'systematic_review/team?id='.$id, 'class=btn finaliza') ?>
          </div>
        </div>

        <!-- Em caso de sucesso: todas as respostas preenchidas -->

        <div class="alert alert-success alert-block" id="needSuccess">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h4><?php echo __('As revisões sistemáticas atuais são insuficientes neste contexto') ?>.</h4>
          <p><?php echo __('Siga adiante com sua proposta de revisão, efetuando o planejamento da mesma') ?>:</p>
          <?php echo link_to('<i class="icon-check"></i> '.__('Concluir esta etapa'), 'systematic_review/team?id='.$id, 'class=btn finaliza') ?> <?php echo __('e seguir adiante') ?>
        </div>

        <?php //include '_form_results.php' ?>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function () {
       $(".checkDare").click(function(e){
        if($('#dare1').is(':checked') && $('#dare2').is(':checked') && $('#dare3').is(':checked') && $('#dare4').is(':checked')) {
            $("#needWarning").show();
            $("#needSuccess").hide();
            document.getElementById('needWarning').scrollIntoView();
        } else {
            $("#needWarning").hide();
            $("#needSuccess").show();
            document.getElementById('needSuccess').scrollIntoView();
        }
      });

      $(".finaliza").click(function(e){
        $.post("<?php echo url_for('systematic_review/finalizaTarefa')?>", { id: <?php echo $id?>, activity: 2 });
      });

      $("#commit").click(function(e){
          e.preventDefault();
          var form = $(this).parents("form");

          $("#result").show();
          $("#analysis").show();
          $.ajax({
              url: form.attr("action"),
              method: "POST",
              data: form.serialize(),
              success: function (data) {
                  /*$("#list").html(<?php //include '_list.php'; ?>).show();*/
              }
          });
        });
      });
    </script>
<?php else : ?>
  <?php include '_restricted.php' ?>
<?php endif; ?>
