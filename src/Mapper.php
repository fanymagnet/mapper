<?php declare(strict_types = 0);

final class ArrayToObjectDataMapper
{
    public function __construct(
        private array $map = []
    ) {}

    public function map(string $class, array $data): object
    {
        $object = class_exists($class) ? new $class() : new stdClass();

        foreach ($data as $index => $value) {
            if (property_exists($object, $index) || $object instanceof stdClass) {
                $object->{$index} = is_array($value) && array_is_list($value)
                    ? $object->{$index} = $this->map($this->map[$index] ?? stdClass::class, $value)
                    : $value;
            }
        }

        return $object;
    }
}
