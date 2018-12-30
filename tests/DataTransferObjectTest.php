<?php

declare(strict_types=1);

namespace Imbue\DataTransferObject\Tests;

use Imbue\DataTransferObject\DataTransferObject;
use Imbue\DataTransferObject\Tests\TestClasses\FooDataTransferObject;

class DataTransferObjectTest extends TestCase
{
    /** @test */
    public function only_returns_filtered_properties()
    {
        $object = new class() extends DataTransferObject
        {
            protected $foo;
            protected $bar;

            public function setFoo(int $foo)
            {
                $this->foo = $foo;
            }

            public function setBar(int $bar)
            {
                $this->bar = $bar;
            }
        };

        $object->setFoo(1);
        $object->setBar(2);

        $this->assertEquals(['foo' => 1], $object->only('foo')->toArray());
    }

    /** @test */
    public function except_returns_filtered_properties()
    {
        $object = new class() extends DataTransferObject
        {
            protected $foo;
            protected $bar;

            public function setFoo(int $foo)
            {
                $this->foo = $foo;
            }

            public function setBar(int $bar)
            {
                $this->bar = $bar;
            }
        };

        $object->setFoo(1);
        $object->setBar(2);

        $this->assertEquals(['foo' => 1], $object->except('bar')->toArray());
    }

    /** @test */
    public function all_returns_all_properties()
    {
        $object = new class() extends DataTransferObject
        {
            protected $foo;
            protected $bar;

            public function setFoo($foo)
            {
                $this->foo = $foo;
            }

            public function setBar($bar)
            {
                $this->bar = $bar;
            }
        };

        $object->setFoo(1);
        $object->setBar(2);

        $this->assertEquals(['foo' => 1, 'bar' => 2], $object->toArray());
    }

    /** @test */
    public function default_values_are_supported()
    {
        $valueObject = new class() extends DataTransferObject
        {
            protected $foo = 'abc';
            protected $bar;

            public function getFoo()
            {
                return $this->foo;
            }

            public function getBar()
            {
                return $this->bar;
            }

            public function setFoo($foo)
            {
                $this->foo = $foo;
            }

            public function setBar($bar)
            {
                $this->bar = $bar;
            }
        };

        $this->assertEquals(['foo' => 'abc', 'bar' => null], $valueObject->toArray());
    }

    /** @test */
    public function float_is_supported()
    {
        $object = new class() extends DataTransferObject
        {
            protected $foo;

            public function setFoo(float $foo)
            {
                $this->foo = $foo;
            }
        };

        $object->setFoo(3.5);

        $this->markTestSucceeded();
    }

    /** @test */
    public function string_is_supported()
    {
        $object = new class() extends DataTransferObject
        {
            protected $foo;

            public function setFoo(string $foo)
            {
                $this->foo = $foo;
            }
        };

        $object->setFoo('foo');

        $this->markTestSucceeded();
    }

    /** @test */
    public function array_is_supported()
    {
        $object = new class() extends DataTransferObject
        {
            protected $foo;

            public function setFoo(array $foo)
            {
                $this->foo = $foo;
            }
        };

        $object->setFoo(['foo' => 'bar']);

        $this->markTestSucceeded();
    }

    /** @test */
    public function int_is_supported()
    {
        $object = new class() extends DataTransferObject
        {
            protected $foo;

            public function setFoo(int $foo)
            {
                $this->foo = $foo;
            }
        };

        $object->setFoo(101);

        $this->markTestSucceeded();
    }

    /** @test */
    public function nested_data_transfer_object_is_supported()
    {
        $object = new class() extends DataTransferObject
        {
            protected $acme;
            protected $foo;

            public function setAcme(string $acme)
            {
                $this->acme = $acme;
            }

            public function setFoo(FooDataTransferObject $foo)
            {
                $this->foo = $foo;
            }
        };

        $fooObject = new FooDataTransferObject();
        $fooObject->setBar('xyz');

        $object->setAcme('abc');
        $object->setFoo($fooObject);

        $this->assertEquals(
            [
                'acme' => 'abc',
                'foo' => [
                    'bar' => 'xyz'
                ]
            ],
            $object->toArray()
        );
    }

    public function transform_to_json_is_supported()
    {
        $object = new class() extends DataTransferObject
        {
            protected $foo;

            public function setFoo(array $foo)
            {
                $this->foo = $foo;
            }
        };

        $object->setFoo(['foo' => 'bar']);

        $this->assertJsonStringEqualsJsonString(
            \json_encode(['foo' => 'bar']),
            $object->toJson()
        );
    }
}
