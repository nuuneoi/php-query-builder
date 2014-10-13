<?php

namespace PO\QueryBuilder\Statements;

use PO\QueryBuilder\Helper;
use PO\QueryBuilder\Clauses\Clause;
use PO\QueryBuilder\Clauses\DeleteClause;
use PO\QueryBuilder\Clauses\FromClause;
use PO\QueryBuilder\Clauses\GroupClause;

/**
 * Helper for building SELECT SQL
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Delete extends ConditionalStatement
{
    /**
     * @var SelectClause
     */
    protected $delete;

    /**
     * @var FromClause
     */
    protected $from;

    /**
     * @var GroupClause
     */
    protected $group;

    /**
     * Constructor
     * Set up statements
     */
    public function initialize()
    {
        parent::initialize();
        $this->delete = new DeleteClause($this);
        $this->from   = new FromClause($this);
        $this->group  = new GroupClause($this);
    }

    /**
     * Get the DELETE statement
     *
     * @return DeleteClause
     */
    public function getDelete()
    {
        return $this->delete;
    }

    /**
     * Get the FROM statement
     *
     * @return FromClause
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Get the GROUP statement
     *
     * @return GroupClause
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add params to the query statement
     *
     * @param  string|array $param
     * @return self
     */
    public function delete($param)
    {
        $this->getDelete()->addParams((array) $param);

        return $this;
    }

    /**
     * Get the statements in the order they should be rendered
     *
     * @return array[Clause]
     */
    public function getClauses()
    {
        return array(
            $this->getDelete(),
            $this->getFrom(),
            $this->getJoins(),
            $this->getWhere(),
            $this->getGroup(),
            $this->getOrder(),
            $this->getLimit(),
        );
    }

    /**
     * Set the from statement
     *
     * @param array|string
     * @return self
     */
    public function from($params)
    {
        $this->getFrom()->setParams((array) $params);

        return $this;
    }

    /**
     * Add group by
     * I.E.
     *
     * $this->groupBy('foo')->groupBy('bar DESC')->groupBy(array('foobar'));
     *
     * @param  string $params the field and direction to order by
     * @return self
     */
    public function groupBy($params)
    {
        $this->getGroup()->addParams((array) $params);

        return $this;
    }
}
