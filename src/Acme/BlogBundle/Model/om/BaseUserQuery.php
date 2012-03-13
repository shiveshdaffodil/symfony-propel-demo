<?php

namespace Acme\BlogBundle\Model\om;

use \Criteria;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelPDO;
use Acme\BlogBundle\Model\Comment;
use Acme\BlogBundle\Model\Post;
use Acme\BlogBundle\Model\User;
use Acme\BlogBundle\Model\UserPeer;
use Acme\BlogBundle\Model\UserQuery;

/**
 * Base class that represents a query for the 'users' table.
 *
 * 
 *
 * @method     UserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     UserQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     UserQuery orderBySalt($order = Criteria::ASC) Order by the salt column
 * @method     UserQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     UserQuery orderByRoles($order = Criteria::ASC) Order by the roles column
 *
 * @method     UserQuery groupById() Group by the id column
 * @method     UserQuery groupByUsername() Group by the username column
 * @method     UserQuery groupBySalt() Group by the salt column
 * @method     UserQuery groupByPassword() Group by the password column
 * @method     UserQuery groupByRoles() Group by the roles column
 *
 * @method     UserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     UserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     UserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     UserQuery leftJoinPostRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PostRelatedByCreatedBy relation
 * @method     UserQuery rightJoinPostRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PostRelatedByCreatedBy relation
 * @method     UserQuery innerJoinPostRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PostRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinPostRelatedByPublishedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PostRelatedByPublishedBy relation
 * @method     UserQuery rightJoinPostRelatedByPublishedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PostRelatedByPublishedBy relation
 * @method     UserQuery innerJoinPostRelatedByPublishedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PostRelatedByPublishedBy relation
 *
 * @method     UserQuery leftJoinComment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comment relation
 * @method     UserQuery rightJoinComment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comment relation
 * @method     UserQuery innerJoinComment($relationAlias = null) Adds a INNER JOIN clause to the query using the Comment relation
 *
 * @method     User findOne(PropelPDO $con = null) Return the first User matching the query
 * @method     User findOneOrCreate(PropelPDO $con = null) Return the first User matching the query, or a new User object populated from the query conditions when no match is found
 *
 * @method     User findOneById(int $id) Return the first User filtered by the id column
 * @method     User findOneByUsername(string $username) Return the first User filtered by the username column
 * @method     User findOneBySalt(string $salt) Return the first User filtered by the salt column
 * @method     User findOneByPassword(string $password) Return the first User filtered by the password column
 * @method     User findOneByRoles(array $roles) Return the first User filtered by the roles column
 *
 * @method     array findById(int $id) Return User objects filtered by the id column
 * @method     array findByUsername(string $username) Return User objects filtered by the username column
 * @method     array findBySalt(string $salt) Return User objects filtered by the salt column
 * @method     array findByPassword(string $password) Return User objects filtered by the password column
 * @method     array findByRoles(array $roles) Return User objects filtered by the roles column
 *
 * @package    propel.generator.src.Acme.BlogBundle.Model.om
 */
