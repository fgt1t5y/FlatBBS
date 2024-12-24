<?php

namespace tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use \DI\ContainerBuilder;

class TestCase extends PHPUnitTestCase
{
    protected $container;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $builder = new ContainerBuilder();
        $builder->addDefinitions(config('dependence', []));
        $builder->useAttributes(true);
        $this->container = $builder->build();
    }

    public function __call($name, $arguments)
    {
        return $this->container->{$name}(...$arguments);
    }
}

