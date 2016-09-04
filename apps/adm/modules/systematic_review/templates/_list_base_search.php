<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>
<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo __('Nome') ?>*</th>
				<th><?php echo __('URL') ?>*</th>
				<!-- <th style="width: 60%;"><?php echo __('APIs') ?> *</th> -->
				<th><?php echo __('Ações') ?> </th>
			</tr>
		</thead>
		<tbody>
			<tr class="success">
				<td>
					<input type="text" name="base_search_name" id="base_search_name" class="input-xlarge" />
				</td>
				<td>
					<input type="text" name="base_search_url" id="base_search_url" class="input-xlarge" />
				</td>
				<!-- <td>
					<input type="text" name="base_search_api" id="base_search_api" />
				</td>								-->
				<td> <a id="search_base_button" class="btn btn-success"><i class="icon-plus-sign"></i> <?php echo __('Adicionar') ?></a> </td>
			</tr>
      <?php if($search_bases_protocol) : ?>
        <?php foreach($search_bases_protocol as $x => $base) :?>
        <?php isset($rsl_id) ? $rsl_id = $rsl_id : $rsl_id = $form->getObject()->getRslId();?>
        <?php isset($protocol_id) ? $protocol_id = $protocol_id : $protocol_id = $form->getObject()->getId();?>
          <?php if($x == 0 || $x % 3 == 0) : ?>
          <?php echo '<div>';?>
          <?php endif;?>
          <tr>
            <td><label for="base_<?php echo $base->getId()?>" class="checkbox"><input id="base_<?php echo $base->getId()?>" name="base[]" <?php echo $base->hasChecked($protocol_id, $rsl_id) ? 'checked="checked"' : '' ?> type="checkbox" value="<?php echo $base->getId()?>"><?php echo $base->getName()?></label></td>
            <td><a href="<?php echo $base->getURL()?>" target="_blank"><?php echo $base->getURL()?></a></td>
            <td class="ctrls">
            <a id="base_search_delete_<?php echo $base->getId()?>" class="btn btn-mini btn-danger base_search_delete" value="<?php echo $base->getId()?>"><i class="icon-remove-sign"></i> <?php echo __('remover') ?></a></td>
          </tr>
          <?php if($x % 3 == 2) : ?>
            <?php echo '</div>'?>
          <?php endif;?>
        <?php endforeach;?>
      <?php endif;?>
			<?php if (!$search_bases_protocol) : ?>
				<tr>
					<td colspan="5"><?php echo __('Nenhuma base de dados alternativa foi cadastrada') ?></td>
				</tr>
			<?php endif; ?>
		</tbody>
    <tfoot>
      <tr><td colspan="3"></td></tr>
    </tfoot>
	</table>
