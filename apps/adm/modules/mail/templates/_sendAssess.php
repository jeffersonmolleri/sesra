<div style="background-color: #1B1B1B; background-image: linear-gradient(to bottom, #222222, #111111); background-repeat: repeat-x;color: #999999; display: table; width:100%; padding: 10px 20px;">
  <a title="<?php echo __('Solucionar Divergências na Seleção de Estudos') ?>" href="http://ars.enova.com.br" style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; text-decoration: none; color: #999; font-size: 18px;">ARS - <?php echo __('Automatização de Revisões Sistemáticas') ?></a>
</div>

<div style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color: #333333; font-size:14px; line-height:20px; padding: 0 20px;">

  <h3><?php $name = $profile->getName(); echo __('Caro %c1%', array('%c1%' => empty($name) ? __('Usuário') : $name)) ?>,</h3>
  
  <p><?php echo __('Durante a etapa de seleção dos estudos da revisão sistemática %c1%, surgiu uma divergência entre os pesquisadores.<br /> Você foi convidado a solucionar este impasse como mediador', array('%c1%' => $review->getTitle()) ?>.</p>

  <p><a title="<?php echo __('Solucionar Divergências na Seleção de Estudos') ?>" href="<?php echo url_for('study/desempatarAvaliacao?study_id=' . $study->getId() . '&review_id=' . $review->getId(), true); ?>" style="background-color: #5BB75B; background-image: linear-gradient(to bottom, #62C462, #51A351); background-repeat: repeat-x; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3; border-radius: 4px 4px 4px 4px; border-style: solid; border-width: 1px; box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05); color: #ffffff; cursor: pointer; display: inline-block; margin-bottom: 0; padding: 4px 14px; text-align: center; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.25); vertical-align: middle; text-decoration: none;"><?php echo __('Participe da resolução') ?></a>
  </p>

</div>
<div style="margin-top: 20px; border-top: 5px solid #EFEFEF; padding-top: 4px;">&nbsp;</div>