abstract class BaseUserQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseUserQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Acme\\BlogBundle\\Model\\User', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new UserQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    UserQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof UserQuery) {
			return $criteria;
		}
		$query = new UserQuery();
		if (null !== $modelAlias) {
			$query->setModelAlias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
	}

	/**
	 * Find object by primary key.
	 * Propel uses the instance pool to skip the database if the object exists.
	 * Go fast if the query is untouched.
	 *
	 * <code>
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    User|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = UserPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		if ($this->formatter || $this->modelAlias || $this->with || $this->select
		 || $this->selectColumns || $this->asColumns || $this->selectModifiers
		 || $this->map || $this->having || $this->joins) {
			return $this->findPkComplex($key, $con);
		} else {
			return $this->findPkSimple($key, $con);
		}
	}

	/**
	 * Find object by primary key using raw SQL to go fast.
	 * Bypass doSelect() and the object formatter by using generated code.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    User A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `USERNAME`, `SALT`, `PASSWORD`, `ROLES` FROM `users` WHERE `ID` = :p0';
		try {
			$stmt = $con->prepare($sql);
			$stmt->bindValue(':p0', $key, PDO::PARAM_INT);
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
		}
		$obj = null;
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$obj = new User();
			$obj->hydrate($row);
			UserPeer::addInstanceToPool($obj, (string) $key);
		}
		$stmt->closeCursor();

		return $obj;
	}

	/**
	 * Find object by primary key.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    User|array|mixed the result, formatted by the current formatter
	 */
	protected function findPkComplex($key, $con)
	{
		// As the query uses a PK condition, no limit(1) is necessary.
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKey($key)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKeys($keys)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->format($stmt);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(UserPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(UserPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterById(1234); // WHERE id = 1234
	 * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
	 * $query->filterById(array('min' => 12)); // WHERE id > 12
	 * </code>
	 *
	 * @param     mixed $id The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(UserPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the username column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
	 * $query->filterByUsername('%fooValue%'); // WHERE username LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $username The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUsername($username = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($username)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $username)) {
				$username = str_replace('*', '%', $username);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::USERNAME, $username, $comparison);
	}

	/**
	 * Filter the query on the salt column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterBySalt('fooValue');   // WHERE salt = 'fooValue'
	 * $query->filterBySalt('%fooValue%'); // WHERE salt LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $salt The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterBySalt($salt = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($salt)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $salt)) {
				$salt = str_replace('*', '%', $salt);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::SALT, $salt, $comparison);
	}

	/**
	 * Filter the query on the password column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
	 * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $password The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPassword($password = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($password)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $password)) {
				$password = str_replace('*', '%', $password);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::PASSWORD, $password, $comparison);
	}

	/**
	 * Filter the query on the roles column
	 *
	 * @param     array $roles The values to use as filter.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByRoles($roles = null, $comparison = null)
	{
		$key = $this->getAliasedColName(UserPeer::ROLES);
		if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
			foreach ($roles as $value) {
				$value = '%| ' . $value . ' |%';
				if($this->containsKey($key)) {
					$this->addAnd($key, $value, Criteria::LIKE);
				} else {
					$this->add($key, $value, Criteria::LIKE);
				}
			}
			return $this;
		} elseif ($comparison == Criteria::CONTAINS_SOME) {
			foreach ($roles as $value) {
				$value = '%| ' . $value . ' |%';
				if($this->containsKey($key)) {
					$this->addOr($key, $value, Criteria::LIKE);
				} else {
					$this->add($key, $value, Criteria::LIKE);
				}
			}
			return $this;
		} elseif ($comparison == Criteria::CONTAINS_NONE) {
			foreach ($roles as $value) {
				$value = '%| ' . $value . ' |%';
				if($this->containsKey($key)) {
					$this->addAnd($key, $value, Criteria::NOT_LIKE);
				} else {
					$this->add($key, $value, Criteria::NOT_LIKE);
				}
			}
			$this->addOr($key, null, Criteria::ISNULL);
			return $this;
		}
		return $this->addUsingAlias(UserPeer::ROLES, $roles, $comparison);
	}

	/**
	 * Filter the query on the roles column
	 * @param     mixed $roles The value to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByRole($roles = null, $comparison = null)
	{
		if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
			if (is_scalar($roles)) {
				$roles = '%| ' . $roles . ' |%';
				$comparison = Criteria::LIKE;
			}
		} elseif ($comparison == Criteria::CONTAINS_NONE) {
			$roles = '%| ' . $roles . ' |%';
			$comparison = Criteria::NOT_LIKE;
			$key = $this->getAliasedColName(UserPeer::ROLES);
			if($this->containsKey($key)) {
				$this->addAnd($key, $roles, $comparison);
			} else {
				$this->addAnd($key, $roles, $comparison);
			}
			$this->addOr($key, null, Criteria::ISNULL);
			return $this;
		}
		return $this->addUsingAlias(UserPeer::ROLES, $roles, $comparison);
	}

	/**
	 * Filter the query by a related Post object
	 *
	 * @param     Post $post  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPostRelatedByCreatedBy($post, $comparison = null)
	{
		if ($post instanceof Post) {
			return $this
				->addUsingAlias(UserPeer::ID, $post->getCreatedBy(), $comparison);
		} elseif ($post instanceof PropelCollection) {
			return $this
				->usePostRelatedByCreatedByQuery()
				->filterByPrimaryKeys($post->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByPostRelatedByCreatedBy() only accepts arguments of type Post or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the PostRelatedByCreatedBy relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinPostRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PostRelatedByCreatedBy');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'PostRelatedByCreatedBy');
		}

		return $this;
	}

	/**
	 * Use the PostRelatedByCreatedBy relation Post object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Acme\BlogBundle\Model\PostQuery A secondary query class using the current class as primary query
	 */
	public function usePostRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinPostRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PostRelatedByCreatedBy', '\Acme\BlogBundle\Model\PostQuery');
	}

	/**
	 * Filter the query by a related Post object
	 *
	 * @param     Post $post  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPostRelatedByPublishedBy($post, $comparison = null)
	{
		if ($post instanceof Post) {
			return $this
				->addUsingAlias(UserPeer::ID, $post->getPublishedBy(), $comparison);
		} elseif ($post instanceof PropelCollection) {
			return $this
				->usePostRelatedByPublishedByQuery()
				->filterByPrimaryKeys($post->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByPostRelatedByPublishedBy() only accepts arguments of type Post or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the PostRelatedByPublishedBy relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinPostRelatedByPublishedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PostRelatedByPublishedBy');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'PostRelatedByPublishedBy');
		}

		return $this;
	}

	/**
	 * Use the PostRelatedByPublishedBy relation Post object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Acme\BlogBundle\Model\PostQuery A secondary query class using the current class as primary query
	 */
	public function usePostRelatedByPublishedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinPostRelatedByPublishedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PostRelatedByPublishedBy', '\Acme\BlogBundle\Model\PostQuery');
	}

	/**
	 * Filter the query by a related Comment object
	 *
	 * @param     Comment $comment  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByComment($comment, $comparison = null)
	{
		if ($comment instanceof Comment) {
			return $this
				->addUsingAlias(UserPeer::ID, $comment->getCreatedBy(), $comparison);
		} elseif ($comment instanceof PropelCollection) {
			return $this
				->useCommentQuery()
				->filterByPrimaryKeys($comment->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByComment() only accepts arguments of type Comment or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the Comment relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinComment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Comment');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Comment');
		}

		return $this;
	}

	/**
	 * Use the Comment relation Comment object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Acme\BlogBundle\Model\CommentQuery A secondary query class using the current class as primary query
	 */
	public function useCommentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinComment($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Comment', '\Acme\BlogBundle\Model\CommentQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     User $user Object to remove from the list of results
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function prune($user = null)
	{
		if ($user) {
			$this->addUsingAlias(UserPeer::ID, $user->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

} // BaseUserQuery