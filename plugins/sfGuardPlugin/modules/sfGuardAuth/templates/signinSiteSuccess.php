	<?php use_helper('Object' , 'enWidgets', 'Feedback', 'enMessageBox') ?>
	<div id="sf_guard_auth_form">
	  <form class="yform yellow_box" action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
	    <fieldset class="columnar">
	      <legend><?php echo __('Faça seu Login') ?></legend>
	      <br />
	      <?php echo form_errors_display($form) ?>
	      <div class="type-text">
	        <label><strong><?php echo __('Login') ?>:</strong></label>
	        <?php echo $form['username']->render() ?> </div>
	      <div class="type-text">
	        <label><strong><?php echo __('Senha') ?>:</strong></label>
	        <?php echo $form['password']->render() ?> </div>
	      <div class="form-row radio type-check" id="sf_guard_auth_remember"> <?php echo $form['remember']->render(array('class'=>'radio')) ?>
	        <label for="signin_remember"> <strong><?php echo __('Lembrar-me') ?></strong> </label>
	        <!--<small>(desmarque caso esteja em um computador compartilhado)</small>--> </div>
	      <button id="commit" type="submit"><span><?php echo __('Entrar') ?></span></button>
	    </fieldset>
	  </form>
	</div>