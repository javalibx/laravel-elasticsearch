<?php


namespace Golly\Elastic\Endpoints;


use Golly\Elastic\Contracts\EndpointInterface;
use Golly\Elastic\HasParams;
use Illuminate\Support\Str;

/**
 * Class Endpoint
 * @package Golly\Elastic\Endpoints
 */
abstract class Endpoint implements EndpointInterface
{
    use HasParams;

    /**
     * @var array
     */
    protected $containers = [];


    /**
     * @return array
     */
    public function normalize()
    {
        $output = [];
        foreach ($this->containers as $container) {
            $output[] = $container->toArray();
        }

        return $output;
    }

    /**
     * @return array
     */
    public function getContainers(): array
    {
        return $this->containers;
    }

    /**
     * @param array $containers
     * @return void
     */
    public function setContainers(array $containers)
    {
        $this->containers = $containers;
    }

    /**
     * @param $container
     * @param string|null $key
     * @return void
     */
    public function addContainer($container, string $key = null)
    {
        if ($key) {
            $this->containers[$key] = $container;
        } else {
            $this->containers[] = $container;
        }
    }

}