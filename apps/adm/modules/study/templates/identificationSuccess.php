<?php use_helper('Date', 'Text', 'I18N', 'enWidgets'); ?>

<?php ob_start();?>
<ul class="dropdown-menu">
  <li><a href="http://en.wikipedia.org/wiki/Cohen's_kappa" target="_blank"><i class="icon-external-link"></i> <?php echo __('Coeficientes estatísticos de Cohen Kappa para auxiliar na resolução <br />dos conflitos na seleção de estudos') ?></a></li>
  <li class="divider"></li>
  <li><a href="http://www.sciencedirect.com/science/article/pii/S0950584910001527" target="_blank"><i class="icon-external-link"></i> Barriers in the selection of offshore software development outsourcing <br />vendors: An exploratory study using a systematic literature review<br /> - Khan, Niazi e Ahmadd (2011)</a></li>
</ul>
<?php
  $support = ob_get_clean();
  include_component('systematic_review', 'submenu', array ('support' => $support, 'review_id' => $review_id));
?>

<div class="rows-fuild">
  <div class="span9">
    <div class="page-header">
      <h2><?php echo __('Identificação da Pesquisa') ?></h2>
    </div>

    <p><?php echo __('Este estágio compreende a gestão de bibliografia dos estudos primários em forma de listas de referências. Para tanto, utilize as opções abaixo') ?>:</p>
<?php if(!empty($success_qty)): ?>
    <div class='alert alert-success'>
      <a href="#" class="close" data-dismiss="alert">&times;</a><i class="icon-ok-sign"></i> <?php echo $success_qty ?> <?php echo __('estudo(s) importados com sucesso') ?>!
    </div>
<?php endif?>
<?php if(!empty($bib_error)): ?>
    <div class='alert alert-error'>
      <p><i class="icon-ok-sign"></i> <?php echo __('Ocorreu um erro ao tentar importar o(s) seguinte(s) estudo(s)') ?>:<br />
        "<strong><?php echo $bib_error ?></strong>".</p>
    </div>
<?php endif?>
    <div id="msg"></div>

    <ul class="nav nav-tabs" id="myTab">
      <li class=""><a data-toggle="tab" href="#list"><?php echo __('Estudos Incluídos') ?></a></li>
      <li class=""><a data-toggle="tab" href="#new"><?php echo __('Novo estudo') ?></a></li>
      <li><a data-toggle="tab" href="#bibtex"><?php echo __('Importar BibTeX') ?></a></li>
      <?php if (!empty($autobases)) : ?>
      <li class="dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo __('Bases Automatizadas') ?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
        <?php foreach ($autobases as $autobase) : ?>
          <li class=""><a data-toggle="tab" href="#<?php echo $autobase->getSearchBase()->getTxtid() ?>"><?php echo $autobase->getSearchBase()->getName() ?></a></li>
        <?php endforeach; ?>
        </ul>
      </li>
      <?php endif; ?>
    </ul>

	<div class="tab-content">
	    <div class="tab-pane" id="list">
			<?php
        	  include_component('study', 'studylist', array ('review_id' => $review_id, 'title' => $title, 'studies' => $studies, 'criterios' => $criterios, 'actionName' => $sf_context->getActionName()));
        	?>
        	<div class="">
              <div class="form-actions">
                <div class="btn-group pull-left">
                  <?php echo link_to('<i class="icon-ok"></i> '.__('Salvar'), '@studies_identification?id='.$review_id, array('id' => 'fakesave', 'class' => 'btn btn-success')) ?>
                  <?php echo link_to('<i class="icon-check"></i> '.__('Salvar e concluir'), '@studies_selection?id='.$review_id, array('id' => 'fakesavefinish','class' => 'btn finaliza')) ?>
                </div>
                <div class="btn-group-item pull-left"> <?php echo __('ou'); ?> <a href="/systematic_review" class="negate"><?php echo __('Cancelar') ?></a></div>
              </div>
            </div>
		</div>
		<div class="tab-pane" id="new">
		  <?php include '_form.php' ?>
		</div>
		<div class="tab-pane" id="bibtex" class="form-horizontal">
	      <form id="import_bibtex_form" action="<?php echo url_for('study/saveBibtex?review_id=' . $review_id) ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <fieldset>
                <legend><?php echo __('Importar estudos') ?>:</legend>
                <p><?php echo __('Para adicionar estudos automaticamente através de um arquivo BibTex <strong>(.bib)</strong>, inclua o arquivo abaixo') ?>:</p>
                <div class="control-group">
                  <label class="control-label" for="get_file"><?php echo __('Selecionar arquivo') ?>:</label>
                  <div class="controls">
                    <input class="input_file input-xlarge" type="file" name="file" id="get_file" title="<?php echo __('Importar Bibtex'); ?>" accept="application/x-bibtex" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="study_base_id"><?php echo __('Base de Dados') ?>:</label>
                  <div class="controls">
                  <?php echo $form['base_id']->render(array('class' => 'input-xxlarge'))//, 'required' => 'required')) ?>
                  </div>
                </div>
                <div class="form-actions">
                  <div class="btn-group pull-left">
                    <button class="btn btn-success" type="submit" id="import_bibtex"><i class="icon-cog"></i> <?php echo __('Enviar') ?></button>
                  </div>
                  <div class="btn-group-item pull-left"> <?php echo __('arquivo BibTeX') ?></div>
                </div>
          </fieldset>
        </form>
      </div>
