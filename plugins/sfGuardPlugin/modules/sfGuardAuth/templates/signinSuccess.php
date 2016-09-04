<?php use_helper('enWidgets', 'Feedback','enMessageBox') ?>
<div id="sf_guard_auth_form">
	<form class="form-signin span7" action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
		<h2 class="form-signin-heading"><?php echo __('Faça seu Login') ?></h2>
		<?php echo form_errors_display($form) ?>
		<?php echo $form['username']->render(array('class'=>'input-block-level','placeholder'=>__('usuário'))) ?>
		<div class="input-append">
			<?php echo $form['password']->render(array('class'=>'span3','placeholder'=>__('senha'))) ?>
			<a href="#" id="passrec" title="<?php echo __('Esqueceu sua senha?') ?>" class="btn"><i class="icon-question-sign icon-2x"></i></a>
		</div>
		<label class="checkbox" for="signin_remember">
			<?php echo $form['remember']->render(array('class'=>'radio')) ?> <?php echo __('Mantenha-me conectado') ?><br />
			<!--<small>(desmarque caso esteja em um computador compartilhado)</small>-->
		</label>
		<button class="btn btn-large btn-success" type="submit"><i class="icon-signin icon-white"></i> <?php echo __('Entrar') ?></button> <?php echo __('ou') ?> <a href="<?php echo url_for('@sf_guard_join'); ?>"><?php echo __('cadastre-se') ?></a>
	</form>
</div>

<script type="text/javascript">
$(document).ready(function () {
	$('#passrec').on('click', function (e) {
		e.preventDefault();
		$('#passrec-response').html('');
		$('#passrec-close').hide();
		$('#passrec-send').show();
		$("#passrec-form").show();
		$('#email').val('');
        $("div.modal-body h4").hide();
		$('#passrec-modal').modal();
	});

	$("#passrec-send").on('click', function (e) {
		e.preventDefault();
		var $email = $('#email').val();
		$("#passrec-form").hide()
	    $("div.modal-body h4").show();
	    $.ajax({
		    url: '<?php echo url_for('sfGuardAuth/retrieveNewToken') ?>',
		    data: { email: $email }
	    });
	});
});
</script>