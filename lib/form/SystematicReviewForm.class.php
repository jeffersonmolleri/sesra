<?php

/**
 * SystematicReview form.
 *
 * @package    mestrado
 * @subpackage form
 * @author     Your name here
 */
class SystematicReviewForm extends BaseSystematicReviewForm
{
  public function configure()
  {

    if (!$this->isNew()) {
      $c = new Criteria();
      $c->add(ProtocolPeer::RSL_ID, $this->getObject()->getId());
      $protocol = ProtocolPeer::doSelectOne($c);
    }
    else {
      $protocol = new Protocol();
      $protocol->setFrameworkId(FrameworkPeer::FRAMEWORK_KITCHENHAM);
    }
    //var_dump($protocol);die;
    
    $protocol->setSystematicReview($this->getObject());

    $this->embedForm('protocol', new ProtocolForm($protocol));

    unset(
        $this['created_by'],
        $this['updated_by'],
        $this['deleted_by'],
        $this['created_at'],
        $this['updated_at'],
        $this['deleted_at']
    );


  }

 /**
  * @param array $taintedValues
  * @param array $taintedFiles
  * @throws InvalidArgumentException
  */
 public function bind(array $taintedValues = null, array $taintedFiles = null) {
  // TODO: Auto-generated method stub
    $taintedValues['restrict'] = @!$taintedValues['restrict'];
    parent::bind($taintedValues, $taintedFiles);
 }

}
