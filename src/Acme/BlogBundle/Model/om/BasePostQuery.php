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
use Acme\BlogBundle\Model\PostPeer;
use Acme\BlogBundle\Model\PostQuery;
use Acme\BlogBundle\Model\User;

/**
 * Base class that represents a query for the 'posts' table.
 *
 * 
 *
 * @method     PostQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     PostQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     PostQuery orderBySlug($order = Criteria::ASC) Order by the slug column
 * @method     PostQuery orderByExcerpt($order = Criteria::ASC) Order by the excerpt column
 * @method     PostQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     PostQuery orderByPublished($order = Criteria::ASC) Order by the published column
 * @method     PostQuery orderByLocked($order = Criteria::ASC) Order by the locked column
 * @method     PostQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     PostQuery orderByPublishedBy($order = Criteria::ASC) Order by the published_by column
 * @method     PostQuery orderByLockedBy($order = Criteria::ASC) Order by the locked_by column
 *
 * @method     PostQuery groupById() Group by the id column
 * @method     PostQuery groupByTitle() Group by the title column
 * @method     PostQuery groupBySlug() Group by the slug column
 * @method     PostQuery groupByExcerpt() Group by the excerpt column
 * @method     PostQuery groupByContent() Group by the content column
 * @method     PostQuery groupByPublished() Group by the published column
 * @method     PostQuery groupByLocked() Group by the locked column
 * @method     PostQuery groupByCreatedBy() Group by the created_by column
 * @method     PostQuery groupByPublishedBy() Group by the published_by column
 * @method     PostQuery groupByLockedBy() Group by the locked_by column
 *
 * @method     PostQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     PostQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     PostQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     PostQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     PostQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     PostQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     PostQuery leftJoinUserRelatedByPublishedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByPublishedBy relation
 * @method     PostQuery rightJoinUserRelatedByPublishedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByPublishedBy relation
 * @method     PostQuery innerJoinUserRelatedByPublishedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByPublishedBy relation
 *
 * @method     PostQuery leftJoinComment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comment relation
 * @method     PostQuery rightJoinComment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comment relation
 * @method     PostQuery innerJoinComment($relationAlias = null) Adds a INNER JOIN clause to the query using the Comment relation
 *
 * @method     Post findOne(PropelPDO $con = null) Return the first Post matching the query
 * @method     Post findOneOrCreate(PropelPDO $con = null) Return the first Post matching the query, or a new Post object populated from the query conditions when no match is found
 *
 * @method     Post findOneById(int $id) Return the first Post filtered by the id column
 * @method     Post findOneByTitle(string $title) Return the first Post filtered by the title column
 * @method     Post findOneBySlug(string $slug) Return the first Post filtered by the slug column
 * @method     Post findOneByExcerpt(string $excerpt) Return the first Post filtered by the excerpt column
 * @method     Post findOneByContent(string $content) Return the first Post filtered by the content column
 * @method     Post findOneByPublished(boolean $published) Return the first Post filtered by the published column
 * @method     Post findOneByLocked(boolean $locked) Return the first Post filtered by the locked column
 * @method     Post findOneByCreatedBy(int $created_by) Return the first Post filtered by the created_by column
 * @method     Post findOneByPublishedBy(int $published_by) Return the first Post filtered by the published_by column
 * @method     Post findOneByLockedBy(int $locked_by) Return the first Post filtered by the locked_by column
 *
 * @method     array findById(int $id) Return Post objects filtered by the id column
 * @method     array findByTitle(string $title) Return Post objects filtered by the title column
 * @method     array findBySlug(string $slug) Return Post objects filtered by the slug column
 * @method     array findByExcerpt(string $excerpt) Return Post objects filtered by the excerpt column
 * @method     array findByContent(string $content) Return Post objects filtered by the content column
 * @method     array findByPublished(boolean $published) Return Post objects filtered by the published column
 * @method     array findByLocked(boolean $locked) Return Post objects filtered by the locked column
 * @method     array findByCreatedBy(int $created_by) Return Post objects filtered by the created_by column
 * @method     array findByPublishedBy(int $published_by) Return Post objects filtered by the published_by column
 * @method     array findByLockedBy(int $locked_by) Return Post objects filtered by the locked_by column
 *
 * @package    propel.generator.src.Acme.BlogBundle.Model.om
 */
