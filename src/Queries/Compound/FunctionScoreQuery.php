<?php
declare(strict_types=1);

namespace Golly\Elastic\Queries\Compound;

use Golly\Elastic\Contracts\QueryInterface;
use Golly\Elastic\Queries\Query;
use stdClass;

/**
 * Class FunctionScoreQuery
 * @package Golly\Elastic\Queries\Compound
 */
class FunctionScoreQuery extends Query
{

    /**
     * @var QueryInterface
     */
    protected QueryInterface $query;

    /**
     * @var array
     */
    protected array $functions = [];

    /**
     * FunctionScoreQuery constructor.
     * @param QueryInterface $query
     * @param array $params
     */
    public function __construct(QueryInterface $query, array $params = [])
    {
        $this->query = $query;
        $this->setParams($params);
    }

    /**
     * @param $source
     * @param array $params
     * @param array $options
     * @param QueryInterface|null $query
     * @return $this
     */
    public function addScriptScoreFunction(
        $source,
        array $params = [],
        array $options = [],
        QueryInterface $query = null
    ): self
    {
        $function = [
            'script_score' => [
                'script' => array_filter(
                    array_merge([
                        'lang' => 'painless',
                        'source' => $source,
                        'params' => $params
                    ], $options)
                )
            ],
        ];
        $this->applyToFunctions($function, $query);

        return $this;
    }

    /**
     * @param $field
     * @param $factor
     * @param string $modifier
     * @param QueryInterface|null $query
     * @param null $missing
     * @return $this
     */
    public function addFieldValueFactorFunction(
        $field,
        $factor,
        string $modifier = 'none',
        QueryInterface $query = null,
        $missing = null
    ): self
    {
        $function = [
            'field_value_factor' => array_filter([
                'field' => $field,
                'factor' => $factor,
                'modifier' => $modifier,
                'missing' => $missing
            ]),
        ];
        $this->applyToFunctions($function, $query);

        return $this;
    }

    /**
     * @param $weight
     * @param QueryInterface|null $query
     * @return $this
     */
    public function addWeightFunction($weight, QueryInterface $query = null): self
    {
        $function = [
            'weight' => $weight,
        ];
        $this->applyToFunctions($function, $query);

        return $this;
    }

    /**
     * @param null $seed
     * @param QueryInterface|null $query
     * @return $this
     */
    public function addRandomFunction($seed = null, QueryInterface $query = null): self
    {
        $function = [
            'random_score' => $seed ? ['seed' => $seed] : new stdClass(),
        ];
        $this->applyToFunctions($function, $query);

        return $this;
    }

    /**
     * @param $type
     * @param $field
     * @param array $function
     * @param array $options
     * @param QueryInterface|null $query
     * @param null $weight
     * @return $this
     */
    public function addDecayFunction(
        $type,
        $field,
        array $function,
        array $options = [],
        QueryInterface $query = null,
        $weight = null
    ): self
    {
        $function = array_filter([
            $type => array_merge(
                [$field => $function],
                $options
            ),
            'weight' => $weight,
        ]);
        $this->applyToFunctions($function, $query);

        return $this;
    }

    /**
     * @param array $function
     * @return $this
     */
    public function addSimpleFunction(array $function): self
    {
        $this->functions[] = $function;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'function_score';
    }

    /**
     * @return array
     */
    public function getTypeValue(): array
    {
        return $this->merge([
            'query' => $this->query->toArray(),
            'functions' => $this->functions,
        ]);
    }

    /**
     * @param array $function
     * @param QueryInterface|null $query
     * @return void
     */
    protected function applyToFunctions(array $function, QueryInterface $query = null): void
    {
        if ($query) {
            $function['filter'] = $query->toArray();
        }
        $this->functions[] = $function;
    }
}
