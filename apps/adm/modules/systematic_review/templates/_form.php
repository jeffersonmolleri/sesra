
<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>

<?php echo update_message('<i class="icon-ok-sign"></i> Os dados da revisão sistemática foram atualizados com sucesso', '<div class="msg alert alert-error"><i class="icon-remove-sign"></i> A atualização nos dados da revisão sistemática falharam</div>') ?>

<?php echo form_errors_display($form) ?>

<form class="form-horizontal" action="<?php echo url_for('systematic_review/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() . '&protocol_id=' . $form->getEmbeddedForm('protocol')->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>

  <?php echo $form->renderHiddenFields() ?>

  <input type="hidden" name="requester" value="<?php echo $requester ?>" />

  <fieldset class="<?php echo ($requester == 'question' ? 'hide' : ''); ?>">
    <legend id="sobrerevisao"><?php echo __('Sobre esta revisão') ?>: </legend>

    <div class="control-group">
      <label for="systematic_review_title" class="control-label"><?php echo __('Título') ?>*:</label>
      <div class="controls"><?php echo $form['title']->render(array('class' => 'input-xxlarge', 'required' => 'required')) ?></div>
    </div>

    <div class="control-group">
      <label for="protocol_objective" class="control-label"><?php echo __('Objetivo da pesquisa') ?>:</label>
      <div class="controls"><?php echo $protocolForm['objective']->render(array ('class' => 'input-xxlarge', 'id' => 'protocol_objective')) ?></div>
    </div>
    
    <div class="control-group">
      <div class="controls">
        <label for="is_active" class="checkbox">
          <?php echo $form['restrict']->render(array()) ?> <?php echo __('Tornar pública') ?>?<br />
          <small><?php echo __('Isto tornará a revisão parte do repositório de conhecimento da ferramenta ARS para consultas futuras') ?>.</small>
        </label>
      </div>
    </div>
  </fieldset>

  <fieldset>

    <legend id="questaopesquisa"><?php echo __('Questão de Pesquisa') ?>:</legend>
    
    <div class="control-group input-append">
      <label for="protocol_question" class="control-label"><?php echo __('Descrição da questão') ?>:</label>
      <div class="controls"><?php echo $form['question']->render(array ('class' => 'input-xxlarge')) ?></div>
    </div>
    
    <hr />
    
    <p><?php echo __('A especificação das questões de pesquisa segue a proposta do acrônimo PICOC (veja material de apoio), permitindo o endereçamento de seus cinco componentes (população, intervenção, comparação, resultados e contexto) que fundamentarão a string de busca') ?>.</p>

    <div class="control-group">
      <label for="protocol_population" class="control-label"><?php echo __('População') ?>:</label>
      <div class="controls controls-row">
      	<div class="btn-group">
	      	<?php echo $protocolForm['population']->render(array('class' => 'span11 search_string', 'id' => 'protocol_population')) ?>
	      	<a class="btn" target='protocol_population' onthology-display="onthology_pop"><i class="icon-search"></i></a>
      	</div>
      	<div id="onthology_pop"></div>
      </div>
    </div>

    <div class="control-group">
      <label for="protocol_intervention" class="control-label"><?php echo __('Intervenção') ?>:</label>
      <div class="controls controls-row">
      	<div class="btn-group">
	      	<?php echo $protocolForm['intervention']->render(array('class' => 'span11 search_string', 'id' => 'protocol_intervention')) ?>
	      	<a class="btn" target='protocol_intervention' onthology-display="onthology_int"><i class="icon-search"></i></a>
      	</div>
      	<div id="onthology_int"></div>
      </div>
    </div>

    <div class="control-group">
      <label for="protocol_comparative" class="control-label"><?php echo __('Comparação') ?>:</label>
        <div class="controls controls-row">
          <div class="btn-group">
	          <?php echo $protocolForm['comparative']->render(array("class" => "span11 search_string", 'id' => 'protocol_comparative', "rel" => "tooltip", "data-original-title" => __('É possível realizar revisões de caracterização mediante a omissão dos parâmetros de comparação.'), "data-placement" => "bottom")) ?>
	          <a class="btn" target='protocol_comparative' onthology-display="onthology_com"><i class="icon-search"></i></a>
          </div>
          <div id="onthology_com"></div>
        </div>
    </div>

    <div class="control-group">
      <label for="protocol_outcome" class="control-label"><?php echo __('Resultados') ?>:</label>
       <div class="controls controls-row">
         <div class="btn-group">
	       	 <?php echo $protocolForm['outcome']->render(array('class' => 'span11 search_string', 'id' => 'protocol_outcome')) ?>
	       	 <a class="btn" target='protocol_outcome' onthology-display="onthology_res"><i class="icon-search"></i></a>
       	 </div>
       	 <div id="onthology_res"></div>
       </div>
    </div>

    <div class="control-group">
      <label for="protocol_context" class="control-label"><?php echo __('Contexto') ?>:</label>
       <div class="controls controls-row">
       	  <div class="btn-group">
	       	  <?php echo $protocolForm['context']->render(array('class' => 'span11 search_string', 'id' => 'protocol_context', "rel" => "tooltip", "data-original-title" => __('É possível omitir o contexto, quando os fatores que contribuem para o sucesso ou fracasso do estudo não são relevantes.'), "data-placement" => "bottom")) ?>
	       	  <a class="btn" target='protocol_context' onthology-display="onthology_cont"><i class="icon-search"></i></a>
       	  </div>
       	  <div id="onthology_cont"></div>
       </div>
    </div>

    <div class="control-group hide">
      <label for="protocol_search_string" class="control-label"><?php echo __('String de busca') ?>:</label>
       <div class="controls"><?php echo $protocolForm['search_string']->render(array('id' => 'protocol_search_string')) ?></div>
    </div>

    <div class="form-actions">
      <?php if ($requester == 'question'): ?>
        <?php //echo save_edit_conclude_controls($form->getObject(), __('a questão de pesquisa')) ?>
        <div class="btn-group pull-left">
          <button class="btn btn-success" type="submit" name="commit"><i class="icon-ok"></i> <?php echo __('Salvar') ?></button>
          <button class="btn finaliza" value="systematic_review/protocols?id=<?php echo $id ?>" type="submit"><i class="icon-check"></i> <?php echo __('Salvar e concluir') ?></button>
        </div>
        <div class="btn-group-item pull-left">
           <?php echo __('ou') ?> <a href="/systematic_review" class="negate"><?php echo __('Cancelar') ?></a>
        </div>
      <?php else: ?>
        <?php //echo save_edit_controls($form->getObject(), __('esta revisão sistemática')) ?>
        <div class="btn-group pull-left">
          <button class="btn btn-success" type="submit" name="commit"><i class="icon-ok"></i> <?php echo __('Salvar') ?></button>
        </div>
        <div class="btn-group-item pull-left">
           <?php echo __('ou') ?> <a href="/systematic_review" class="negate"><?php echo __('Cancelar') ?></a>
        </div>
      <?php endif; ?>
    </div>

  </fieldset>
</form>

<?php $culture = (sfContext::getInstance()->getUser()->getCulture() == 'pt_BR')?'pt-BR':'en'; ?>

<?php
  use_javascript('users');
  use_javascript('wysihtml5/wysihtml5-0.3.0.js');
  use_javascript('bootstrap/bootstrap-wysihtml5.js');
  use_javascript('bootstrap/bootstrap-wysihtml5.pt-BR.js');
?>
<script type="text/javascript">
  $('#protocol_objective').wysihtml5({locale: "<?php echo $culture; ?>"});

  $(function () {
    $('[rel=tooltip]').tooltip();
  });

  var requester = <?php echo "'".$requester."'" ?>;
  var old_search_string = "";
  var arr_string = new Array();

  $(document).ready(function (){
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
</script>

<?php if ($requester == 'question'): ?>
<script type="text/javascript">
  $(document).ready(function (){
    $(".finaliza").click(function(e){
      $.post("<?php echo url_for('systematic_review/finalizaTarefa')?>", { id: <?php echo $id ?>, activity: 5 });
    });
  });
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
</script>
<?php endif; ?>