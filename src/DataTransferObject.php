<?php

declare(strict_types=1);

namespace Imbue\DataTransferObject;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract class DataTransferObject
{
    /** @var array */
    private $exceptKeys = [];
    /** @var array */
    private $onlyKeys = [];

    /**
     * @return array
     * @throws ReflectionException
     */
    private function all(): array
    {
        $data = [];

        $class = new ReflectionClass(static::class);
        $properties = $class->getProperties(ReflectionProperty::IS_PROTECTED);

        foreach ($properties as $reflectionProperty) {
            $reflectionProperty->setAccessible(true);
            $data[$reflectionProperty->getName()] = $reflectionProperty->getValue($this);
        }

        return $data;
    }

    /**
     * @param string ...$keys
     * @return DataTransferObject
     */
    public function only(string ...$keys): DataTransferObject
    {
        $valueObject = clone $this;
        $valueObject->onlyKeys = array_merge($this->onlyKeys, $keys);

        return $valueObject;
    }

    /**
     * @param string ...$keys
     * @return DataTransferObject
     */
    public function except(string ...$keys): DataTransferObject
    {
        $valueObject = clone $this;
        $valueObject->exceptKeys = array_merge($this->exceptKeys, $keys);

        return $valueObject;
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    public function toJson(): string
    {
        return \json_encode($this->toArray());
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function toArray(): array
    {
        if (count($this->onlyKeys)) {
            $array = Arr::only($this->all(), $this->onlyKeys);
        } else {
            $array = Arr::except($this->all(), $this->exceptKeys);
        }

        $array = $this->parseArray($array);

        return $array;
    }

    /**
     * @param array $array
     * @return array
     * @throws ReflectionException
     */
    private function parseArray(array $array): array
    {
        foreach ($array as $key => $value) {
            if (
                $value instanceof DataTransferObject
                || $value instanceof DataTransferObjectCollection
            ) {
                $array[$key] = $value->toArray();
                continue;
            }

            if (!is_array($value)) {
                continue;
            }

            $array[$key] = $this->parseArray($value);
        }

        return $array;
    }
}
