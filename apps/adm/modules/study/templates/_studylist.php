	<table id="listagem_estudos" class="table table-striped">
      <thead>
        <tr>
          <th></th>
          <th><?php echo link_to(__('Título'), "study/{$actionName}?id={$review_id}?order=".StudyPeer::TITLE.'&dir='.$dir, array ('class' => ($order == StudyPeer::TITLE ? $dir : ''))) ?></th>
          <!-- <th><?php //echo link_to('Url', "studies/{$review_id}?order=".StudyPeer::URL.'&dir='.$dir, array ('class' => ($order == StudyPeer::URL ? $dir : ''))) ?></th> -->

          <?php if($requester == 'synthesis'):?>
          <?php foreach ($metadata as $mid => $data) : ?>
          	<th><?php echo $data->getName(); ?></th>
          <?php endforeach; ?>
          <?php else: ?>
          <?php switch($requester){
			    case 'selection':
			        echo "<th><?php echo __('Qualidade') ?></th><th><?php echo __('Seleção') ?></th>";
			        break;
			    case 'assessment':
			        echo "<th><?php echo __('Qualidade') ?></th><th><?php echo __('Ações') ?></th>";
			        break;
			    /*case 'extraction':
			        echo "<th><?php echo __('Extração dos Dados') ?></th>";
			        break;*/
			    default:
			        echo "<th><?php echo __('Ações') ?></th>";
			        break;
			}?>
          <?php endif;?>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($studies->getResults() as $st) : ?>
        <tr class="<?php echo(($requester == 'selection' && $st[8] === 0)?'warning':''); ?>">
          <td>
          <?php switch($requester){
			    case 'extraction':
			    	if($st[7] <= 0) {
			    		echo '<i class="icon-star-empty"></i>';
			    	} else if($st[7] < $st[8]) {
			    		echo '<i class="icon-star-half-full"></i>';
			    	} else {
			    		echo '<i class="icon-star"></i>';
			    	}
			        break;
			    case 'assessment':
			    	if($st[7]) {
			    		echo '<i class="icon-ok-sign"></i>';
			    	} else {
			    		echo '<i class="icon-circle-blank"></i>';
			    	}
			    	break;
			    case 'selection':
			    	if($st[8] === 0) {
			    		//echo '<button class="btn activateModal" data-study="' . $st[0] . '" data-review="' . $review_id .'">';
			    		echo '<i class="icon-exclamation-sign" title="'.__('divergências encontradas na seleção').'"></i>';
			    		//echo '</button>';
			    	} else if(empty($st[8])) {
			    		echo '<i class="icon-circle-blank" title="'.__('estudo ainda não selecionado').'"></i>';
			    	} else if($st[8] > 0) {
			    		echo '<i class="icon-plus-sign" title="'.__('estudo incluído').'"></i>';
			    	} else {
			    		echo '<i class="icon-minus-sign" title="'.__('estudo excluído').'"></i>';
			    	}
			    	break;
          }?>
          </td>

          <td><?php echo truncate_text($st[1], 144) ?><br />
            <?php //var_dump($st);die; ?>
            <?php if(!empty($st[2])) : ?>
            <small><a href="<?php echo $st[2] ?>" target="_blank"><i class="icon-share"></i> <?php echo truncate_text($st[2], 50) ?></a></small>
            <?php endif ?>
          </td>

          <?php if($requester == 'selection'):?>
          <td><?php echo $st[7] ? $st[7] : '-' ?></td>
          <td>
            <?php if($st[8] === 0) :?>
              <button class="btn btn-small btn-warning activateModal" data-study="<?php echo $st[0]; ?>" data-review="<?php echo $review_id; ?>">
                <i class="icon-exclamation-sign"></i> <?php echo __('solicitar mediação') ?>
              </button>
            <?php else: ?>
              <?php if(!empty($st[9])) :?>
            	<?php echo __('Divergência solucionada') ?>: "<?php echo $st[9] ?>"
              <?php elseif(!empty($st[6])) :?>
              	<small><a class="selecao_text" data-estudo="<?php echo $st[0]?>" href="#" title="Clique para alterar"><?php echo $criterios[$st[6]]->name ?></a></small>
              <?php endif; ?>
            <?php endif; ?>
            <select class="avaliar <?php echo $st[6] ? 'hide' : '' ?>" data-estudo="<?php echo $st[0]?>">
              <option value="0">Selecione</option>
              <?php foreach($criterios as $id => $c): ?>
                <option value='<?php echo $id ?>' <?php echo $st[6]==$id ? 'selected="selected"':''?> >
                  <?php echo $c->type
                    ? '<i class="icon-plus-sign" title="Estudo Incluído"></i>'
                    : '<i class="icon-minus-sign" title="Estudo Excluído"></i>'; ?>
                  <?php echo ($c->type ? 'I - ' : 'E - ') . $c->name ?>
                </option>
              <?php endforeach;?>
              </select>
          </td>
          <?php endif;?>

          <?php if($requester == 'assessment'):?>
          <td><?php echo $st[7] ? $st[7] : '-' ?></td>
          <td class="ctrls">
          	<?php if($showActions): ?>
          	<div class="btn-group">
          		<button type="button" class="btn btn-mini btn-info activateModal" data-study="<?php echo $st[0] ?>" data-review="<?php echo $review_id ?>"><i class="icon-thumbs-up"></i> <?php echo __('avaliar') ?></button>
          	</div>
          	<?php endif;?>
          </td>
          <?php endif;?>

          <?php if($requester == 'extraction'):?>
          <td class="ctrls">
          	<div class="btn-group">
          		<button type="button" class="dataExtration btn btn-mini btn-info" data-toggle="modal" data-study_id="<?php echo $st[0]?>" data-target="#dataExtrationModal" href="<?php //echo url_for("answer/form?study_id={$st[0]}&review_id={$review_id}")?>"><i class="icon-sitemap"></i> <?php echo __('extrair dados') ?></button>
          	</div>
          </td>
          <?php endif; ?>

          <?php if($requester == 'synthesis'):?>

          <?php foreach ($metadata as $mid => $data) : ?>
          	<td>
          		<?php
          		@preg_match('/'. $data->getId() . ':([^,]*)/', $st[5], $rs);
          		if(!empty($rs)) {
          			if($data->getType() == 2)
          			{
          				$choices = explode(',', $data->getDescription());
          				echo $choices[$rs[1]];
          			} else {
          				echo $rs[1];
          			}
          		}
          		?>
          	</td>
          <?php endforeach; ?>
          <?php endif; ?>

          <?php if($requester == 'identification'):?>
          <td class="ctrls">
            <div class="btn-group">
              <?php echo link_to('<i class="icon-pencil"></i> editar', 'study/edit?id=' . $st[0], array ('class' => 'btn btn-mini btn-info')) ?>
              <a class="btn btn-mini btn-danger" href="#" remove-name='<?php echo str_replace("'",'',$st[1]) ?>' remove-link="<?php echo url_for('study/delete?id=' . $st[0])?>"><i class="icon-remove-sign"></i> <?php echo __('excluir') ?></a>
            </div>
          </td>
          <?php endif; ?>

        </tr>
      <?php endforeach; ?>

        <?php switch($requester){
		    case 'extraction':
		    	$colspan = 3;
		    	break;
		    case 'synthesis':
		      if(!empty($metadata)):
        		$colspan = count($metadata)+2;
              else:
        		$colspan = 2;
              endif;
		      break;
		    default:
		      $colspan = 4;
          }?>

      <?php if (!$studies->getNbResults()): ?>
        <tr class="info">
          <td colspan="<?php echo $colspan; ?>" class="emptyCell text-center"><?php echo link_to('<strong>'.__('Atenção').'!</strong> '.__('Nenhum estudo cadastrado para esta revisão sistemática. Clique aqui para adicionar.'), '@studies_identification?id='.$review_id.'#new', array('style' => 'display:block;')) ?></td>
        </tr>
      <?php endif; ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="<?php echo $colspan; ?>">
					<!-- TODO: rever com Pedro -->
          <?php if($requester == 'identification' || $requester == 'selection'): ?>
            <?php echo format_number_choice('[0]nenhum estudo cadastrado|[1]um estudo cadastrado|(1,Inf]%1% estudos cadastrados / exibindo 20 por página', array ('%1%' => $studies->getNbResults()), $studies->getNbResults()) ?>
          <?php else: ?>
            <?php echo format_number_choice('[0]nenhum estudo cadastrado|[1]um estudo selecionado|(1,Inf]%1% estudos selecionados / exibindo 20 por página', array ('%1%' => $studies->getNbResults()), $studies->getNbResults()) ?>
          <?php endif; ?>
          </th>
        </tr>
      </tfoot>
    </table>
    
    <?php $url = "study/{$actionName}?id={$review_id}&page=" ?>
    <?php $url .= empty($title) ? '' : '&title='.$title ?>
    <?php $url .= empty($filter) ? '' : '&filter='.$filter ?>
    <?php echo form_pager_display($studies, $url . '&page='); ?>