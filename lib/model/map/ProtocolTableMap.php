<?php


/**
 * This class defines the structure of the 'protocols' table.
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
class ProtocolTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ProtocolTableMap';

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
		$this->setName('protocols');
		$this->setPhpName('Protocol');
		$this->setClassname('Protocol');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		$this->setPrimaryKeyMethodInfo('protocols_id_seq');
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('OBJECTIVE', 'Objective', 'LONGVARCHAR', false, null, null);
		$this->addColumn('POPULATION', 'Population', 'LONGVARCHAR', false, null, null);
		$this->addColumn('INTERVENTION', 'Intervention', 'LONGVARCHAR', false, null, null);
		$this->addColumn('COMPARATIVE', 'Comparative', 'LONGVARCHAR', false, null, null);
		$this->addColumn('OUTCOME', 'Outcome', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CONTEXT', 'Context', 'LONGVARCHAR', false, null, null);
		$this->addColumn('SEARCH_STRING', 'SearchString', 'LONGVARCHAR', false, null, null);
		$this->addColumn('METODOLOGY', 'Metodology', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ASSESSMENT', 'Assessment', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATA_EXTRACTION', 'DataExtraction', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DATA_ANALISYS', 'DataAnalisys', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DISSEMINATION', 'Dissemination', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('DELETED_AT', 'DeletedAt', 'TIMESTAMP', false, null, null);
		$this->addForeignKey('RSL_ID', 'RslId', 'INTEGER', 'systematic_reviews', 'ID', true, null, null);
		$this->addForeignKey('FRAMEWORK_ID', 'FrameworkId', 'INTEGER', 'frameworks', 'ID', true, null, null);
		$this->addColumn('STRATEGY_ID', 'StrategyId', 'INTEGER', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('SystematicReview', 'SystematicReview', RelationMap::MANY_TO_ONE, array('rsl_id' => 'id', ), null, null);
    $this->addRelation('Framework', 'Framework', RelationMap::MANY_TO_ONE, array('framework_id' => 'id', ), null, null);
    $this->addRelation('SystematicReviewSearchBase', 'SystematicReviewSearchBase', RelationMap::ONE_TO_MANY, array('id' => 'protocol_id', ), 'CASCADE', null);
    $this->addRelation('Job', 'Job', RelationMap::ONE_TO_MANY, array('id' => 'protocol_id', ), null, null);
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

} // ProtocolTableMap
