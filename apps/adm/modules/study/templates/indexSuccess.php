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

<?php //if($review_id): ?>
	<?php //include_component('systematic_review', 'submenu', array ('id' => $review_id)); ?>
<?php //endif;?>

<div id="myModal" class="modal hid fade">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3><?php echo __('Avaliação de Qualidade dos Estudos') ?></h3>
    </div>
    <div class="modal-body"></div>
</div>

<div id="dataExtrationModal" class="modal hid fade">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3><?php echo __('Extração de Dados') ?></h3>
    </div>
    <form id="metadataForm" action="<?php echo url_for('@studies_extrat_metadata')?>" method="POST">
    <div class="modal-body" id="data_extation_modal_body">
    </div>
    </form>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancelar') ?></button>
      <button class="btn btn-primary" id="extration_save"><?php echo __('Salvar') ?></button>
    </div>
</div>

<div class="rows-fuild">
  <div class="span9">
    <div class="page-header">
      <h2><?php echo __('Seleção dos Estudos Primários') ?></h2>
    </div>

    <p><?php echo __('A seleção dos estudos primários inclui a classificação dos estudos presentes na documentação do processo de busca a partir dos critérios de inclusão e exclusão dos estudos definidos no protocolo da revisão') ?>.</p>

    <div id="msg"></div>

    <div class="alert alert-info">
      <h4><?php echo __('Importar Estudos') ?>:</h4>
      <form class="" id="import_bibtex_form" action="<?php echo url_for('@studies_import_bibtex?review_id=' . $review_id) ?>" method="POST" enctype="multipart/form-data">
        <div class="control-group">
          <label class="control-label" for="importBibtex"><?php echo __('Para adicionar estudos automaticamente através de um arquivo BibTex (.bib), inclua o arquivo abaixo') ?>:</label>
          <!--<div class="controls">
            <div class="input-append">
              <input type="text" id="importBibtex" class="input-xxlarge">
              <button class="btn btn-primary" type="button"><i class="icon-upload"></i> <?php echo __('Enviar') ?></button>
            </div>
          </div>-->
        </div>
        <div class="control-group">
          <label class="control-label" for=""></label>
          <div class="controls">
            <input class="input_file input-xlarge" type="file" name="file" id="import_bibtex" title="<?php echo __('Importar Bibtex'); ?>">
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <button class="btn btn-primary" type="submit" d="save_processo"><i class="icon-upload"></i> <?php echo __('Enviar') ?></button>
          </div>
        </div>
      </form>
    </div>
    
    <!-- studylist -->
	<?php
	  include_component('study', 'studylist', array ('review_id' => $review_id, 'dir' => $dir, 'order' => $order, 'studies' => $studies, 'criterios' => $criterios, 'extration' => ''));//extration));
	?>
  </div>
  
  <div class="span3">
    <ul class="nav nav-list bs-docs-sidenav affix span3">
      <li class="active"><a name=""><strong><?php echo __('Ações') ?>:</strong></a></li>
      <li><a href="<?php echo url_for('@studies_new?review_id=' . $review_id)?>"><i class="icon-file"></i> <?php echo __('novo estudo primário') ?></a></li>
      <li>
        <!-- TODO: implementar busca + filtros -->
        <form action="<?php echo url_for("studies/{$review_id}") ?>" class="element input-append" method="post">
          <input type="text" name="name" id="name" placeholder="Pesquisar" class="span8" />
          <?php echo button_tag('<i class="icon-search"></i>', 'class=btn') ?>
        </form>
      </li>
    
      <li class="active"><a name=""><strong><?php echo __('Métodos de Avaliação') ?>:</strong></a></li>
      <li>
        <form action="#" class="element" method="post">
          <label class="checkbox">
            <input type="checkbox" checked="checked"> <?php echo __('Seleção através de múltiplos pesquisadores') ?>
          </label>
          <label class="checkbox">
            <input type="checkbox"> <?php echo __('Testes de confiabilidade entre avaliadores (<em>inter-rater reliability test</em>)') ?>
          </label>
          <label class="checkbox">
            <input type="checkbox"> <?php echo __('Critérios de avaliação de qualidade dos estudos') ?>
          </label>
        </form>
      </li>
    </ul>
  </div>
	  <!--<div class="control-group">
	    <label class="control-label"><?php echo __('Ações') ?></label>
	  </div>
	  <div class="control-group">
        <div class="controls control-row">
		  <a class='btn' href="<?php //echo url_for('@studies_new?review_id=' . $review_id)?>"><i class="icon-plus"></i> <?php echo __('Novo estudo') ?></a>
        </div>
      </div>
	  <form id="import_bibtex_form" action="<?php echo url_for('@studies_import_bibtex?review_id=' . $review_id) ?>" method="POST" enctype="multipart/form-data">
	    <input class="input_file" type="file" name="file" id="import_bibtex" title="<?php echo __('Importar Bibtex') ?>">
        <button class="btn btn-primary" type="submit" id="save_processo"><i class="icon-upload"></i> <?php echo __('Enviar solicitação') ?></button>
	  </form>
      <form action="<?php //echo url_for("studies/{$review_id}") ?>" method="post">
        <div class="control-group">
          <div class="controls control-row">
            <input class="span10" type="text" name="title" id="title" size="16" placeholder="<?php echo __('Localizar') ?>" />
            <?php //echo button_tag('<i class="icon-search"></i>', 'class=btn span2 pull-right') ?>
	      </div>
	    </div>
	  </form>-->
	</div>
