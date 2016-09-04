<?php use_helper('myWidgets', 'enMessageBox','Feedback', 'Date'); ?>
<?php //echo update_message(__('Metadado cadastrado com sucesso'), __('O cadastro do metadado falhou')) ?>
<table class="table table-striped">
		<thead>
		<tr>
			<th><?php echo __('Metadado') ?>*</th>
			<th><?php echo __('Tipo') ?>*</th>
			<th><?php echo __('Valores') ?></th>
			<th><?php echo __('Ações') ?></th>
		</tr>
		</thead>
		<tbody>
			<tr class="success">
				<td>
					<input type="text" name="metadata_name" id="metadata_name" class="input-xlarge" />
				</td>
				<td>
					<select name="metadata_type" id="metadata_type">
							<option value="<?php echo Metadata::TEXTO ?>"><?php echo __('Texto') ?></option>
							<option value="<?php echo Metadata::NUMERO ?>"><?php echo __('Número') ?></option>
							<option value="<?php echo Metadata::CATEGORIAS ?>"><?php echo __('Categorias') ?></option>
							<option value="<?php echo Metadata::BIBTEX ?>"><?php echo __('BibTeX') ?></option>
					</select>
				</td>
				<td>
					<input type="text" name="metadata_categories" id="metadata_categories" class="span6" />
					<select id="metadata_bibtex_field" name="metadata_bibtex_field">
					<?php $fields = sfConfig::get('app_bibtex_fields'); foreach ($fields as $field) : ?>
						<option value="<?php echo $field ?>"><?php echo $field ?></option>
					<?php endforeach; ?>
					</select>
				</td>
				<td><a id="metadata_button" class="btn btn-success"><i class="icon-plus-sign"></i> <?php echo __('Adicionar') ?></a></td>
			</tr>
			<?php if (!empty($metadata_list)) : ?>
				<?php foreach($metadata_list as $metadata) :?>
					<tr>
						<td>
							<?php echo $metadata->getName();?>
						</td>
						<td>
						<?php switch ($metadata->getType()) : case Metadata::BIBTEX : ?>
							<?php echo __('BibTeX') ?>
						<?php break; case Metadata::NUMERO :?>
							<?php echo __('Número') ?>
						<?php break; case Metadata::CATEGORIAS :?>
							<?php echo __('Categorias') ?>
						<?php break; default :?>
							<?php echo __('Texto') ?>
						<?php break; endswitch;?>
						</td>
						<td>
							<?php echo $metadata->getDescription();?>
						</td>
						<td class="ctrls">
						<a id="metadata_button_<?php echo $metadata->getId()?>" class="btn btn-mini btn-danger metadata_delete" value="<?php echo $metadata->getId()?>"><i class="icon-remove-sign"></i> <?php echo __('remover') ?></a>
						</td>
					</tr>
				<?php endforeach;?>
			<?php else : ?>
				<tr>
					<td colspan="5"><?php echo __('Nenhum metadado cadastrado') ?></td>
				</tr>
			<?php endif; ?>
		</tbody>
		<tfoot>
      <tr><td colspan="4">&nbsp;</td></tr>
		</tfoot>
	</table>