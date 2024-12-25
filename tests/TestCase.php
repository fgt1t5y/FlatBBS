<?php

namespace tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use \DI\ContainerBuilder;
use support\Container;

class TestCase extends PHPUnitTestCase
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $builder = new ContainerBuilder();
        $builder->addDefinitions(config('dependence', []));
        $builder->useAttributes(true);
        $this->container = $builder->build();
    }
}