<?php
  foreach ($autobases as $autobase) {
    $q = trim($autobase->getQueryString());
    include_partial('tabpaneSearchForm', array(
      'txtid'            => $autobase->getSearchBase()->getTxtid(),
      //'base_name'        => '<abbr title="' . $autobase->getSearchBase()->getName() . '">' . mb_strtoupper($autobase->getSearchBase()->getTxtid()) . '</abbr>',
      'base_name'        => $autobase->getSearchBase()->getName(),
      'base_querystring' => empty($q) ? $queryBusca : $q,
      'base_preview'     => $autobase->getSearchBase()->getPreviewUrl(),
      'base_guidelines'  => $autobase->getSearchBase()->getGuidelines(),
      'review_id'        => $review_id)
    );
  }
?>
    </div>
  </div>

  <div class="span3">
    <div class="well affix span3" style="padding: 8px 0;">
      <ul id="sidebar" class="nav nav-list">
        <li class="nav-header"><?php echo __('Ações') ?></li>
        <li class=""><a data-toggle="tab" href="#list" target="#list"><i class="icon-list-alt"></i> <?php echo __('listagem de estudos incluídos') ?></a></li>
        <li class=""><a data-toggle="tab" href="#new" target="#new"><i class="icon-file-alt"></i> <?php echo __('novo estudo primário') ?></a></li>
        <li class=""><a data-toggle="tab" href="#bibtex"><i class="icon-cog"></i> <?php echo __('importar BibTeX') ?></a></li>
        <li class="nav-header"><?php echo __('Buscas Automatizadas') ?></li>
        <?php foreach ($autobases as $autobase) : ?>
          <li class=""><a data-toggle="tab" href="#<?php echo $autobase->getSearchBase()->getTxtid() ?>"><?php echo $autobase->getSearchBase()->getName() ?></a></li>
        <?php endforeach; ?>
        <li class="divider"></li>
        <li>
	        <form action="<?php echo url_for( '@studies_identification?id='. $review_id) ?>" class="element input-append" method="get">
	          <input type="text" name="title" id="search" placeholder="Pesquisar" class="span8" value="<?php echo $title ?>" />
	          <?php echo button_tag('<i class="icon-search"></i>', 'class=btn') ?>
	        </form>
        </li>
      </ul>
    </div>
  </div>
