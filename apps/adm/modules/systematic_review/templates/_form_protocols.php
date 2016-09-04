<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>

<?php echo update_message(__('Os dados do protocolo foram atualizados com sucesso.'), __('A atualização nos dados do protocolo falhou.')) ?>

<?php echo form_errors_display($form) ?>

<form class="form-horizontal" action="<?php echo url_for('systematic_review/'.($form->getObject()->isNew() ? 'protocolCreate' : 'protocolUpdate').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>

  <?php echo $form->renderHiddenFields() ?>

  <input type="hidden" name="rsl_id" value="<?php echo $id ?>" />

  <fieldset>
    <legend id="arevisao"><?php echo __('Sobre a revisão') ?>:</legend>

    <div class="control-group">
      <label for="protocol_objective" class="control-label"><?php echo __('Objetivo') ?>:</label>
      <div class="controls"><?php echo $form['objective']->render(array('class' => 'input-xxlarge')) ?></div>
    </div>
  </fieldset>

  <fieldset>
    <legend id="questaopesquisa"><?php echo __('Sobre a questão de pesquisa') ?>:</legend>

    <div class="control-group">
      <label for="protocol_population" class="control-label"><?php echo __('População') ?>:</label>
      <div class="controls controls-row">
      	<div class="btn-group">
	      	<?php echo $form['population']->render(array('class' => 'span11 search_string', 'id' => 'protocol_population')) ?>
	      	<a class="btn" target='protocol_population' onthology-display="onthology_pop"><i class="icon-search"></i></a>
      	</div>
      	<div id="onthology_pop"></div>
      </div>
    </div>

    <div class="control-group">
      <label for="protocol_intervention" class="control-label"><?php echo __('Intervenção') ?>:</label>
      <div class="controls controls-row">
      	<div class="btn-group">
	      	<?php echo $form['intervention']->render(array('class' => 'span11 search_string', 'id' => 'protocol_intervention')) ?>
	      	<a class="btn" target='protocol_intervention' onthology-display="onthology_int"><i class="icon-search"></i></a>
      	</div>
      	<div id="onthology_int"></div>
      </div>
    </div>

    <div class="control-group">
      <label for="protocol_comparative" class="control-label"><?php echo __('Comparação') ?>:</label>
        <div class="controls controls-row">
          <div class="btn-group">
	          <?php echo $form['comparative']->render(array("class" => "span11 search_string", 'id' => 'protocol_comparative', "rel" => "tooltip", "data-original-title" => __('É possível realizar revisões de caracterização mediante a omissão dos parâmetros de comparação.'), "data-placement" => "bottom")) ?>
	          <a class="btn" target='protocol_comparative' onthology-display="onthology_com"><i class="icon-search"></i></a>
          </div>
          <div id="onthology_com"></div>
        </div>
    </div>

    <div class="control-group">
      <label for="protocol_outcome" class="control-label"><?php echo __('Resultados') ?>:</label>
       <div class="controls controls-row">
         <div class="btn-group">
	       	 <?php echo $form['outcome']->render(array('class' => 'span11 search_string', 'id' => 'protocol_outcome')) ?>
	       	 <a class="btn" target='protocol_outcome' onthology-display="onthology_res"><i class="icon-search"></i></a>
       	 </div>
       	 <div id="onthology_res"></div>
       </div>
    </div>

    <div class="control-group">
      <label for="protocol_context" class="control-label"><?php echo __('Contexto') ?>:</label>
       <div class="controls controls-row">
       	  <div class="btn-group">
	       	  <?php echo $form['context']->render(array('class' => 'span11 search_string', 'id' => 'protocol_context', "rel" => "tooltip", "data-original-title" => __('É possível omitir o contexto, quando os fatores que contribuem para o sucesso ou fracasso do estudo não são relevantes.'), "data-placement" => "bottom")) ?>
	       	  <a class="btn" target='protocol_context' onthology-display="onthology_cont"><i class="icon-search"></i></a>
       	  </div>
       	  <div id="onthology_cont"></div>
       </div>
    </div>

    <div class="control-group">
      <label for="protocol_search_string" class="control-label"><?php echo __('String de busca') ?>:</label>
       <div class="controls"><?php echo $form['search_string']->render(array('class' => 'input-xxlarge')) ?></div>
    </div>
  </fieldset>

  <fieldset>
    <legend id="criteriosselecao"><?php echo __('Critérios de seleção dos estudos') ?>:</legend>
    <div id="criteria_list">
      <?php include '_criterias.php'; ?>
    </div>
  </fieldset>

  <fieldset>
    <legend id="estrategiaselecao"><?php echo __('Estratégia de seleção dos estudos') ?>:</legend>
    <div class="control-group">
        <?php echo $form['strategy_id']->render() ?>
    </div>
  </fieldset>

  <fieldset>
    <legend id="processopesquisa"><?php echo __('Processo de pesquisa') ?>:</legend>

    <div class="control-group">
		<label for="protocol_metodology" class="control-label"><?php echo __('Metodologia') ?>:</label>
		<div class="controls"><?php echo $form['metodology']->render(array('class' => 'input-xxlarge')) ?></div>
    </div>

    <div class="control-group">
		<label for="protocol_assessment" class="control-label"><?php echo __('Avaliação qualitativa') ?>:</label>
		<div class="controls"><?php echo $form['assessment']->render(array('class' => 'input-xxlarge')) ?></div>
    </div>

    <div class="control-group">
		<label for="protocol_data_extraction" class="control-label"><?php echo __('Extração dos dados') ?>:</label>
		<div class="controls"><?php echo $form['data_extraction']->render(array('class' => 'input-xxlarge')) ?></div>
    </div>

    <div class="control-group">
		<label for="protocol_data_analisys" class="control-label"><?php echo __('Análise dos dados') ?>:</label>
		<div class="controls"><?php echo $form['data_analisys']->render(array('class' => 'input-xxlarge')) ?></div>
    </div>

    <div class="control-group">
		<label for="protocol_dissemination" class="control-label"><?php echo __('Disseminação') ?>:</label>
		<div class="controls"><?php echo $form['dissemination']->render(array('class' => 'input-xxlarge')) ?></div>
    </div>
  </fieldset>

  <fieldset>
    <legend id="sintesedados"><?php echo __('Síntese dos dados') ?>:</legend>
    <div id="list_metadata">
      <?php include '_list_metadata.php' ?>
    </div>
  </fieldset>

  <fieldset>
    <legend id="fontespesquisa"><?php echo __('Fontes de pesquisa') ?>:</legend>

    <div class="control-group">
      <div class="controls">

      <?php foreach($search_bases as $x => $base) :?>
        <label for="base_<?php echo $base->getId()?>" class="checkbox">
          <input id="base_<?php echo $base->getId()?>" name="base[]" <?php echo $base->hasChecked($form->getObject()->getId(), $form->getObject()->getRslId()) ? 'checked="checked"' : '' ?> type="checkbox" value="<?php echo $base->getId()?>" /><?php echo $base->getName()?>
        </label>
      <?php endforeach;?>
      </div>
    </div>

    <h4><?php echo __('Outras fontes') ?>:</h4>
    <div id="list_search_base">
      <?php include '_list_base_search.php' ?>
    </div>
  </fieldset>

  <fieldset>
    <legend id="cronogramapesquisa"><?php echo __('Cronograma de pesquisa') ?>:</legend>
    <div id="list_framework">
      <?php include '_frameworks.php' ?>
    </div><br/>

    <div class="control-group">
      <label class="control-label">&nbsp;</label>
      <div class="controls">
        <?php //echo save_edit_conclude_controls($form->getObject(), __('este protocolo')) ?>
        <div class="btn-group pull-left">
          <button class="btn btn-success" type="submit" name="commit"><i class="icon-ok"></i> <?php echo __('Salvar') ?></button>
          <button class="btn" value="@protocol_validation?id=<?php echo $id ?>" type="submit" name="finaliza"><i class="icon-check"></i> <?php echo __('Salvar e concluir') ?></button>
        </div>
        <div class="btn-group-item pull-left">
           <?php echo __('ou') ?> <a href="/adm_dev.php/systematic_review" class="negate"><?php echo __('Cancelar') ?></a>
        </div>
      </div>
    </div>


  </fieldset>
