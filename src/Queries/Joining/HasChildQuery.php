<?php


namespace Golly\Elastic\Queries\Joining;


use Golly\Elastic\Contracts\QueryInterface;
use Golly\Elastic\Queries\Query;

/**
 * Class HasChildQuery
 * @package Golly\Elastic\Queries\Joining
 */
class HasChildQuery extends Query
{

    /**
     * @var string
     */
    protected $type;

    /**
     * @var QueryInterface
     */
    protected $query;

    /**
     * HasChildQuery constructor.
     * @param string $type
     * @param QueryInterface $query
     * @param array $params
     */
    public function __construct(string $type, QueryInterface $query, array $params = [])
    {
        $this->type = $type;
        $this->query = $query;
        $this->setParams($params);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'has_child';
    }

    /**
     * @return array
     */
    public function getOutput()
    {
        return $this->merge([
            'type' => $this->type,
            'query' => $this->query->toArray(),
        ]);
    }
}
