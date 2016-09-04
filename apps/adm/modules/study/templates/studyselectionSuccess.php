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

<div id="myModal" class="modal hide fade" style="width:80%; left:30%">
    <div class="modal-header"></div>
    <div class="modal-body"></div>
    <div class="modal-footer"></div>
</div>

<div class="rows-fuild">
  <div class="span9">
    <div class="page-header">
      <h2><?php echo __('Seleção dos Estudos Primários') ?></h2>
    </div>
    <p><?php echo __('A seleção dos estudos primários inclui a classificação dos estudos presentes na documentação do processo de busca a partir dos critérios de inclusão e exclusão dos estudos definidos no protocolo da revisão') ?>.</p>
	<table id="listagem_estudos" class="table table-striped">
      <thead>
        <tr>
          <th></th>
          <th><?php echo link_to('Título', "study/{$sf_context->getActionName()}?id={$review_id}?order=".StudyPeer::TITLE.'&dir='.$dir, array ('class' => ($order == StudyPeer::TITLE ? $dir : ''))) ?></th>
          <!-- <th><?php //echo link_to('Url', "studies/{$review_id}?order=".StudyPeer::URL.'&dir='.$dir, array ('class' => ($order == StudyPeer::URL ? $dir : ''))) ?></th> -->
					<th><?php echo __('Qualidade') ?></th>
					<th><?php echo __('Seleção') ?></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($studies->getResults() as $st) : ?>
        <tr class="<?php echo $st[8] === 0 ? 'warning':''; ?>">
          <td>
          <?php if($st[8] === 0) {
		    		echo '<i class="icon-exclamation-sign" title="'.__('divergências encontradas na seleção').'"></i>';
		    	} else if(empty($st[8])) {
		    		echo '<i class="icon-circle-blank" title="'.__('estudo ainda não selecionado').'"></i>';
		    	} else if($st[8] > 0) {
		    		echo '<i class="icon-plus-sign" title="'.__('estudo incluído').'"></i>';
		    	} else {
		    		echo '<i class="icon-minus-sign" title="'.__('estudo excluído').'"></i>';
		    	}?>
          </td>
          <td>
            <?php echo truncate_text($st[1], 144) ?><br />
            <?php if(!empty($st[2])) : ?>
            <small><a href="<?php echo $st[2] ?>" target="_blank"><i class="icon-share"></i> <?php echo truncate_text($st[2], 50) ?></a></small>
            <?php endif ?>
          </td>

          <td><?php echo $st[7] ? $st[7] : '-' ?></td>
          <td>
            <?php if($st[8] === 0) :?>
              <button class="btn btn-small btn-warning activateModalMediacao" data-study="<?php echo $st[0]; ?>" data-review="<?php echo $review_id; ?>">
                <i class="icon-exclamation-sign"></i> <?php echo __('solicitar mediação') ?>
              </button>
            <?php elseif(!empty($st[9])) :?>
              <?php echo __('Divergência solucionada') ?>: <a class="activateModal" data-study="<?php echo $st[0]; ?>" data-review="<?php echo $review_id; ?>">"<?php echo $st[9] ?>"</a>
            <?php elseif(!empty($st[10])) :?>
              <button class="btn btn-small btn-warning activateModalMediacao" data-study="<?php echo $st[0]; ?>" data-review="<?php echo $review_id; ?>">
                <i class="icon-exclamation-sign"></i> <?php echo __('alterar mediador') ?>
              </button>
            <?php elseif(!empty($st[6])) :?>
              <a class="activateModal clickable" data-study="<?php echo $st[0]; ?>" data-review="<?php echo $review_id; ?>">
                <?php echo ($st[8] > 0) ? '<small class="text-success"><i class="icon-plus-sign" title="estudo incluído"></i>' : '<small class="text-error"><i class="icon-minus-sign" title="estudo excluído"></i>'; ?>
                <?php echo $criterios[$st[6]]->name ?>
              </small></a>
            <?php else :?>
              <button class="btn btn-small btn-info activateModal" data-study="<?php echo $st[0]; ?>" data-review="<?php echo $review_id; ?>">
                <i class="icon-ok"></i> <?php echo __('selecionar') ?>
              </button>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>

      <?php if (!$studies->getNbResults()): ?>
        <tr class="info">
          <td colspan="4" class="emptyCell text-center"><?php echo link_to('<strong>'.__('Atenção').'!</strong> '.__('Nenhum estudo cadastrado para esta revisão sistemática. Clique aqui para adicionar.'), '@studies_identification?id='.$review_id.'#new', array('style' => 'display:block;')) ?></td>
        </tr>
      <?php endif; ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="4"> <!-- TODO: rever com Pedro -->
            <?php echo format_number_choice('[0]nenhum estudo cadastrado|[1]um estudo cadastrado|(1,Inf]%1% estudos cadastrados', array ('%1%' => $studies->getNbResults()), $studies->getNbResults()) ?>
          </th>
        </tr>
      </tfoot>
    </table>
    <?php $url = "study/studyselection?id={$review_id}&page=" ?>
    <?php $url .= empty($title) ? '' : '&title='.$title ?>
    <?php $url .= empty($filter) ? '' : '&filter='.$filter ?>
    <?php echo form_pager_display($studies, $url . '&page='); ?>
    
    <div class=""> <!-- form-horizontal -->
      <div class="form-actions">
        <div class="btn-group pull-left">
          <?php echo link_to('<i class="icon-ok"></i> '.__('Salvar'), '@studies_selection?id='.$review_id, array('class' => 'btn btn-success')) ?>
          <?php echo link_to('<i class="icon-check"></i> '.__('Salvar e concluir'), '@studies_assessment?id='.$review_id, array('class' => 'btn finaliza')) ?>
        </div>
        <div class="btn-group-item pull-left"> <?php echo __('ou'); ?> <a href="/systematic_review" class="negate"><?php echo __('Cancelar') ?></a></div>
      </div>
    </div>
  </div>
  
  <div class="span3">
    <div class="well affix span3" style="padding: 8px 0;">
      <ul id="sidebar" class="nav nav-list">
        <li class="nav-header"><?php echo __('Filtrar') ?></li>
        <li><?php echo link_to('<i class="icon-circle-blank"></i> '.__('estudos não selecionados'), '@studies_selection?filter=empty&id='.$review_id) ?></li>
        <li><?php echo link_to('<i class="icon-plus-sign"></i> '.__('estudos incluídos'), '@studies_selection?filter=included&id='.$review_id, array('class'=> 'text-success')) ?></li>
        <li><?php echo link_to('<i class="icon-minus-sign"></i> '.__('estudos excluídos'), '@studies_selection?filter=excluded&id='.$review_id, array('class'=> 'text-error')) ?></li>
        <li><?php echo link_to('<i class="icon-circle"></i> '.__('todos os estudos'), '@studies_selection?id='.$review_id) ?></li>
        <li class="divider"></li>
        <li><?php echo link_to('<i class="icon-exclamation-sign"></i> '.__('exibir divergências'), '@studies_selection?filter=divergente&id='.$review_id, array('class'=> 'text-warning')) ?></li>
        <li><?php echo link_to('<i class="icon-ok-sign"></i> '.__('exibir divergências resolvidas'), '@studies_selection?filter=divergente_resolvida&id='.$review_id, array('class'=> 'text-success')) ?></li>
        <li class="divider"></li>
        <li>
        <form action="<?php echo url_for( '@studies_selection?id='. $review_id) ?>" class="element input-append" method="get">
          <input type="text" name="title" id="search" placeholder="Pesquisar" class="span8" value="<?php echo $title ?>" />
          <?php echo button_tag('<i class="icon-search"></i>', 'class=btn') ?>
        </form>
        </li>
      </ul>
    </div>
  </div>