</div>
<script type="text/javascript">
$(window).load(function () {
	$('.avaliar').each(function(idx, item){
		$(this).bind('change', function() {
			link = '<?php echo url_for('study/avaliar?study_id=s_id&criteria_id=c_id') ?>';
			$.get(link
				.replace('s_id', $(this).attr('data-estudo'))
				.replace('c_id', $(this).val())
			);
		});
	});

  $('#myModal').on('shown', function () {
  	 $('#answerForm').ajaxForm();
  });


});

$(document).ready(function () {

	$('#import_bibtex').on('change', function (e) {
		$(this).parents('#import_bibtex_form').submit();
	});
	$('#arriving').on('keydown', function (e) {
		if (e.type == "keydown" && e.which == 13) e.preventDefault();
	});
	$('#form_waiting').off('submit').on('submit', function (e) {
	    e.preventDefault();
	    var error = '';
	    if ($('#atracacao_id').val().length == 0) {
	      error += '<p>'.__('Por favor selecione uma opção').'</p>';
	    }
	    if (error.length == 0)
	        submitRequest()
		else {
	        $('#error_msg').show().children().not('a').remove();
	        $('#error_msg').append(error);
	        $('html, body').animate({
	            scrollTop: $("#error_msg").offset().top - 100
	        }, 500);
	    }
	});
	$('#add_file').off('click').on('click', function (e) {
	    e.preventDefault();
	    var count = 0;
	    $('input:file').each(function () {
	      if (!$(this).val()) ++count;
	    });
	    if (count) {
	        $('#file_empty_error').show();
	}
	else {
	    var total = $('.input_file').size();
	    $('<input class="input_file" type="file" name="waiting_file[]" id="waiting_file_' + total + '" title="&lt;i class=&quot;icon-paper-clip&quot;&gt;&lt;/i&gt; anexar">')
	    	.insertAfter($("#files .file-input-name:last"));
	    $("#waiting_file_" + total).fileinput();
	}
	});


  $('.dataExtration').click(function(e){
	  e.preventDefault();

  		$.ajax({ type:'post',
  		    url:'<?php echo url_for('@studies_search_metadata') ?>',
  			  dataType:'xml',
  			  data:{ study_id: $(this).attr('data-study_id'),
  	  			   rsl_id: 1 },

  	  });
  });

  $('#extration_save').click(function(e){
	  e.preventDefault();
  	$('#metadataForm').ajaxSubmit();
	});

});

</script>