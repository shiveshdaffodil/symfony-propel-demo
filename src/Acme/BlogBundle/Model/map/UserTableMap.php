<?php

namespace Acme\BlogBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'users' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Acme.BlogBundle.Model.map
 */
class UserTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src.Acme.BlogBundle.Model.map.UserTableMap';

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
		$this->setName('users');
		$this->setPhpName('User');
		$this->setClassname('Acme\\BlogBundle\\Model\\User');
		$this->setPackage('src.Acme.BlogBundle.Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('USERNAME', 'Username', 'VARCHAR', false, 255, null);
		$this->getColumn('USERNAME', false)->setPrimaryString(true);
		$this->addColumn('SALT', 'Salt', 'VARCHAR', true, 255, null);
		$this->addColumn('PASSWORD', 'Password', 'VARCHAR', true, 255, null);
		$this->addColumn('ROLES', 'Roles', 'ARRAY', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('PostRelatedByCreatedBy', 'Acme\\BlogBundle\\Model\\Post', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'CASCADE', 'CASCADE', 'PostsRelatedByCreatedBy');
		$this->addRelation('PostRelatedByPublishedBy', 'Acme\\BlogBundle\\Model\\Post', RelationMap::ONE_TO_MANY, array('id' => 'published_by', ), 'CASCADE', 'CASCADE', 'PostsRelatedByPublishedBy');
		$this->addRelation('Comment', 'Acme\\BlogBundle\\Model\\Comment', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'CASCADE', 'CASCADE', 'Comments');
	} // buildRelations()

} // UserTableMap
