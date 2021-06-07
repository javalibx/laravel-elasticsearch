<?php
declare(strict_types=1);

namespace Golly\Elastic\Aggregations\Metric;

/**
 * Class AvgAggregation
 * @package Golly\Elastic\Aggregations\Metric
 */
class AvgAggregation extends StatsAggregation
{

    /**
     * @var string
     */
    protected string $type = 'avg';
}
