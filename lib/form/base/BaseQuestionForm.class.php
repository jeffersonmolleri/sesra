<?php

/**
 * Question form base class.
 *
 * @method Question getObject() Returns the current form's model object
 *
 * @package    mestrado
 * @subpackage form
 * @author     Jefferson Seide Molléri
 */
abstract class BaseQuestionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'questionnaire_id' => new sfWidgetFormPropelChoice(array('model' => 'Questionnaire', 'add_empty' => false)),
      'description'      => new sfWidgetFormTextarea(),
      'answer_type'      => new sfWidgetFormTextarea(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'deleted_at'       => new sfWidgetFormDateTime(),
      'created_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'updated_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'deleted_by'       => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'answer_list'      => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Study')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'questionnaire_id' => new sfValidatorPropelChoice(array('model' => 'Questionnaire', 'column' => 'id')),
      'description'      => new sfValidatorString(),
      'answer_type'      => new sfValidatorString(),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'deleted_at'       => new sfValidatorDateTime(array('required' => false)),
      'created_by'       => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'updated_by'       => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'deleted_by'       => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'answer_list'      => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Study', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('question[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Question';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['answer_list']))
    {
      $values = array();
      foreach ($this->object->getAnswers() as $obj)
      {
        $values[] = $obj->getStudyId();
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
    $c->add(AnswerPeer::QUESTION_ID, $this->object->getPrimaryKey());
    AnswerPeer::doDelete($c, $con);

    $values = $this->getValue('answer_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Answer();
        $obj->setQuestionId($this->object->getPrimaryKey());
        $obj->setStudyId($value);
        $obj->save();
      }
    }
  }

}
