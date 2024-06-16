<?php

namespace Tests;

use Symfony\Component\VarDumper\VarDumper;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function dd($value)
    {
        VarDumper::dump($value);

        exit(1);
    }
}

