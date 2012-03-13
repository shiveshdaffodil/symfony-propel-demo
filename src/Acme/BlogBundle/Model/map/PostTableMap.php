<?php

namespace Acme\BlogBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'posts' table.
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
class PostTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src.Acme.BlogBundle.Model.map.PostTableMap';

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
		$this->setName('posts');
		$this->setPhpName('Post');
		$this->setClassname('Acme\\BlogBundle\\Model\\Post');
		$this->setPackage('src.Acme.BlogBundle.Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('TITLE', 'Title', 'VARCHAR', true, 255, null);
		$this->getColumn('TITLE', false)->setPrimaryString(true);
		$this->addColumn('SLUG', 'Slug', 'VARCHAR', true, 255, null);
		$this->addColumn('EXCERPT', 'Excerpt', 'LONGVARCHAR', true, null, null);
		$this->addColumn('CONTENT', 'Content', 'LONGVARCHAR', true, null, null);
		$this->addColumn('PUBLISHED', 'Published', 'BOOLEAN', true, 1, false);
		$this->addColumn('LOCKED', 'Locked', 'BOOLEAN', true, 1, false);
		$this->addForeignKey('CREATED_BY', 'CreatedBy', 'INTEGER', 'users', 'ID', true, null, null);
		$this->addForeignKey('PUBLISHED_BY', 'PublishedBy', 'INTEGER', 'users', 'ID', false, null, null);
		$this->addColumn('LOCKED_BY', 'LockedBy', 'INTEGER', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('UserRelatedByCreatedBy', 'Acme\\BlogBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('created_by' => 'id', ), 'CASCADE', 'CASCADE');
		$this->addRelation('UserRelatedByPublishedBy', 'Acme\\BlogBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('published_by' => 'id', ), 'CASCADE', 'CASCADE');
		$this->addRelation('Comment', 'Acme\\BlogBundle\\Model\\Comment', RelationMap::ONE_TO_MANY, array('id' => 'post_id', ), 'CASCADE', 'CASCADE', 'Comments');
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
			'sluggable' => array('slug_column' => 'slug', 'slug_pattern' => '', 'replace_pattern' => '/[^\\pL\\d]+/u', 'replacement' => '-', 'separator' => '-', 'permanent' => 'false', ),
		);
	} // getBehaviors()

} // PostTableMap
