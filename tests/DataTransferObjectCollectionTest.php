<?php

namespace Imbue\DataTransferObject\Tests;

use Imbue\DataTransferObject\DataTransferObjectCollection;
use Imbue\DataTransferObject\Tests\TestClasses\FooDataTransferObject;

class DataTransferObjectCollectionTest extends TestCase
{
    /** @test */
    public function it_can_hold_objects_of_a_certain_type()
    {
        $objectOne = new FooDataTransferObject();
        $objectTwo = new FooDataTransferObject();
        $objectThree = new FooDataTransferObject();

        $objects = [
            $objectOne,
            $objectTwo,
            $objectThree
        ];

        $collection = new class($objects) extends DataTransferObjectCollection
        {
        };

        $this->assertCount(3, $collection);
    }

    /** @test */
    public function it_can_hold_objects_of_a_certain_type_with_values()
    {
        $objectOne = new FooDataTransferObject();
        $objectOne->setBar('aaa');
        $objectTwo = new FooDataTransferObject();
        $objectTwo->setBar('bbb');
        $objectThree = new FooDataTransferObject();
        $objectThree->setBar('ccc');

        $objects = [
            $objectOne,
            $objectTwo,
            $objectThree
        ];

        $collection = new class($objects) extends DataTransferObjectCollection
        {
        };

        $this->assertEquals([
            [
                'bar' => 'aaa',
            ],
            [
                'bar' => 'bbb',
            ],
            [
                'bar' => 'ccc',
            ]
        ],
            $collection->toArray()
        );
    }

    /** @test */
    public function transform_collection_to_json_is_supported()
    {
        $objectOne = new FooDataTransferObject();
        $objectOne->setBar('aaa');
        $objectTwo = new FooDataTransferObject();
        $objectTwo->setBar('bbb');

        $objects = [
            $objectOne,
            $objectTwo,
        ];

        $collection = new class($objects) extends DataTransferObjectCollection
        {
        };

        $this->assertJsonStringEqualsJsonString(
            \json_encode([
                [
                    'bar' => 'aaa',
                ],
                [
                    'bar' => 'bbb',
                ]
            ]),
            $collection->toJson()
        );
    }
}