</div>

<script type="text/javascript">
$(window).load(function () {
	/*$('.avaliar').each(function(idx, item){
		$(this).bind('change', function() {
			link = '<?php echo url_for('study/avaliar?study_id=s_id&criteria_id=c_id') ?>';
			$.get(link
				.replace('s_id', $(this).attr('data-estudo'))
				.replace('c_id', $(this).val())
			);
		});
	});*/
});

$(document).ready(function () {
    
	$(".finaliza").click(function(e){
		$.post("<?php echo url_for('systematic_review/finalizaTarefa')?>", { id: <?php echo $review_id?>, activity: 11 });
	});

	$('#import_bibtex').on('change', function (e) {
		$(this).parents('#import_bibtex_form').submit();
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
	    $('<input class="input_file" type="file" name="waiting_file[]" id="waiting_file_' + total + '" title="&lt;i class=&quot;icon-paper-clip&quot;&gt;&lt;/i&gt; <?php echo __('anexar') ?>">')
	    	.insertAfter($("#files .file-input-name:last"));
	    $("#waiting_file_" + total).fileinput();
	}
	});

	$('.selecao_text').on('click', function(e) {
		e.preventDefault();
		$(this).hide();
		$('select[data-estudo=' + $(this).attr('data-estudo') + ']').show(); 
	});

	$('.activateModal').on('click', function(e) {
		e.preventDefault();
		$.ajax({ 
			type:'post', 
			dataType:'xml', 
			data:{ 
				study_id: $(this).attr('data-study'), 
				review_id: $(this).attr('data-review'), 
			}, 
			url:'<?php echo url_for('study/classify') ?>' 
		 });			
	});
	
	$('.activateModalMediacao').on('click', function(e) {
		e.preventDefault();
		$.ajax({ 
			type:'post', 
			dataType:'xml', 
			data:{ 
				study_id: $(this).attr('data-study'), 
				review_id: $(this).attr('data-review'), 
			}, 
			url:'<?php echo url_for('study/solicitarAvaliador') ?>' 
		 });			
	});
	$('#solicitarAvaliacao').on('click', function(e) {
		e.preventDefault();
		$('#solicitarAvaliacaoForm').submit();			
	});
	
});
</script>