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
use Acme\BlogBundle\Model\Post;
use Acme\BlogBundle\Model\PostQuery;
use Acme\BlogBundle\Model\UserPeer;
use Acme\BlogBundle\Model\UserQuery;

/**
 * Base class that represents a row from the 'users' table.
 *
 * 
 *
 * @package    propel.generator.src.Acme.BlogBundle.Model.om
 */
abstract class BaseUser extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
	const PEER = 'Acme\\BlogBundle\\Model\\UserPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        UserPeer
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
	 * The value for the username field.
	 * @var        string
	 */
	protected $username;

	/**
	 * The value for the salt field.
	 * @var        string
	 */
	protected $salt;

	/**
	 * The value for the password field.
	 * @var        string
	 */
	protected $password;

	/**
	 * The value for the roles field.
	 * @var        array
	 */
	protected $roles;

	/**
	 * The unserialized $roles value - i.e. the persisted object.
	 * This is necessary to avoid repeated calls to unserialize() at runtime.
	 * @var        object
	 */
	protected $roles_unserialized;

	/**
	 * @var        array Post[] Collection to store aggregation of Post objects.
	 */
	protected $collPostsRelatedByCreatedBy;

	/**
	 * @var        array Post[] Collection to store aggregation of Post objects.
	 */
	protected $collPostsRelatedByPublishedBy;

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
	protected $postsRelatedByCreatedByScheduledForDeletion = null;

	/**
	 * An array of objects scheduled for deletion.
	 * @var		array
	 */
	protected $postsRelatedByPublishedByScheduledForDeletion = null;

	/**
	 * An array of objects scheduled for deletion.
	 * @var		array
	 */
	protected $commentsScheduledForDeletion = null;

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
	 * Get the [username] column value.
	 * 
	 * @return     string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Get the [salt] column value.
	 * 
	 * @return     string
	 */
	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * Get the [password] column value.
	 * 
	 * @return     string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Get the [roles] column value.
	 * 
	 * @return     array
	 */
	public function getRoles()
	{
		if (null === $this->roles_unserialized) {
			$this->roles_unserialized = array();
		}
		if (!$this->roles_unserialized && null !== $this->roles) {
			$roles_unserialized = substr($this->roles, 2, -2);
			$this->roles_unserialized = $roles_unserialized ? explode(' | ', $roles_unserialized) : array();
		}
		return $this->roles_unserialized;
	}

	/**
	 * Test the presence of a value in the [roles] array column value.
	 * @param      mixed $value
	 * 
	 * @return     Boolean
	 */
	public function hasRole($value)
	{
		return in_array($value, $this->getRoles());
	} // hasRole()

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = UserPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [username] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setUsername($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->username !== $v) {
			$this->username = $v;
			$this->modifiedColumns[] = UserPeer::USERNAME;
		}

		return $this;
	} // setUsername()

	/**
	 * Set the value of [salt] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setSalt($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->salt !== $v) {
			$this->salt = $v;
			$this->modifiedColumns[] = UserPeer::SALT;
		}

		return $this;
	} // setSalt()

	/**
	 * Set the value of [password] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setPassword($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->password !== $v) {
			$this->password = $v;
			$this->modifiedColumns[] = UserPeer::PASSWORD;
		}

		return $this;
	} // setPassword()

	/**
	 * Set the value of [roles] column.
	 * 
	 * @param      array $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setRoles($v)
	{
		if ($this->roles_unserialized !== $v) {
			$this->roles_unserialized = $v;
			$this->roles = '| ' . implode(' | ', $v) . ' |';
			$this->modifiedColumns[] = UserPeer::ROLES;
		}

		return $this;
	} // setRoles()

	/**
	 * Adds a value to the [roles] array column value.
	 * @param      mixed $value
	 * 
	 * @return     User The current object (for fluent API support)
	 */
	public function addRole($value)
	{
		$currentArray = $this->getRoles();
		$currentArray []= $value;
		$this->setRoles($currentArray);

		return $this;
	} // addRole()

	/**
	 * Removes a value from the [roles] array column value.
	 * @param      mixed $value
	 * 
	 * @return     User The current object (for fluent API support)
	 */
	public function removeRole($value)
	{
		$targetArray = array();
		foreach ($this->getRoles() as $element) {
			if ($element != $value) {
				$targetArray []= $element;
			}
		}
		$this->setRoles($targetArray);

		return $this;
	} // removeRole()

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
			$this->username = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->salt = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->password = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->roles = $row[$startcol + 4];
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 5; // 5 = UserPeer::NUM_HYDRATE_COLUMNS.

		} catch (Exception $e) {
			throw new PropelException("Error populating User object", $e);
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
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = UserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collPostsRelatedByCreatedBy = null;

			$this->collPostsRelatedByPublishedBy = null;

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
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		try {
			$deleteQuery = UserQuery::create()
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
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
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
				UserPeer::addInstanceToPool($this);
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

			if ($this->postsRelatedByCreatedByScheduledForDeletion !== null) {
				if (!$this->postsRelatedByCreatedByScheduledForDeletion->isEmpty()) {
					PostQuery::create()
						->filterByPrimaryKeys($this->postsRelatedByCreatedByScheduledForDeletion->getPrimaryKeys(false))
						->delete($con);
					$this->postsRelatedByCreatedByScheduledForDeletion = null;
				}
			}

			if ($this->collPostsRelatedByCreatedBy !== null) {
				foreach ($this->collPostsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->postsRelatedByPublishedByScheduledForDeletion !== null) {
				if (!$this->postsRelatedByPublishedByScheduledForDeletion->isEmpty()) {
					PostQuery::create()
						->filterByPrimaryKeys($this->postsRelatedByPublishedByScheduledForDeletion->getPrimaryKeys(false))
						->delete($con);
					$this->postsRelatedByPublishedByScheduledForDeletion = null;
				}
			}

			if ($this->collPostsRelatedByPublishedBy !== null) {
				foreach ($this->collPostsRelatedByPublishedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
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

		$this->modifiedColumns[] = UserPeer::ID;
		if (null !== $this->id) {
			throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserPeer::ID . ')');
		}

		 // check the columns in natural order for more readable SQL queries
		if ($this->isColumnModified(UserPeer::ID)) {
			$modifiedColumns[':p' . $index++]  = '`ID`';
		}
		if ($this->isColumnModified(UserPeer::USERNAME)) {
			$modifiedColumns[':p' . $index++]  = '`USERNAME`';
		}
		if ($this->isColumnModified(UserPeer::SALT)) {
			$modifiedColumns[':p' . $index++]  = '`SALT`';
		}
		if ($this->isColumnModified(UserPeer::PASSWORD)) {
			$modifiedColumns[':p' . $index++]  = '`PASSWORD`';
		}
		if ($this->isColumnModified(UserPeer::ROLES)) {
			$modifiedColumns[':p' . $index++]  = '`ROLES`';
		}

		$sql = sprintf(
			'INSERT INTO `users` (%s) VALUES (%s)',
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
					case '`USERNAME`':
						$stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
						break;
					case '`SALT`':
						$stmt->bindValue($identifier, $this->salt, PDO::PARAM_STR);
						break;
					case '`PASSWORD`':
						$stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
						break;
					case '`ROLES`':
						$stmt->bindValue($identifier, $this->roles, PDO::PARAM_STR);
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


			if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPostsRelatedByCreatedBy !== null) {
					foreach ($this->collPostsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPostsRelatedByPublishedBy !== null) {
					foreach ($this->collPostsRelatedByPublishedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
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
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getUsername();
				break;
			case 2:
				return $this->getSalt();
				break;
			case 3:
				return $this->getPassword();
				break;
			case 4:
				return $this->getRoles();
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
		if (isset($alreadyDumpedObjects['User'][$this->getPrimaryKey()])) {
			return '*RECURSION*';
		}
		$alreadyDumpedObjects['User'][$this->getPrimaryKey()] = true;
		$keys = UserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUsername(),
			$keys[2] => $this->getSalt(),
			$keys[3] => $this->getPassword(),
			$keys[4] => $this->getRoles(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->collPostsRelatedByCreatedBy) {
				$result['PostsRelatedByCreatedBy'] = $this->collPostsRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collPostsRelatedByPublishedBy) {
				$result['PostsRelatedByPublishedBy'] = $this->collPostsRelatedByPublishedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setUsername($value);
				break;
			case 2:
				$this->setSalt($value);
				break;
			case 3:
				$this->setPassword($value);
				break;
			case 4:
				if (!is_array($value)) {
					$v = trim(substr($value, 2, -2));
					$value = $v ? explode(' | ', $v) : array();
				}
				$this->setRoles($value);
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
		$keys = UserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUsername($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSalt($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPassword($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setRoles($arr[$keys[4]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		if ($this->isColumnModified(UserPeer::ID)) $criteria->add(UserPeer::ID, $this->id);
		if ($this->isColumnModified(UserPeer::USERNAME)) $criteria->add(UserPeer::USERNAME, $this->username);
		if ($this->isColumnModified(UserPeer::SALT)) $criteria->add(UserPeer::SALT, $this->salt);
		if ($this->isColumnModified(UserPeer::PASSWORD)) $criteria->add(UserPeer::PASSWORD, $this->password);
		if ($this->isColumnModified(UserPeer::ROLES)) $criteria->add(UserPeer::ROLES, $this->roles);

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
		$criteria = new Criteria(UserPeer::DATABASE_NAME);
		$criteria->add(UserPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of User (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
	{
		$copyObj->setUsername($this->getUsername());
		$copyObj->setSalt($this->getSalt());
		$copyObj->setPassword($this->getPassword());
		$copyObj->setRoles($this->getRoles());

		if ($deepCopy && !$this->startCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);
			// store object hash to prevent cycle
			$this->startCopy = true;

			foreach ($this->getPostsRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPostRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPostsRelatedByPublishedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPostRelatedByPublishedBy($relObj->copy($deepCopy));
				}
			}

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
	 * @return     User Clone of current object.
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
	 * @return     UserPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new UserPeer();
		}
		return self::$peer;
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
		if ('PostRelatedByCreatedBy' == $relationName) {
			return $this->initPostsRelatedByCreatedBy();
		}
		if ('PostRelatedByPublishedBy' == $relationName) {
			return $this->initPostsRelatedByPublishedBy();
		}
		if ('Comment' == $relationName) {
			return $this->initComments();
		}
	}

	/**
	 * Clears out the collPostsRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPostsRelatedByCreatedBy()
	 */
	public function clearPostsRelatedByCreatedBy()
	{
		$this->collPostsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPostsRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collPostsRelatedByCreatedBy collection to an empty array (like clearcollPostsRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initPostsRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collPostsRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collPostsRelatedByCreatedBy = new PropelObjectCollection();
		$this->collPostsRelatedByCreatedBy->setModel('Post');
	}

	/**
	 * Gets an array of Post objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Post[] List of Post objects
	 * @throws     PropelException
	 */
	public function getPostsRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPostsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPostsRelatedByCreatedBy) {
				// return empty collection
				$this->initPostsRelatedByCreatedBy();
			} else {
				$collPostsRelatedByCreatedBy = PostQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collPostsRelatedByCreatedBy;
				}
				$this->collPostsRelatedByCreatedBy = $collPostsRelatedByCreatedBy;
			}
		}
		return $this->collPostsRelatedByCreatedBy;
	}

	/**
	 * Sets a collection of PostRelatedByCreatedBy objects related by a one-to-many relationship
	 * to the current object.
	 * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
	 * and new objects from the given Propel collection.
	 *
	 * @param      PropelCollection $postsRelatedByCreatedBy A Propel collection.
	 * @param      PropelPDO $con Optional connection object
	 */
	public function setPostsRelatedByCreatedBy(PropelCollection $postsRelatedByCreatedBy, PropelPDO $con = null)
	{
		$this->postsRelatedByCreatedByScheduledForDeletion = $this->getPostsRelatedByCreatedBy(new Criteria(), $con)->diff($postsRelatedByCreatedBy);

		foreach ($postsRelatedByCreatedBy as $postRelatedByCreatedBy) {
			// Fix issue with collection modified by reference
			if ($postRelatedByCreatedBy->isNew()) {
				$postRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
			}
			$this->addPostRelatedByCreatedBy($postRelatedByCreatedBy);
		}

		$this->collPostsRelatedByCreatedBy = $postsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related Post objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Post objects.
	 * @throws     PropelException
	 */
	public function countPostsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPostsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPostsRelatedByCreatedBy) {
				return 0;
			} else {
				$query = PostQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collPostsRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a Post object to this object
	 * through the Post foreign key attribute.
	 *
	 * @param      Post $l Post
	 * @return     User The current object (for fluent API support)
	 */
	public function addPostRelatedByCreatedBy(Post $l)
	{
		if ($this->collPostsRelatedByCreatedBy === null) {
			$this->initPostsRelatedByCreatedBy();
		}
		if (!$this->collPostsRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->doAddPostRelatedByCreatedBy($l);
		}

		return $this;
	}

	/**
	 * @param	PostRelatedByCreatedBy $postRelatedByCreatedBy The postRelatedByCreatedBy object to add.
	 */
	protected function doAddPostRelatedByCreatedBy($postRelatedByCreatedBy)
	{
		$this->collPostsRelatedByCreatedBy[]= $postRelatedByCreatedBy;
		$postRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
	}

	/**
	 * Clears out the collPostsRelatedByPublishedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPostsRelatedByPublishedBy()
	 */
	public function clearPostsRelatedByPublishedBy()
	{
		$this->collPostsRelatedByPublishedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPostsRelatedByPublishedBy collection.
	 *
	 * By default this just sets the collPostsRelatedByPublishedBy collection to an empty array (like clearcollPostsRelatedByPublishedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initPostsRelatedByPublishedBy($overrideExisting = true)
	{
		if (null !== $this->collPostsRelatedByPublishedBy && !$overrideExisting) {
			return;
		}
		$this->collPostsRelatedByPublishedBy = new PropelObjectCollection();
		$this->collPostsRelatedByPublishedBy->setModel('Post');
	}

	/**
	 * Gets an array of Post objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Post[] List of Post objects
	 * @throws     PropelException
	 */
	public function getPostsRelatedByPublishedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPostsRelatedByPublishedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPostsRelatedByPublishedBy) {
				// return empty collection
				$this->initPostsRelatedByPublishedBy();
			} else {
				$collPostsRelatedByPublishedBy = PostQuery::create(null, $criteria)
					->filterByUserRelatedByPublishedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collPostsRelatedByPublishedBy;
				}
				$this->collPostsRelatedByPublishedBy = $collPostsRelatedByPublishedBy;
			}
		}
		return $this->collPostsRelatedByPublishedBy;
	}

	/**
	 * Sets a collection of PostRelatedByPublishedBy objects related by a one-to-many relationship
	 * to the current object.
	 * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
	 * and new objects from the given Propel collection.
	 *
	 * @param      PropelCollection $postsRelatedByPublishedBy A Propel collection.
	 * @param      PropelPDO $con Optional connection object
	 */
	public function setPostsRelatedByPublishedBy(PropelCollection $postsRelatedByPublishedBy, PropelPDO $con = null)
	{
		$this->postsRelatedByPublishedByScheduledForDeletion = $this->getPostsRelatedByPublishedBy(new Criteria(), $con)->diff($postsRelatedByPublishedBy);

		foreach ($postsRelatedByPublishedBy as $postRelatedByPublishedBy) {
			// Fix issue with collection modified by reference
			if ($postRelatedByPublishedBy->isNew()) {
				$postRelatedByPublishedBy->setUserRelatedByPublishedBy($this);
			}
			$this->addPostRelatedByPublishedBy($postRelatedByPublishedBy);
		}

		$this->collPostsRelatedByPublishedBy = $postsRelatedByPublishedBy;
	}

	/**
	 * Returns the number of related Post objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Post objects.
	 * @throws     PropelException
	 */
	public function countPostsRelatedByPublishedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPostsRelatedByPublishedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPostsRelatedByPublishedBy) {
				return 0;
			} else {
				$query = PostQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByPublishedBy($this)
					->count($con);
			}
		} else {
			return count($this->collPostsRelatedByPublishedBy);
		}
	}

	/**
	 * Method called to associate a Post object to this object
	 * through the Post foreign key attribute.
	 *
	 * @param      Post $l Post
	 * @return     User The current object (for fluent API support)
	 */
	public function addPostRelatedByPublishedBy(Post $l)
	{
		if ($this->collPostsRelatedByPublishedBy === null) {
			$this->initPostsRelatedByPublishedBy();
		}
		if (!$this->collPostsRelatedByPublishedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->doAddPostRelatedByPublishedBy($l);
		}

		return $this;
	}

	/**
	 * @param	PostRelatedByPublishedBy $postRelatedByPublishedBy The postRelatedByPublishedBy object to add.
	 */
	protected function doAddPostRelatedByPublishedBy($postRelatedByPublishedBy)
	{
		$this->collPostsRelatedByPublishedBy[]= $postRelatedByPublishedBy;
		$postRelatedByPublishedBy->setUserRelatedByPublishedBy($this);
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
	 * If this User is new, it will return
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
					->filterByUser($this)
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
				$comment->setUser($this);
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
					->filterByUser($this)
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
	 * @return     User The current object (for fluent API support)
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
		$comment->setUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related Comments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Comment[] List of Comment objects
	 */
	public function getCommentsJoinPost($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = CommentQuery::create(null, $criteria);
		$query->joinWith('Post', $join_behavior);

		return $this->getComments($query, $con);
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->username = null;
		$this->salt = null;
		$this->password = null;
		$this->roles = null;
		$this->roles_unserialized = null;
		$this->alreadyInSave = false;
		$this->alreadyInValidation = false;
		$this->clearAllReferences();
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
			if ($this->collPostsRelatedByCreatedBy) {
				foreach ($this->collPostsRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPostsRelatedByPublishedBy) {
				foreach ($this->collPostsRelatedByPublishedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collComments) {
				foreach ($this->collComments as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		if ($this->collPostsRelatedByCreatedBy instanceof PropelCollection) {
			$this->collPostsRelatedByCreatedBy->clearIterator();
		}
		$this->collPostsRelatedByCreatedBy = null;
		if ($this->collPostsRelatedByPublishedBy instanceof PropelCollection) {
			$this->collPostsRelatedByPublishedBy->clearIterator();
		}
		$this->collPostsRelatedByPublishedBy = null;
		if ($this->collComments instanceof PropelCollection) {
			$this->collComments->clearIterator();
		}
		$this->collComments = null;
	}

	/**
	 * Return the string representation of this object
	 *
	 * @return string The value of the 'username' column
	 */
	public function __toString()
	{
		return (string) $this->getUsername();
	}

} // BaseUser
