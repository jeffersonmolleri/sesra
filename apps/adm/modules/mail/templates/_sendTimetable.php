<?php use_helper('Date') ?>
<div style="background-color: #1B1B1B; background-image: linear-gradient(to bottom, #222222, #111111); background-repeat: repeat-x;color: #999999; display: table; width:100%; padding: 10px 20px;">
  <a title="ARS - Automatização de Revisões Sistemáticas" href="http://ars.enova.com.br" style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; text-decoration: none; color: #999; font-size: 18px;">ARS - <?php echo __('Automatização de Revisões Sistemáticas') ?></a>
</div>

<div style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color: #333333; font-size:14px; line-height:20px; padding: 0 20px;">

  <h3><?php echo __('Caro(a) Pesquisador(a)') ?>,</h3>

  <p><?php $title = $review->getTitle(); echo __('O cronograma da revisão sistemática <b>%c1%</b> foi atualizado e as seguintes tarefas podem requerer a sua atenção', array('%c1%' => empty($title) ? __('sem nome') : $title)) ?>:</p>

  <table style="width: 100%; color: #333333; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; line-height: 20px;">
    <thead>
      <tr>
  	    <th style="background-color: #F9F9F9; border-top: 1px solid #DDDDDD; line-height: 20px; padding: 8px; text-align: left; vertical-align: top;"><?php echo __('Tarefa') ?></th>
  	    <th style="background-color: #F9F9F9; border-top: 1px solid #DDDDDD; line-height: 20px; padding: 8px; text-align: left; vertical-align: top;"><?php echo __('Data') ?></th>
  	    <th style="background-color: #F9F9F9; border-top: 1px solid #DDDDDD; line-height: 20px; padding: 8px; text-align: left; vertical-align: top;"><?php echo __('Responsável') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php $root = 0; $child = 0; foreach($activities as $ac) : if ($ac->getActivityParent() == null) { $root++; $child = 0; } else { $child++; } $job = $ac->getCachedJobs(); ?>
      <tr>
        <td style="background-color: #F9F9F9; border-top: 1px solid #DDDDDD; line-height: 20px; padding: 8px; text-align: left; vertical-align: top;"><?php echo ($root + $child / 10), '. ', $ac->getNamePt(); ?></td>
        <td style="background-color: #F9F9F9; border-top: 1px solid #DDDDDD; line-height: 20px; padding: 8px; text-align: left; vertical-align: top;"><?php !empty($job[0]) and print format_date($job[0]->getDate(), 'dd/MM/yyyy') ?></td>
        <td style="background-color: #F9F9F9; border-top: 1px solid #DDDDDD; line-height: 20px; padding: 8px; text-align: left; vertical-align: top;"><?php !empty($job[0]) and print $job[0]->getUserIdProfile()->getName(); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <p><a title="Acessar o Protocolo" href="<?php echo url_for('systematic_review/protocols?id=' . $review->getId(), true); ?>" style="background-color: #5BB75B; background-image: linear-gradient(to bottom, #62C462, #51A351); background-repeat: repeat-x; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3; border-radius: 4px 4px 4px 4px; border-style: solid; border-width: 1px; box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05); color: #ffffff; cursor: pointer; display: inline-block; margin-bottom: 0; padding: 4px 14px; text-align: center; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.25); vertical-align: middle; text-decoration: none;"><?php echo __('Acessar o Protocolo') ?></a> <?php echo __('da revisão sistemática') ?>.
  </p>

</div>
<div style="margin-top: 20px; border-top: 5px solid #EFEFEF; padding-top: 4px;">&nbsp;</div>