</form>

<?php $culture = (sfContext::getInstance()->getUser()->getCulture() == 'pt_BR')?'pt-BR':'en'; ?>

<?php
  use_javascript('wysihtml5/wysihtml5-0.3.0.js');
  use_javascript('bootstrap/bootstrap-wysihtml5.js');
	if ($culture == 'pt-BR') {
		use_javascript('bootstrap/bootstrap-wysihtml5.pt-BR.js');
	}
?>
<script type="text/javascript">
  $('#protocol_objective').wysihtml5({locale: "<?php echo $culture; ?>"});
  $('#protocol_metodology').wysihtml5({locale: "<?php echo $culture; ?>"});
  $('#protocol_assessment').wysihtml5({locale: "<?php echo $culture; ?>"});
  $('#protocol_data_analisys').wysihtml5({locale: "<?php echo $culture; ?>"});
  $('#protocol_data_extraction').wysihtml5({locale: "<?php echo $culture; ?>"});
  $('#protocol_dissemination').wysihtml5({locale: "<?php echo $culture; ?>"});

  $('[rel=popover]').data('popover');

  function addDatePicker()
  {
    $('.date_framework').datetimepicker({
      language: '<?php echo $culture; ?>',
      pickTime: false
    });
  }
  addDatePicker();

  $(function () {
    $('[rel=tooltip]').tooltip();
  });

  $(function () {
    $('[rel=popover]').popover();
  });

  var old_search_string = "<?php echo $old_search_string ?>";
  var arr_string = new Array();

  $(document).ready(function (){
	  $(document).on('click', '#add_criteria', function (e) {
		  e.preventDefault();
		  $.ajax({ type:'post', dataType:'xml', data:{ name:$("#name").val(), type:$("#type").val(), protocol_id: '<?php echo $form->getObject()->getId(); ?>', rsl_id:<?php echo $id ?> }, url:'<?php echo url_for('systematic_review/newCriteria'); ?>' });
		  $("#name").val('');
	  });

	  $(document).on('click', 'a[data-context="rem-criteria"]', function (e) {
		  e.preventDefault();
 	 	  var addr = $(this).attr('href');
		  $.ajax({ type:'get', dataType:'xml', url:addr });
	  });

	  $(".search_string").change(function (){

		  arr_string[0] = $('#protocol_population').val();
		  arr_string[1] = $('#protocol_intervention').val();
		  arr_string[2] = $('#protocol_comparative').val();
		  arr_string[3] = $('#protocol_outcome').val();
		  arr_string[4] = $('#protocol_context').val();

      var search_string = $('#protocol_search_string').val();

		  var string_search = '';
		  for (var i=0; i<5; i++)
		  {
        arr_string[i] = arr_string[i].replace(/, /g,",");
        if(arr_string[i].search(',') > 0) {
          var list_keys = arr_string[i].split(',');
          arr_string[i] = '(';
          for (var j=0; j<list_keys.length; j++) {
            if(list_keys[j].search(' ') > -1) {
              list_keys[j] = '"'+list_keys[j]+'"';
            }
            if (j != 0) { arr_string[i] += ' OR '; }
            arr_string[i] += list_keys[j];
          }
          arr_string[i] += ')';
        } else {
          if(arr_string[i].search(' ') > -1) {
            arr_string[i] = '"'+arr_string[i]+'"';
          }
        }
        if (arr_string[i] != '')
        {
          string_search += arr_string[i] + ' AND ';
        }
		  }
		  string_search = string_search.substring(0,(string_search.length - 4));

		  //search_string = search_string.replace(old_search_string,'');
      search_string = '';
		  search_string = string_search + search_string;
		  old_search_string = string_search;

		  if (string_search == '')
		  {
		  	verify_search = search_string.substring(0,4);
		  	if (verify_search == 'AND ')
		  	{
		  		search_string = search_string.substring(4,search_string.length);
		  	}
		  }

		  search_string = search_string.replace('\' \'','\' AND \'');

		  $('#protocol_search_string').val(search_string);
	  });
  });

  function addButtonMetadata()
  {
    $('#metadata_categories').hide();
    $('#metadata_bibtex_field').hide();
    $(document).on('change', '#metadata_type', function(e) {
      var val = parseInt($('#metadata_type').val());
      switch (val) {
      case <?php echo Metadata::CATEGORIAS ?> :
        $('#metadata_categories').show();
        $('#metadata_bibtex_field').hide();
        break;
      case <?php echo Metadata::BIBTEX ?> :
        $('#metadata_categories').hide();
        $('#metadata_bibtex_field').show();
        break;
      default:
        console.info($('#metadata_type').val());
        $('#metadata_categories').hide();
        $('#metadata_bibtex_field').hide();
        break;
      }
    });

    $(document).on('click', '#metadata_button', function(e){
      e.preventDefault();
      if($("#metadata_name").val() == '' || $("#metadata_name").val() == null) {
        //alert(<?php echo __('O campo nome é obrigatório') ?>);
        alert('O campo nome é obrigatório');
      } else {
        $.ajax({ type:'post', dataType:'xml', data:{ name:$("#metadata_name").val(), type:$("#metadata_type").val(), categories: $("#metadata_categories").val(), bibtex: $('#metadata_bibtex_field').val(), rsl_id: '<?php echo $id ?>' }, url:'<?php echo url_for('@update_metadata') ?>' });
      }
    });
  }

