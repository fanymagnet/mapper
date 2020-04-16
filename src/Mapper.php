<?php declare(strict_types = 0);

namespace fanymagnet\mapper;

use stdClass;

use function property_exists;
use function class_exists;
use function array_keys;
use function is_array;
use function range;
use function count;

/**
 * Class Mapper
 * @package fanymagnet\mapper
 */
class Mapper
{
    /**
     * @var array
     */
    private array $map;

    /**
     * Mapper constructor.
     * @param array $map
     */
    public function __construct(array $map = [])
    {
        $this->map = $map;
    }

    /**
     * @param string $class
     * @param array $data
     * @return object
     */
    public function map(string $class, array $data): object
    {
        $object = $this->getObject($class);

        foreach ($data as $index => $value) {
            if (property_exists($object, $index) === true || $object instanceof stdClass === true) {
                $object->{$index} = is_array($value) === true && $this->isAssociative($value) === true
                    ? $object->{$index} = $this->map($this->map[$index] ?? stdClass::class, $value)
                    : $value;
            }
        }

        return $object;
    }

    /**
     * @param string $class
     * @return object
     */
    private function getObject(string $class): object
    {
        return class_exists($class) === true ? new $class() : new stdClass();
    }

    /**
     * @param array $data
     * @return bool
     */
    private function isAssociative(array $data): bool
    {
        return array_keys($data) !== range(0, count($data) - 1);
    }
}
