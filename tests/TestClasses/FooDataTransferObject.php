<?php

declare(strict_types=1);

namespace Imbue\DataTransferObject\Tests\TestClasses;

use Imbue\DataTransferObject\DataTransferObject;

class FooDataTransferObject extends DataTransferObject
{
    protected $bar;

    public function getBar()
    {
        return $this->bar;
    }

    public function setBar(string $bar)
    {
        $this->bar = $bar;
    }
}