abstract class BasePostQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BasePostQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Acme\\BlogBundle\\Model\\Post', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new PostQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    PostQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof PostQuery) {
			return $criteria;
		}
		$query = new PostQuery();
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
	 * @return    Post|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = PostPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(PostPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return    Post A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `TITLE`, `SLUG`, `EXCERPT`, `PUBLISHED`, `LOCKED`, `CREATED_BY`, `PUBLISHED_BY`, `LOCKED_BY` FROM `posts` WHERE `ID` = :p0';
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
			$obj = new Post();
			$obj->hydrate($row);
			PostPeer::addInstanceToPool($obj, (string) $key);
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
	 * @return    Post|array|mixed the result, formatted by the current formatter
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
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(PostPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(PostPeer::ID, $keys, Criteria::IN);
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
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(PostPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the title column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
	 * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $title The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByTitle($title = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($title)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $title)) {
				$title = str_replace('*', '%', $title);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PostPeer::TITLE, $title, $comparison);
	}

	/**
	 * Filter the query on the slug column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterBySlug('fooValue');   // WHERE slug = 'fooValue'
	 * $query->filterBySlug('%fooValue%'); // WHERE slug LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $slug The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterBySlug($slug = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($slug)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $slug)) {
				$slug = str_replace('*', '%', $slug);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PostPeer::SLUG, $slug, $comparison);
	}

	/**
	 * Filter the query on the excerpt column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByExcerpt('fooValue');   // WHERE excerpt = 'fooValue'
	 * $query->filterByExcerpt('%fooValue%'); // WHERE excerpt LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $excerpt The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByExcerpt($excerpt = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($excerpt)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $excerpt)) {
				$excerpt = str_replace('*', '%', $excerpt);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PostPeer::EXCERPT, $excerpt, $comparison);
	}

	/**
	 * Filter the query on the content column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
	 * $query->filterByContent('%fooValue%'); // WHERE content LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $content The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByContent($content = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($content)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $content)) {
				$content = str_replace('*', '%', $content);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PostPeer::CONTENT, $content, $comparison);
	}

	/**
	 * Filter the query on the published column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByPublished(true); // WHERE published = true
	 * $query->filterByPublished('yes'); // WHERE published = true
	 * </code>
	 *
	 * @param     boolean|string $published The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByPublished($published = null, $comparison = null)
	{
		if (is_string($published)) {
			$published = in_array(strtolower($published), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(PostPeer::PUBLISHED, $published, $comparison);
	}

	/**
	 * Filter the query on the locked column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByLocked(true); // WHERE locked = true
	 * $query->filterByLocked('yes'); // WHERE locked = true
	 * </code>
	 *
	 * @param     boolean|string $locked The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByLocked($locked = null, $comparison = null)
	{
		if (is_string($locked)) {
			$locked = in_array(strtolower($locked), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(PostPeer::LOCKED, $locked, $comparison);
	}

	/**
	 * Filter the query on the created_by column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByCreatedBy(1234); // WHERE created_by = 1234
	 * $query->filterByCreatedBy(array(12, 34)); // WHERE created_by IN (12, 34)
	 * $query->filterByCreatedBy(array('min' => 12)); // WHERE created_by > 12
	 * </code>
	 *
	 * @see       filterByUserRelatedByCreatedBy()
	 *
	 * @param     mixed $createdBy The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByCreatedBy($createdBy = null, $comparison = null)
	{
		if (is_array($createdBy)) {
			$useMinMax = false;
			if (isset($createdBy['min'])) {
				$this->addUsingAlias(PostPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdBy['max'])) {
				$this->addUsingAlias(PostPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PostPeer::CREATED_BY, $createdBy, $comparison);
	}

	/**
	 * Filter the query on the published_by column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByPublishedBy(1234); // WHERE published_by = 1234
	 * $query->filterByPublishedBy(array(12, 34)); // WHERE published_by IN (12, 34)
	 * $query->filterByPublishedBy(array('min' => 12)); // WHERE published_by > 12
	 * </code>
	 *
	 * @see       filterByUserRelatedByPublishedBy()
	 *
	 * @param     mixed $publishedBy The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByPublishedBy($publishedBy = null, $comparison = null)
	{
		if (is_array($publishedBy)) {
			$useMinMax = false;
			if (isset($publishedBy['min'])) {
				$this->addUsingAlias(PostPeer::PUBLISHED_BY, $publishedBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($publishedBy['max'])) {
				$this->addUsingAlias(PostPeer::PUBLISHED_BY, $publishedBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PostPeer::PUBLISHED_BY, $publishedBy, $comparison);
	}

	/**
	 * Filter the query on the locked_by column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByLockedBy(1234); // WHERE locked_by = 1234
	 * $query->filterByLockedBy(array(12, 34)); // WHERE locked_by IN (12, 34)
	 * $query->filterByLockedBy(array('min' => 12)); // WHERE locked_by > 12
	 * </code>
	 *
	 * @param     mixed $lockedBy The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByLockedBy($lockedBy = null, $comparison = null)
	{
		if (is_array($lockedBy)) {
			$useMinMax = false;
			if (isset($lockedBy['min'])) {
				$this->addUsingAlias(PostPeer::LOCKED_BY, $lockedBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($lockedBy['max'])) {
				$this->addUsingAlias(PostPeer::LOCKED_BY, $lockedBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PostPeer::LOCKED_BY, $lockedBy, $comparison);
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User|PropelCollection $user The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = null)
	{
		if ($user instanceof User) {
			return $this
				->addUsingAlias(PostPeer::CREATED_BY, $user->getId(), $comparison);
		} elseif ($user instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(PostPeer::CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByUserRelatedByCreatedBy() only accepts arguments of type User or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function joinUserRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserRelatedByCreatedBy');

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
			$this->addJoinObject($join, 'UserRelatedByCreatedBy');
		}

		return $this;
	}

	/**
	 * Use the UserRelatedByCreatedBy relation User object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Acme\BlogBundle\Model\UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinUserRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRelatedByCreatedBy', '\Acme\BlogBundle\Model\UserQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User|PropelCollection $user The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByPublishedBy($user, $comparison = null)
	{
		if ($user instanceof User) {
			return $this
				->addUsingAlias(PostPeer::PUBLISHED_BY, $user->getId(), $comparison);
		} elseif ($user instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(PostPeer::PUBLISHED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByUserRelatedByPublishedBy() only accepts arguments of type User or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByPublishedBy relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function joinUserRelatedByPublishedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserRelatedByPublishedBy');

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
			$this->addJoinObject($join, 'UserRelatedByPublishedBy');
		}

		return $this;
	}

	/**
	 * Use the UserRelatedByPublishedBy relation User object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Acme\BlogBundle\Model\UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserRelatedByPublishedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserRelatedByPublishedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRelatedByPublishedBy', '\Acme\BlogBundle\Model\UserQuery');
	}

	/**
	 * Filter the query by a related Comment object
	 *
	 * @param     Comment $comment  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function filterByComment($comment, $comparison = null)
	{
		if ($comment instanceof Comment) {
			return $this
				->addUsingAlias(PostPeer::ID, $comment->getPostId(), $comparison);
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
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function joinComment($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function useCommentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinComment($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Comment', '\Acme\BlogBundle\Model\CommentQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Post $post Object to remove from the list of results
	 *
	 * @return    PostQuery The current query, for fluid interface
	 */
	public function prune($post = null)
	{
		if ($post) {
			$this->addUsingAlias(PostPeer::ID, $post->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

	// sluggable behavior
	
	/**
	 * Find one object based on its slug
	 *
	 * @param     string $slug The value to use as filter.
	 * @param     PropelPDO $con The optional connection object
	 *
	 * @return    Post the result, formatted by the current formatter
	 */
	public function findOneBySlug($slug, $con = null)
	{
		return $this->filterBySlug($slug)->findOne($con);
	}

} // BasePostQuery