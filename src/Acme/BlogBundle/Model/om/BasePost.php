<?php

namespace Acme\BlogBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Acme\BlogBundle\Model\Comment;
use Acme\BlogBundle\Model\CommentQuery;
use Acme\BlogBundle\Model\PostPeer;
use Acme\BlogBundle\Model\PostQuery;
use Acme\BlogBundle\Model\User;
use Acme\BlogBundle\Model\UserQuery;

/**
 * Base class that represents a row from the 'posts' table.
 *
 * 
 *
 * @package    propel.generator.src.Acme.BlogBundle.Model.om
 */
abstract class BasePost extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
	const PEER = 'Acme\\BlogBundle\\Model\\PostPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PostPeer
	 */
	protected static $peer;

	/**
	 * The flag var to prevent infinit loop in deep copy
	 * @var       boolean
	 */
	protected $startCopy = false;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the title field.
	 * @var        string
	 */
	protected $title;

	/**
	 * The value for the slug field.
	 * @var        string
	 */
	protected $slug;

	/**
	 * The value for the excerpt field.
	 * @var        string
	 */
	protected $excerpt;

	/**
	 * The value for the content field.
	 * @var        string
	 */
	protected $content;

	/**
	 * Whether the lazy-loaded $content value has been loaded from database.
	 * This is necessary to avoid repeated lookups if $content column is NULL in the db.
	 * @var        boolean
	 */
	protected $content_isLoaded = false;

	/**
	 * The value for the published field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $published;

	/**
	 * The value for the locked field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $locked;

	/**
	 * The value for the created_by field.
	 * @var        int
	 */
	protected $created_by;

	/**
	 * The value for the published_by field.
	 * @var        int
	 */
	protected $published_by;

	/**
	 * The value for the locked_by field.
	 * @var        int
	 */
	protected $locked_by;

	/**
	 * @var        User
	 */
	protected $aUserRelatedByCreatedBy;

	/**
	 * @var        User
	 */
	protected $aUserRelatedByPublishedBy;

	/**
	 * @var        array Comment[] Collection to store aggregation of Comment objects.
	 */
	protected $collComments;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * An array of objects scheduled for deletion.
	 * @var		array
	 */
	protected $commentsScheduledForDeletion = null;

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->published = false;
		$this->locked = false;
	}

	/**
	 * Initializes internal state of BasePost object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [title] column value.
	 * 
	 * @return     string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Get the [slug] column value.
	 * 
	 * @return     string
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * Get the [excerpt] column value.
	 * 
	 * @return     string
	 */
	public function getExcerpt()
	{
		return $this->excerpt;
	}

	/**
	 * Get the [content] column value.
	 * 
	 * @param      PropelPDO An optional PropelPDO connection to use for fetching this lazy-loaded column.
	 * @return     string
	 */
	public function getContent(PropelPDO $con = null)
	{
		if (!$this->content_isLoaded && $this->content === null && !$this->isNew()) {
			$this->loadContent($con);
		}

		return $this->content;
	}

	/**
	 * Load the value for the lazy-loaded [content] column.
	 *
	 * This method performs an additional query to return the value for
	 * the [content] column, since it is not populated by
	 * the hydrate() method.
	 *
	 * @param      $con PropelPDO (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - any underlying error will be wrapped and re-thrown.
	 */
	protected function loadContent(PropelPDO $con = null)
	{
		$c = $this->buildPkeyCriteria();
		$c->addSelectColumn(PostPeer::CONTENT);
		try {
			$stmt = PostPeer::doSelectStmt($c, $con);
			$row = $stmt->fetch(PDO::FETCH_NUM);
			$stmt->closeCursor();
			$this->content = ($row[0] !== null) ? (string) $row[0] : null;
			$this->content_isLoaded = true;
		} catch (Exception $e) {
			throw new PropelException("Error loading value for [content] column on demand.", $e);
		}
	}
	/**
	 * Get the [published] column value.
	 * 
	 * @return     boolean
	 */
	public function getPublished()
	{
		return $this->published;
	}

	/**
	 * Get the [locked] column value.
	 * 
	 * @return     boolean
	 */
	public function getLocked()
	{
		return $this->locked;
	}

	/**
	 * Get the [created_by] column value.
	 * 
	 * @return     int
	 */
	public function getCreatedBy()
	{
		return $this->created_by;
	}

	/**
	 * Get the [published_by] column value.
	 * 
	 * @return     int
	 */
	public function getPublishedBy()
	{
		return $this->published_by;
	}

	/**
	 * Get the [locked_by] column value.
	 * 
	 * @return     int
	 */
	public function getLockedBy()
	{
		return $this->locked_by;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     Post The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PostPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [title] column.
	 * 
	 * @param      string $v new value
	 * @return     Post The current object (for fluent API support)
	 */
	public function setTitle($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = PostPeer::TITLE;
		}

		return $this;
	} // setTitle()

	/**
	 * Set the value of [slug] column.
	 * 
	 * @param      string $v new value
	 * @return     Post The current object (for fluent API support)
	 */
	public function setSlug($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->slug !== $v) {
			$this->slug = $v;
			$this->modifiedColumns[] = PostPeer::SLUG;
		}

		return $this;
	} // setSlug()

	/**
	 * Set the value of [excerpt] column.
	 * 
	 * @param      string $v new value
	 * @return     Post The current object (for fluent API support)
	 */
	public function setExcerpt($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->excerpt !== $v) {
			$this->excerpt = $v;
			$this->modifiedColumns[] = PostPeer::EXCERPT;
		}

		return $this;
	} // setExcerpt()

	/**
	 * Set the value of [content] column.
	 * 
	 * @param      string $v new value
	 * @return     Post The current object (for fluent API support)
	 */
	public function setContent($v)
	{
		// explicitly set the is-loaded flag to true for this lazy load col;
		// it doesn't matter if the value is actually set or not (logic below) as
		// any attempt to set the value means that no db lookup should be performed
		// when the getContent() method is called.
		$this->content_isLoaded = true;

		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = PostPeer::CONTENT;
		}

		return $this;
	} // setContent()

	/**
	 * Sets the value of the [published] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     Post The current object (for fluent API support)
	 */
	public function setPublished($v)
	{
		if ($v !== null) {
			if (is_string($v)) {
				$v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
			} else {
				$v = (boolean) $v;
			}
		}

		if ($this->published !== $v) {
			$this->published = $v;
			$this->modifiedColumns[] = PostPeer::PUBLISHED;
		}

		return $this;
	} // setPublished()

	/**
	 * Sets the value of the [locked] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     Post The current object (for fluent API support)
	 */
	public function setLocked($v)
	{
		if ($v !== null) {
			if (is_string($v)) {
				$v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
			} else {
				$v = (boolean) $v;
			}
		}

		if ($this->locked !== $v) {
			$this->locked = $v;
			$this->modifiedColumns[] = PostPeer::LOCKED;
		}

		return $this;
	} // setLocked()

	/**
	 * Set the value of [created_by] column.
	 * 
	 * @param      int $v new value
	 * @return     Post The current object (for fluent API support)
	 */
	public function setCreatedBy($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = PostPeer::CREATED_BY;
		}

		if ($this->aUserRelatedByCreatedBy !== null && $this->aUserRelatedByCreatedBy->getId() !== $v) {
			$this->aUserRelatedByCreatedBy = null;
		}

		return $this;
	} // setCreatedBy()

	/**
	 * Set the value of [published_by] column.
	 * 
	 * @param      int $v new value
	 * @return     Post The current object (for fluent API support)
	 */
	public function setPublishedBy($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->published_by !== $v) {
			$this->published_by = $v;
			$this->modifiedColumns[] = PostPeer::PUBLISHED_BY;
		}

		if ($this->aUserRelatedByPublishedBy !== null && $this->aUserRelatedByPublishedBy->getId() !== $v) {
			$this->aUserRelatedByPublishedBy = null;
		}

		return $this;
	} // setPublishedBy()

	/**
	 * Set the value of [locked_by] column.
	 * 
	 * @param      int $v new value
	 * @return     Post The current object (for fluent API support)
	 */
	public function setLockedBy($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->locked_by !== $v) {
			$this->locked_by = $v;
			$this->modifiedColumns[] = PostPeer::LOCKED_BY;
		}

		return $this;
	} // setLockedBy()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->published !== false) {
				return false;
			}

			if ($this->locked !== false) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->title = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->slug = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->excerpt = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->published = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
			$this->locked = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
			$this->created_by = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->published_by = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->locked_by = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 9; // 9 = PostPeer::NUM_HYDRATE_COLUMNS.

		} catch (Exception $e) {
			throw new PropelException("Error populating Post object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aUserRelatedByCreatedBy !== null && $this->created_by !== $this->aUserRelatedByCreatedBy->getId()) {
			$this->aUserRelatedByCreatedBy = null;
		}
		if ($this->aUserRelatedByPublishedBy !== null && $this->published_by !== $this->aUserRelatedByPublishedBy->getId()) {
			$this->aUserRelatedByPublishedBy = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PostPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PostPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		// Reset the content lazy-load column
		$this->content = null;
		$this->content_isLoaded = false;

		if ($deep) {  // also de-associate any related objects?

			$this->aUserRelatedByCreatedBy = null;
			$this->aUserRelatedByPublishedBy = null;
			$this->collComments = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PostPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		try {
			$deleteQuery = PostQuery::create()
				->filterByPrimaryKey($this->getPrimaryKey());
			$ret = $this->preDelete($con);
			if ($ret) {
				$deleteQuery->delete($con);
				$this->postDelete($con);
				$con->commit();
				$this->setDeleted(true);
			} else {
				$con->commit();
			}
		} catch (Exception $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PostPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// sluggable behavior
			
			if ($this->isColumnModified(PostPeer::SLUG) && $this->getSlug()) {
				$this->setSlug($this->makeSlugUnique($this->getSlug()));
			} else {
				$this->setSlug($this->createSlug());
			}
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				PostPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (Exception $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUserRelatedByCreatedBy !== null) {
				if ($this->aUserRelatedByCreatedBy->isModified() || $this->aUserRelatedByCreatedBy->isNew()) {
					$affectedRows += $this->aUserRelatedByCreatedBy->save($con);
				}
				$this->setUserRelatedByCreatedBy($this->aUserRelatedByCreatedBy);
			}

			if ($this->aUserRelatedByPublishedBy !== null) {
				if ($this->aUserRelatedByPublishedBy->isModified() || $this->aUserRelatedByPublishedBy->isNew()) {
					$affectedRows += $this->aUserRelatedByPublishedBy->save($con);
				}
				$this->setUserRelatedByPublishedBy($this->aUserRelatedByPublishedBy);
			}

			if ($this->isNew() || $this->isModified()) {
				// persist changes
				if ($this->isNew()) {
					$this->doInsert($con);
				} else {
					$this->doUpdate($con);
				}
				$affectedRows += 1;
				$this->resetModified();
			}

			if ($this->commentsScheduledForDeletion !== null) {
				if (!$this->commentsScheduledForDeletion->isEmpty()) {
					CommentQuery::create()
						->filterByPrimaryKeys($this->commentsScheduledForDeletion->getPrimaryKeys(false))
						->delete($con);
					$this->commentsScheduledForDeletion = null;
				}
			}

			if ($this->collComments !== null) {
				foreach ($this->collComments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Insert the row in the database.
	 *
	 * @param      PropelPDO $con
	 *
	 * @throws     PropelException
	 * @see        doSave()
	 */
	protected function doInsert(PropelPDO $con)
	{
		$modifiedColumns = array();
		$index = 0;

		$this->modifiedColumns[] = PostPeer::ID;
		if (null !== $this->id) {
			throw new PropelException('Cannot insert a value for auto-increment primary key (' . PostPeer::ID . ')');
		}

		 // check the columns in natural order for more readable SQL queries
		if ($this->isColumnModified(PostPeer::ID)) {
			$modifiedColumns[':p' . $index++]  = '`ID`';
		}
		if ($this->isColumnModified(PostPeer::TITLE)) {
			$modifiedColumns[':p' . $index++]  = '`TITLE`';
		}
		if ($this->isColumnModified(PostPeer::SLUG)) {
			$modifiedColumns[':p' . $index++]  = '`SLUG`';
		}
		if ($this->isColumnModified(PostPeer::EXCERPT)) {
			$modifiedColumns[':p' . $index++]  = '`EXCERPT`';
		}
		if ($this->isColumnModified(PostPeer::CONTENT)) {
			$modifiedColumns[':p' . $index++]  = '`CONTENT`';
		}
		if ($this->isColumnModified(PostPeer::PUBLISHED)) {
			$modifiedColumns[':p' . $index++]  = '`PUBLISHED`';
		}
		if ($this->isColumnModified(PostPeer::LOCKED)) {
			$modifiedColumns[':p' . $index++]  = '`LOCKED`';
		}
		if ($this->isColumnModified(PostPeer::CREATED_BY)) {
			$modifiedColumns[':p' . $index++]  = '`CREATED_BY`';
		}
		if ($this->isColumnModified(PostPeer::PUBLISHED_BY)) {
			$modifiedColumns[':p' . $index++]  = '`PUBLISHED_BY`';
		}
		if ($this->isColumnModified(PostPeer::LOCKED_BY)) {
			$modifiedColumns[':p' . $index++]  = '`LOCKED_BY`';
		}

		$sql = sprintf(
			'INSERT INTO `posts` (%s) VALUES (%s)',
			implode(', ', $modifiedColumns),
			implode(', ', array_keys($modifiedColumns))
		);

		try {
			$stmt = $con->prepare($sql);
			foreach ($modifiedColumns as $identifier => $columnName) {
				switch ($columnName) {
					case '`ID`':
						$stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
						break;
					case '`TITLE`':
						$stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
						break;
					case '`SLUG`':
						$stmt->bindValue($identifier, $this->slug, PDO::PARAM_STR);
						break;
					case '`EXCERPT`':
						$stmt->bindValue($identifier, $this->excerpt, PDO::PARAM_STR);
						break;
					case '`CONTENT`':
						$stmt->bindValue($identifier, $this->content, PDO::PARAM_STR);
						break;
					case '`PUBLISHED`':
						$stmt->bindValue($identifier, (int) $this->published, PDO::PARAM_INT);
						break;
					case '`LOCKED`':
						$stmt->bindValue($identifier, (int) $this->locked, PDO::PARAM_INT);
						break;
					case '`CREATED_BY`':
						$stmt->bindValue($identifier, $this->created_by, PDO::PARAM_INT);
						break;
					case '`PUBLISHED_BY`':
						$stmt->bindValue($identifier, $this->published_by, PDO::PARAM_INT);
						break;
					case '`LOCKED_BY`':
						$stmt->bindValue($identifier, $this->locked_by, PDO::PARAM_INT);
						break;
				}
			}
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
		}

		try {
			$pk = $con->lastInsertId();
		} catch (Exception $e) {
			throw new PropelException('Unable to get autoincrement id.', $e);
		}
		$this->setId($pk);

		$this->setNew(false);
	}

	/**
	 * Update the row in the database.
	 *
	 * @param      PropelPDO $con
	 *
	 * @see        doSave()
	 */
	protected function doUpdate(PropelPDO $con)
	{
		$selectCriteria = $this->buildPkeyCriteria();
		$valuesCriteria = $this->buildCriteria();
		BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
	}

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUserRelatedByCreatedBy !== null) {
				if (!$this->aUserRelatedByCreatedBy->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUserRelatedByCreatedBy->getValidationFailures());
				}
			}

			if ($this->aUserRelatedByPublishedBy !== null) {
				if (!$this->aUserRelatedByPublishedBy->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUserRelatedByPublishedBy->getValidationFailures());
				}
			}


			if (($retval = PostPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collComments !== null) {
					foreach ($this->collComments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PostPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTitle();
				break;
			case 2:
				return $this->getSlug();
				break;
			case 3:
				return $this->getExcerpt();
				break;
			case 4:
				return $this->getContent();
				break;
			case 5:
				return $this->getPublished();
				break;
			case 6:
				return $this->getLocked();
				break;
			case 7:
				return $this->getCreatedBy();
				break;
			case 8:
				return $this->getPublishedBy();
				break;
			case 9:
				return $this->getLockedBy();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 *                    Defaults to BasePeer::TYPE_PHPNAME.
	 * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
	 * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
	 * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
	 *
	 * @return    array an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
	{
		if (isset($alreadyDumpedObjects['Post'][$this->getPrimaryKey()])) {
			return '*RECURSION*';
		}
		$alreadyDumpedObjects['Post'][$this->getPrimaryKey()] = true;
		$keys = PostPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTitle(),
			$keys[2] => $this->getSlug(),
			$keys[3] => $this->getExcerpt(),
			$keys[4] => ($includeLazyLoadColumns) ? $this->getContent() : null,
			$keys[5] => $this->getPublished(),
			$keys[6] => $this->getLocked(),
			$keys[7] => $this->getCreatedBy(),
			$keys[8] => $this->getPublishedBy(),
			$keys[9] => $this->getLockedBy(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aUserRelatedByCreatedBy) {
				$result['UserRelatedByCreatedBy'] = $this->aUserRelatedByCreatedBy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->aUserRelatedByPublishedBy) {
				$result['UserRelatedByPublishedBy'] = $this->aUserRelatedByPublishedBy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->collComments) {
				$result['Comments'] = $this->collComments->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
		}
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PostPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTitle($value);
				break;
			case 2:
				$this->setSlug($value);
				break;
			case 3:
				$this->setExcerpt($value);
				break;
			case 4:
				$this->setContent($value);
				break;
			case 5:
				$this->setPublished($value);
				break;
			case 6:
				$this->setLocked($value);
				break;
			case 7:
				$this->setCreatedBy($value);
				break;
			case 8:
				$this->setPublishedBy($value);
				break;
			case 9:
				$this->setLockedBy($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = PostPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSlug($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setExcerpt($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setContent($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPublished($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setLocked($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreatedBy($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setPublishedBy($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setLockedBy($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PostPeer::DATABASE_NAME);

		if ($this->isColumnModified(PostPeer::ID)) $criteria->add(PostPeer::ID, $this->id);
		if ($this->isColumnModified(PostPeer::TITLE)) $criteria->add(PostPeer::TITLE, $this->title);
		if ($this->isColumnModified(PostPeer::SLUG)) $criteria->add(PostPeer::SLUG, $this->slug);
		if ($this->isColumnModified(PostPeer::EXCERPT)) $criteria->add(PostPeer::EXCERPT, $this->excerpt);
		if ($this->isColumnModified(PostPeer::CONTENT)) $criteria->add(PostPeer::CONTENT, $this->content);
		if ($this->isColumnModified(PostPeer::PUBLISHED)) $criteria->add(PostPeer::PUBLISHED, $this->published);
		if ($this->isColumnModified(PostPeer::LOCKED)) $criteria->add(PostPeer::LOCKED, $this->locked);
		if ($this->isColumnModified(PostPeer::CREATED_BY)) $criteria->add(PostPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(PostPeer::PUBLISHED_BY)) $criteria->add(PostPeer::PUBLISHED_BY, $this->published_by);
		if ($this->isColumnModified(PostPeer::LOCKED_BY)) $criteria->add(PostPeer::LOCKED_BY, $this->locked_by);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(PostPeer::DATABASE_NAME);
		$criteria->add(PostPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Returns true if the primary key for this object is null.
	 * @return     boolean
	 */
	public function isPrimaryKeyNull()
	{
		return null === $this->getId();
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Post (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
	{
		$copyObj->setTitle($this->getTitle());
		$copyObj->setSlug($this->getSlug());
		$copyObj->setExcerpt($this->getExcerpt());
		$copyObj->setContent($this->getContent());
		$copyObj->setPublished($this->getPublished());
		$copyObj->setLocked($this->getLocked());
		$copyObj->setCreatedBy($this->getCreatedBy());
		$copyObj->setPublishedBy($this->getPublishedBy());
		$copyObj->setLockedBy($this->getLockedBy());

		if ($deepCopy && !$this->startCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);
			// store object hash to prevent cycle
			$this->startCopy = true;

			foreach ($this->getComments() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addComment($relObj->copy($deepCopy));
				}
			}

			//unflag object copy
			$this->startCopy = false;
		} // if ($deepCopy)

		if ($makeNew) {
			$copyObj->setNew(true);
			$copyObj->setId(NULL); // this is a auto-increment column, so set to default value
		}
	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     Post Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     PostPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PostPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Post The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUserRelatedByCreatedBy(User $v = null)
	{
		if ($v === null) {
			$this->setCreatedBy(NULL);
		} else {
			$this->setCreatedBy($v->getId());
		}

		$this->aUserRelatedByCreatedBy = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the User object, it will not be re-added.
		if ($v !== null) {
			$v->addPostRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUserRelatedByCreatedBy(PropelPDO $con = null)
	{
		if ($this->aUserRelatedByCreatedBy === null && ($this->created_by !== null)) {
			$this->aUserRelatedByCreatedBy = UserQuery::create()->findPk($this->created_by, $con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aUserRelatedByCreatedBy->addPostsRelatedByCreatedBy($this);
			 */
		}
		return $this->aUserRelatedByCreatedBy;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Post The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUserRelatedByPublishedBy(User $v = null)
	{
		if ($v === null) {
			$this->setPublishedBy(NULL);
		} else {
			$this->setPublishedBy($v->getId());
		}

		$this->aUserRelatedByPublishedBy = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the User object, it will not be re-added.
		if ($v !== null) {
			$v->addPostRelatedByPublishedBy($this);
		}

		return $this;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUserRelatedByPublishedBy(PropelPDO $con = null)
	{
		if ($this->aUserRelatedByPublishedBy === null && ($this->published_by !== null)) {
			$this->aUserRelatedByPublishedBy = UserQuery::create()->findPk($this->published_by, $con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aUserRelatedByPublishedBy->addPostsRelatedByPublishedBy($this);
			 */
		}
		return $this->aUserRelatedByPublishedBy;
	}


	/**
	 * Initializes a collection based on the name of a relation.
	 * Avoids crafting an 'init[$relationName]s' method name
	 * that wouldn't work when StandardEnglishPluralizer is used.
	 *
	 * @param      string $relationName The name of the relation to initialize
	 * @return     void
	 */
	public function initRelation($relationName)
	{
		if ('Comment' == $relationName) {
			return $this->initComments();
		}
	}

	/**
	 * Clears out the collComments collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addComments()
	 */
	public function clearComments()
	{
		$this->collComments = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collComments collection.
	 *
	 * By default this just sets the collComments collection to an empty array (like clearcollComments());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initComments($overrideExisting = true)
	{
		if (null !== $this->collComments && !$overrideExisting) {
			return;
		}
		$this->collComments = new PropelObjectCollection();
		$this->collComments->setModel('Comment');
	}

	/**
	 * Gets an array of Comment objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Post is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Comment[] List of Comment objects
	 * @throws     PropelException
	 */
	public function getComments($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collComments || null !== $criteria) {
			if ($this->isNew() && null === $this->collComments) {
				// return empty collection
				$this->initComments();
			} else {
				$collComments = CommentQuery::create(null, $criteria)
					->filterByPost($this)
					->find($con);
				if (null !== $criteria) {
					return $collComments;
				}
				$this->collComments = $collComments;
			}
		}
		return $this->collComments;
	}

	/**
	 * Sets a collection of Comment objects related by a one-to-many relationship
	 * to the current object.
	 * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
	 * and new objects from the given Propel collection.
	 *
	 * @param      PropelCollection $comments A Propel collection.
	 * @param      PropelPDO $con Optional connection object
	 */
	public function setComments(PropelCollection $comments, PropelPDO $con = null)
	{
		$this->commentsScheduledForDeletion = $this->getComments(new Criteria(), $con)->diff($comments);

		foreach ($comments as $comment) {
			// Fix issue with collection modified by reference
			if ($comment->isNew()) {
				$comment->setPost($this);
			}
			$this->addComment($comment);
		}

		$this->collComments = $comments;
	}

	/**
	 * Returns the number of related Comment objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Comment objects.
	 * @throws     PropelException
	 */
	public function countComments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collComments || null !== $criteria) {
			if ($this->isNew() && null === $this->collComments) {
				return 0;
			} else {
				$query = CommentQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByPost($this)
					->count($con);
			}
		} else {
			return count($this->collComments);
		}
	}

	/**
	 * Method called to associate a Comment object to this object
	 * through the Comment foreign key attribute.
	 *
	 * @param      Comment $l Comment
	 * @return     Post The current object (for fluent API support)
	 */
	public function addComment(Comment $l)
	{
		if ($this->collComments === null) {
			$this->initComments();
		}
		if (!$this->collComments->contains($l)) { // only add it if the **same** object is not already associated
			$this->doAddComment($l);
		}

		return $this;
	}

	/**
	 * @param	Comment $comment The comment object to add.
	 */
	protected function doAddComment($comment)
	{
		$this->collComments[]= $comment;
		$comment->setPost($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Post is new, it will return
	 * an empty collection; or if this Post has previously
	 * been saved, it will retrieve related Comments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Post.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Comment[] List of Comment objects
	 */
	public function getCommentsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = CommentQuery::create(null, $criteria);
		$query->joinWith('User', $join_behavior);

		return $this->getComments($query, $con);
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->title = null;
		$this->slug = null;
		$this->excerpt = null;
		$this->content = null;
		$this->content_isLoaded = false;
		$this->published = null;
		$this->locked = null;
		$this->created_by = null;
		$this->published_by = null;
		$this->locked_by = null;
		$this->alreadyInSave = false;
		$this->alreadyInValidation = false;
		$this->clearAllReferences();
		$this->applyDefaultValues();
		$this->resetModified();
		$this->setNew(true);
		$this->setDeleted(false);
	}

	/**
	 * Resets all references to other model objects or collections of model objects.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect
	 * objects with circular references (even in PHP 5.3). This is currently necessary
	 * when using Propel in certain daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all referrer objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collComments) {
				foreach ($this->collComments as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		if ($this->collComments instanceof PropelCollection) {
			$this->collComments->clearIterator();
		}
		$this->collComments = null;
		$this->aUserRelatedByCreatedBy = null;
		$this->aUserRelatedByPublishedBy = null;
	}

	/**
	 * Return the string representation of this object
	 *
	 * @return string The value of the 'title' column
	 */
	public function __toString()
	{
		return (string) $this->getTitle();
	}

	// sluggable behavior
	
	/**
	 * Create a unique slug based on the object
	 *
	 * @return string The object slug
	 */
	protected function createSlug()
	{
		$slug = $this->createRawSlug();
		$slug = $this->limitSlugSize($slug);
		$slug = $this->makeSlugUnique($slug);
	
		return $slug;
	}
	
	/**
	 * Create the slug from the appropriate columns
	 *
	 * @return string
	 */
	protected function createRawSlug()
	{
		return $this->cleanupSlugPart($this->__toString());
	}
	
	/**
	 * Cleanup a string to make a slug of it
	 * Removes special characters, replaces blanks with a separator, and trim it
	 *
	 * @param     string $text      the text to slugify
	 * @param     string $separator the separator used by slug
	 * @return    string             the slugified text
	 */
	protected static function cleanupSlugPart($slug, $replacement = '-')
	{
		// transliterate
		if (function_exists('iconv')) {
			$slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
		}
	
		// lowercase
		if (function_exists('mb_strtolower')) {
			$slug = mb_strtolower($slug);
		} else {
			$slug = strtolower($slug);
		}
	
		// remove accents resulting from OSX's iconv
		$slug = str_replace(array('\'', '`', '^'), '', $slug);
	
		// replace non letter or digits with separator
		$slug = preg_replace('/[^\\pL\\d]+/u', $replacement, $slug);
	
		// trim
		$slug = trim($slug, $replacement);
	
		if (empty($slug)) {
			return 'n-a';
		}
	
		return $slug;
	}
	
	
	/**
	 * Make sure the slug is short enough to accomodate the column size
	 *
	 * @param	string $slug			the slug to check
	 *
	 * @return string						the truncated slug
	 */
	protected static function limitSlugSize($slug, $incrementReservedSpace = 3)
	{
		// check length, as suffix could put it over maximum
		if (strlen($slug) > (255 - $incrementReservedSpace)) {
			$slug = substr($slug, 0, 255 - $incrementReservedSpace);
		}
		return $slug;
	}
	
	
	/**
	 * Get the slug, ensuring its uniqueness
	 *
	 * @param	string $slug			the slug to check
	 * @param	string $separator the separator used by slug
	 * @return string						the unique slug
	 */
	protected function makeSlugUnique($slug, $separator = '-', $increment = 0)
	{
		$slug2 = empty($increment) ? $slug : $slug . $separator . $increment;
		$slugAlreadyExists = PostQuery::create()
			->filterBySlug($slug2)
			->prune($this)
			->count();
		if ($slugAlreadyExists) {
			return $this->makeSlugUnique($slug, $separator, ++$increment);
		} else {
			return $slug2;
		}
	}

} // BasePost