function addButtonMetadataDelete()
{
	$(document).on('click', '.metadata_delete', function(e)
	{
		e.preventDefault();

		$.ajax({ type:'post', dataType:'xml', data:{ id:$(this).attr('value'), rsl_id: <?php echo $id ?> }, url:'<?php echo url_for('@delete_metadata') ?>' });
	});
}

function addButtonBaseSearch()
{

	$(document).on('click', '#search_base_button', function(e){
		e.preventDefault();

		if($("#base_search_name").val() == '' || $("#base_search_name").val() == null)
		{
			alert('O campo nome é obrigatório');
		}
		else
		{
			//api: $("#base_search_api").val()
			$.ajax({
				 type:'post',
				 dataType:'xml',
				 data:{ name: $("#base_search_name").val(), base_url: $("#base_search_url").val(), rsl_id: <?php echo $id ?>, protocol_id: '<?php echo $form->getObject()->getId() ?>' },
				 url:'<?php echo url_for('@update_search_base') ?>'
			});
		}
	});
}

function addButtonBaseSearchDelete()
{
	$(document).on('click', '.base_search_delete', function(e)
	{
		e.preventDefault();

		$.ajax({ type:'post', dataType:'xml', data:{ id:$(this).attr('value'), rsl_id: <?php echo $id ?>, protocol_id: '<?php echo $form->getObject()->getId() ?>' }, url:'<?php echo url_for('@delete_search_base') ?>' });
	});
}

