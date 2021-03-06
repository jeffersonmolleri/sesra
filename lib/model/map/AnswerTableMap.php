<?php


/**
 * This class defines the structure of the 'answers' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Thu Aug 22 18:28:57 2013
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AnswerTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AnswerTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('answers');
		$this->setPhpName('Answer');
		$this->setClassname('Answer');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('QUESTION_ID', 'QuestionId', 'INTEGER' , 'questions', 'ID', true, null, null);
		$this->addForeignPrimaryKey('STUDY_ID', 'StudyId', 'INTEGER' , 'studies', 'ID', true, null, null);
		$this->addColumn('ANSWER', 'Answer', 'LONGVARCHAR', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('DELETED_AT', 'DeletedAt', 'TIMESTAMP', false, null, null);
		$this->addForeignKey('CREATED_BY', 'CreatedBy', 'INTEGER', 'sf_guard_user', 'ID', true, null, null);
		$this->addForeignKey('UPDATED_BY', 'UpdatedBy', 'INTEGER', 'sf_guard_user', 'ID', true, null, null);
		$this->addForeignKey('DELETED_BY', 'DeletedBy', 'INTEGER', 'sf_guard_user', 'ID', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Question', 'Question', RelationMap::MANY_TO_ONE, array('question_id' => 'id', ), null, null);
    $this->addRelation('Study', 'Study', RelationMap::MANY_TO_ONE, array('study_id' => 'id', ), null, null);
    $this->addRelation('sfGuardUserRelatedByCreatedBy', 'sfGuardUser', RelationMap::MANY_TO_ONE, array('created_by' => 'id', ), 'CASCADE', null);
    $this->addRelation('sfGuardUserRelatedByUpdatedBy', 'sfGuardUser', RelationMap::MANY_TO_ONE, array('updated_by' => 'id', ), 'CASCADE', null);
    $this->addRelation('sfGuardUserRelatedByDeletedBy', 'sfGuardUser', RelationMap::MANY_TO_ONE, array('deleted_by' => 'id', ), 'CASCADE', null);
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
			'symfony_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // AnswerTableMap
