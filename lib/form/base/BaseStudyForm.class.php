<?php

/**
 * Study form base class.
 *
 * @method Study getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseStudyForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'title'                => new sfWidgetFormInputText(),
      'study_abstract'       => new sfWidgetFormTextarea(),
      'url'                  => new sfWidgetFormInputText(),
      'publication_date'     => new sfWidgetFormDate(),
      'bibtex'               => new sfWidgetFormTextarea(),
      'base_id'              => new sfWidgetFormPropelChoice(array('model' => 'SearchBase', 'add_empty' => false)),
      'systematic_review_id' => new sfWidgetFormPropelChoice(array('model' => 'SystematicReview', 'add_empty' => false)),
      'casting_vote'         => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'deleted_at'           => new sfWidgetFormDateTime(),
      'created_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'updated_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'deleted_by'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'answer_list'          => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Question')),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'title'                => new sfValidatorString(array('max_length' => 255)),
      'study_abstract'       => new sfValidatorString(array('required' => false)),
      'url'                  => new sfValidatorString(array('max_length' => 500)),
      'publication_date'     => new sfValidatorDate(array('required' => false)),
      'bibtex'               => new sfValidatorString(array('required' => false)),
      'base_id'              => new sfValidatorPropelChoice(array('model' => 'SearchBase', 'column' => 'id')),
      'systematic_review_id' => new sfValidatorPropelChoice(array('model' => 'SystematicReview', 'column' => 'id')),
      'casting_vote'         => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'created_at'           => new sfValidatorDateTime(array('required' => false)),
      'updated_at'           => new sfValidatorDateTime(array('required' => false)),
      'deleted_at'           => new sfValidatorDateTime(array('required' => false)),
      'created_by'           => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'           => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'           => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'answer_list'          => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Question', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('study[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Study';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['answer_list']))
    {
      $values = array();
      foreach ($this->object->getAnswers() as $obj)
      {
        $values[] = $obj->getQuestionId();
      }

      $this->setDefault('answer_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveAnswerList($con);
  }

  public function saveAnswerList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['answer_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(AnswerPeer::STUDY_ID, $this->object->getPrimaryKey());
    AnswerPeer::doDelete($c, $con);

    $values = $this->getValue('answer_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Answer();
        $obj->setStudyId($this->object->getPrimaryKey());
        $obj->setQuestionId($value);
        $obj->save();
      }
    }
  }

}
