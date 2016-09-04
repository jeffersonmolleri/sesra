<?php //if (!empty($criterias)) : ?>
  	<!--<h3>Critérios</h3>-->
    <table class="table table-striped">
  		<thead>
        <tr>
          <th><?php echo __('I/E') ?></th>
          <th><?php echo __('Nome') ?></th>
          <th><?php echo __('Ações') ?></th>
        </tr>
  		</thead>
  		<tbody>
        <tr class="success">
          <td><select id="type" name="type">
              <option selected="selected" value="true"><?php echo __('Inclusão') ?></option>
              <option value="false"><?php echo __('Exclusão') ?></option>
            </select>
          </td>
          <td><input type="text" id="name" name="name" class="input-xxlarge"></td>
          <td><a id="add_criteria" class="btn btn-success"><i class="icon-plus-sign"></i> <?php echo __('Adicionar') ?></a> </td>
        </tr>
  		<?php foreach ($criterias as $criteria) : ?>
  			<tr class="<?php //echo ($criteria->getType())?'info':'warning'; ?>">
  				<td><?php echo ($criteria->getType())?'<span class="badge badge-success"><small><i class="icon-plus-sign" title="'. __('Critério de Inclusão').'"></i>'. __('Inclusão').'</small></span>':'<span class="badge badge-important"><small><i class="icon-minus-sign" title="'.__('Critério de Exclusão').'"></i>'.__('Exclusão').'</small></span>'; ?></td>
  				<td><?php echo $criteria->getName(); ?></td>
  				<td class="ctrls"><?php echo link_to('<i class="icon-remove-sign"></i> remover', 'systematic_review/deleteCriteria?id=' . $criteria->getId(), array ('class' => 'btn btn-mini btn-danger', 'title' => __('Excluir'), 'data-context' => 'rem-criteria')) ?></td>
  			</tr>
  		<?php endforeach; ?>
      </tbody>
  	</table>
 <?php //endif; ?>