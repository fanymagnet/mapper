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
    public function __construct(array $map)
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
        if (class_exists($class) === false) {
            $class = stdClass::class;
        }

        /* @var object $object */
        $object = new $class();

        foreach ($data as $index => $value) {
            if (property_exists($object, $index) === false && $object instanceof stdClass === false) {
                continue;
            }

            if (is_array($value) === true && $this->isAssociative($value) === true) {
                $object->{$index} = $this->map($this->map[$index] ?? stdClass::class, $value);
            } else {
                $object->{$index} = $value;
            }
        }

        return $object;
    }

    /**
     * @param array $data
     * @return bool
     */
    private function isAssociative(array &$data): bool
    {
        return array_keys($data) !== range(0, count($data) - 1);
    }
}
