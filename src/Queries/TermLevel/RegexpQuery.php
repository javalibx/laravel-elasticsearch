<?php
declare(strict_types=1);

namespace Golly\Elastic\Queries\TermLevel;


use Golly\Elastic\Queries\Query;

/**
 * Class RegexpQuery
 * @package Golly\Elastic\Queries\TermLevel
 */
class RegexpQuery extends Query
{

    /**
     * RegexpQuery constructor.
     * @param string $field
     * @param string $regexpValue
     * @param array $params
     */
    public function __construct(string $field, string $regexpValue, array $params = [])
    {
        $this->field = $field;
        $this->value = $regexpValue;
        $this->setParams($params);
    }


    /**
     * @return string
     */
    public function getType(): string
    {
        return 'regexp';
    }

    /**
     * @return array
     */
    public function getTypeValue(): array
    {
        return [
            $this->field => $this->merge([
                'value' => $this->value,
            ]),
        ];
    }
}