</div>
<div id="waitingModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="waitingModalLabel" aria-hidden="true">
  <div class="modal-header">
    <h3 id="waitingModalLabel"><?php echo __('Processando busca...') ?></h3>
  </div>
  <div class="modal-body container">
    <div class="row">
      <div class="span1 offset1"><img alt="processando..." src="/img/preloader.gif"></div>
      <div class="span10"><?php echo __('Este processo pode demorar alguns minutos dependendo dos termos utilizados na <b>string de busca</b>. Por favor, aguarde') ?>.</div>
    </div>
  </div>
  <div class="modal-footer">
  </div>
</div>
<div id="removeModal" class="modal hide fade">
    <div class="modal-header">
    	<h3><?php echo __('Excluir Estudo') ?></h3>
    </div>
    <div class="modal-body">
		<div class="alert alert-block alert-alert">
			<i class="icon-info-sign"></i> <strong><?php echo __('Atenção') ?>!</strong>
			<?php echo __('Você realmente deseja excluir o estudo') ?> "<strong><span id="studyRevemoName"></span></strong>"?
		</div>
    </div>
    <div class="modal-footer">
	  <div class="btn-group">
        <button class="btn btn-danger" id="studyremove"><i class="icon-remove-sign"></i> <?php echo __('Excluir') ?></button>
	    <button class="btn" data-dismiss="modal"><i class="icon-remove"></i> <?php echo __('Cancelar') ?></button>
	  </div>
    </div>
</div>
<?php use_javascript('bootstrap/bootstrap.file-input.js') ?>
<script type="text/javascript">
function activateTab(id) {
  if ($.trim(id) == "") return;
  $('#myTab li.active').removeClass('active');
  var li = $('#myTab > li > a[href="' + id + '"]').get(0);
  if (li) $(li).parent().addClass('active');
  else $('#myTab li.dropdown').addClass('active');
}
$(document).ready(function () {
	$('#get_file').fileinput();
	/*$('#sidebar a').click(function(e) {
		e.preventDefault();
        $var = this.target;
        //alert($var);
	    $('#myTab a[href="#new"]').tab('show');
	})*/

    $('#myTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    })

	$('#myTab a:first').tab('show');

    $('#sidebar a[data-toggle="tab"]').on('show', function (e) {
      activateTab(e.target.hash);
    });

	$(".finaliza").click(function(e){
		$.post("<?php echo url_for('systematic_review/finalizaTarefa')?>", { id: <?php echo $review_id?>, activity: 10 });
	});

  $('button[data-context="crawled"]').on('click', function (e) {
    e.preventDefault();

    if (!confirm("<?php echo __('É recomendado executar uma busca preliminar antes de importar os estudos. Deseja continuar mesmo assim?') ?>")) return;

    $('#waitingModal').modal({
      keyboard: false,
      backdrop: <?php echo sfConfig::get('sf_environment') == 'dev' ? 'true' : '"static"' ?>
    });

    var $form = $(this).parents('form');

    $.post("<?php echo url_for('study/crawler');?>", $form.serialize() );
  });

  $('a[data-context="preview"]').on('click', function (e) {
    e.preventDefault();
    var $form = $(this).parents('form');
    var that = $(this);
    $.post("<?php echo url_for('study/updateQueryString'); ?>", $form.serialize()).done(function () {
      window.open(that.attr('href') + $('textarea[name="search_string"]', $form).val(), '<?php echo __('Busca preliminar') ?>');
    });
  });

  $('#studyremove').on('click', function(e) {
	  $(location).attr('href', $(this).attr('remove-link'));
  });
  $('a[remove-link]').on('click', function(e) {
	e.preventDefault();
	$('#studyremove').attr('remove-link', $(this).attr('remove-link'));
	$('#studyRevemoName').html($(this).attr('remove-name'));
	$('#removeModal').modal('show');
  });

	$('#import_bibtex').click(function(e){
		//e.preventDefault();
        //var form = $(this).parents("form");

        /*$("#result").show();
        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: form.serialize(),
            success: function (data) {
                $("#list").html(<?php //include '_list.php'; ?>).show();
            }
        });*/
		//$(this).parents('#import_bibtex_form').submit();
	});

	activateTab($(document).attr('location').hash);
});

</script>
