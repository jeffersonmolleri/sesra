<div style="background-color: #1B1B1B; background-image: linear-gradient(to bottom, #222222, #111111); background-repeat: repeat-x;color: #999999; display: table; width:100%; padding: 10px 20px;">
  <a title="ARS - Automatização de Revisões Sistemáticas" href="http://ars.enova.com.br" style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; text-decoration: none; color: #999; font-size: 18px;">ARS - <?php echo __('Automatização de Revisões Sistemáticas') ?></a>
</div>

<div style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color: #333333; font-size:14px; line-height:20px; padding: 0 20px;">

  <h3><?php echo __('Caro(a) Pesquisador(a)') ?>,</h3>

  <p><?php $name = $inviter->getProfile()->getName(); $title = $review->getTitle(); $role = $level;	echo __('Você foi convidado por %c1% a ingressar a ferramenta ARS - Automatização de Revisões Sistemáticas e participar da revisão sistemática %c2% como %c3%', array('%c1%' => empty($name) ? __('Usuário') : $name, '%c2%' => empty($title) ? __('sem nome') : $title, '%c3%' => empty($role) ? __('interessado') : $role)) ?>.</p>

  <p><a title="ARS - Automatização de Revisões Sistemáticas" href="<?php echo url_for('@editme?id=' . $profile->getUserId() . '&token=' . $token, true); ?>" style="background-color: #5BB75B; background-image: linear-gradient(to bottom, #62C462, #51A351); background-repeat: repeat-x; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3; border-radius: 4px 4px 4px 4px; border-style: solid; border-width: 1px; box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05); color: #ffffff; cursor: pointer; display: inline-block; margin-bottom: 0; padding: 4px 14px; text-align: center; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.25); vertical-align: middle; text-decoration: none;"><?php echo __('Cadastre-se e participe'); ?></a> <?php echo __('ou'); ?> <a href="<?php echo url_for('@negate?id=' . $profile->getUserId() . '&rsl_id=' . $review->getId(), true); ?>"><?php echo __('recuse'); ?></a> <?php echo __('sua participação neste estudo'); ?>.
  </p>

</div>
<div style="margin-top: 20px; border-top: 5px solid #EFEFEF; padding-top: 4px;">&nbsp;</div>
<div style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color: #333333; font-size:14px; line-height:20px; padding: 0 20px;">

  <h3><?php echo __('Sobre a Ferramenta'); ?></h3>

  <p><?php echo __('O'); ?> <abbr title="<?php echo __('Automatização de Revisões Sistemáticas'); ?>">ARS</abbr> <?php echo __('é uma abordagem automatizada de apoio ao processo de Revisão Sistemática da Literatura a pesquisadores na área de engenharia de software'); ?>.<br /><?php echo __('A ferramenta utiliza o modelo de processo proposto por Kitchenham e Charters (2007) e permite a condução do processo de acordo com um modelo de negócios definido'); ?>.<br />
    <a title="ARS - Automatização de Revisões Sistemáticas" href="<?php echo url_for('@homepage', true) ?>" style="background-color: #F5F5F5; background-image: linear-gradient(to bottom, #FFFFFF, #E6E6E6); background-repeat: repeat-x; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3; border-radius: 4px 4px 4px 4px; border-style: solid; border-width: 1px; box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05); color: #333333; cursor: pointer; display: inline-block; margin-bottom: 0; padding: 4px 14px; text-align: center; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75); vertical-align: middle; text-decoration: none;"><?php echo __('Saiba mais'); ?></a>
  </p>
</div>

<div style="margin-top: 20px; border-top: 5px solid #EFEFEF; padding-top: 4px;">&nbsp;</div>