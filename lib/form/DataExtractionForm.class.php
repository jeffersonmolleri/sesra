<?php

/**
 * DataExtraction form.
 *
 * @package    mestrado
 * @subpackage form
 * @author     Your name here
 */
class DataExtractionForm extends BaseDataExtractionForm
{
  public function configure()
  {
    unset(
        $this['created_by'],
        $this['updated_by'],
        $this['deleted_by'],
        $this['created_at'],
        $this['updated_at'],
        $this['deleted_at']
    );
  }
}