//if($('#framework').val() != '')
//{
//	callFrameWorkDetails($('#framework').val());
//  callFrameWorkDetails(1);
//}

$('#framework').change(function(e){
	callFrameWorkDetails($(this).val());
});

function callFrameWorkDetails(framework_id)
{
  $.ajax({
		 type:'post',
		 dataType:'xml',
		 data:{ id: framework_id, rsl_id: <?php echo $id ?>, protocol_id: '<?php echo $form->getObject()->getId() ?>' },
		 url:'<?php echo url_for('@framework_details') ?>'
	});
}
$(document).ready(function(){
  $("#submenu a").not('[data-affix=no_affix]').on('click', function (e) {
    e.preventDefault();
    $('html,body').animate({
      scrollTop: $($(this).attr('href')).offset().top - 140
    }, 500);
  });

  callFrameWorkDetails(1);

  addButtonMetadata();
  addButtonMetadataDelete();
  addButtonBaseSearch();
  addButtonBaseSearchDelete();

  $('a[onthology-display]').on('click', function() {
	$.ajax({
	  url: '<?php echo url_for('systematic_review/onthologySuggestion') ?>',
	  data: {
		  target: $(this).attr('target'),
		  display_in: $(this).attr('onthology-display'),
		  search: $('#' + $(this).attr('target')).val()
	  }
	});
  });  
});
</script>