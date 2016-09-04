<table class="table table-striped">
	<thead>
		<th><?php echo __('Critério') ?></th>
		<th><?php echo __('Respostas') ?></th>
		<th><?php echo __('Valores') ?></th>
	</thead>
	<tbody>
		<tr class="success">
			<td>
				<input type="text" name="question[description]" id="question_description" />
			</td>
			<td>
				<select id="tipo">
					<option value="logico" selected="selected"><?php echo __('Lógico (sim/não)') ?></option>
					<option value="variavel"><?php echo __('Conjunto de valores') ?></option>
				</select>
      </td>
      <td>
				<input type="text" name="question[answer_type]" id="question_answer_type" />
			</td>
			<td><a id="question_add" class="btn btn-success"><i class="icon-plus-sign"></i> <?php echo __('adicionar') ?></a> </td>
		</tr>
	<?php if (!empty($questions)) : ?>
		<?php foreach($questions as $question) :?>
			<tr>
				<td>
					<?php echo $question->getDescription();?>
				</td>
				<td colspan="2">
					<?php echo $question->getAnswerType()=='logico'?__('lógico (sim, não)'):__('conjunto de valores').' ('.$question->getAnswerType().')';?>
				</td>
				<td class="ctrls">
          			<a href="#" class="btn btn-mini btn-danger question_delete" data-id="<?php echo $question->getId()?>"><i class="icon-remove-sign"></i> <?php echo __('excluir') ?></a>
				</td>
			</tr>
		<?php endforeach;?>
	<?php else : ?>
		<tr>
			<td colspan="4"><?php echo __('Nenhum critério cadastrado') ?></td>
		</tr>
	<?php endif; ?>
	</tbody>
</table> 