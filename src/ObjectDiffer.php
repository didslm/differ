<?php

namespace Didslm\Differ;

class ObjectDiffer implements DifferInterface
{

    public function __construct(private object|array|null $baseObject = null){}

    public function setBase(object|array $base): self
    {
        $this->baseObject = $base;

        return $this;
    }

    public function compare(object|array $compare): bool
    {
        return md5(serialize($this->baseObject)) !== md5(serialize($compare));
    }

    public function hasChanges(object|array $obj): bool
    {
        if (!is_array($obj) && get_class($this->baseObject) !== get_class($obj)) {
            throw new \TypeError('Cannot compare two different objects');
        }

        if (is_object($this->baseObject) xor is_object($obj)) {
            throw new \TypeError('Cannot compare two different types');
        }

        return $this->compare($obj);
    }

    public function getChanges(object|array $obj): array
    {
        if ($this->hasChanges($obj) === false) {
            return [];
        }

        $changes = [];

        if (is_array($this->baseObject)) {
            $changes = $this->compareArrays($this->baseObject, $obj);
        } else {
            $changes = $this->compareObjects($this->baseObject, $obj);
        }

        return $changes;
    }

    private function compareArrays(array $base, array $compare): array
    {
        $changes = [];

        foreach ($base as $key => $value) {
            if (!array_key_exists($key, $compare)) {
                $changes[$key] = ['old' => $value, 'new' => null];
                continue;
            }

            if ($value !== $compare[$key]) {
                $changes[$key] = ['old' => $value, 'new' => $compare[$key]];
            }
        }

        foreach ($compare as $key => $value) {
            if (!array_key_exists($key, $base)) {
                $changes[$key] = ['old' => null, 'new' => $value];
            }
        }

        return $changes;
    }

    private function compareObjects(object $base, object $compare): array
    {
        $changes = [];

        $baseProperties = get_object_vars($base);
        $compareProperties = get_object_vars($compare);

        foreach ($baseProperties as $key => $value) {
            if (!array_key_exists($key, $compareProperties)) {
                $changes[$key] = ['old' => $value, 'new' => null];
                continue;
            }

            if ($value !== $compareProperties[$key]) {
                $changes[$key] = ['old' => $value, 'new' => $compareProperties[$key]];
            }
        }

        foreach ($compareProperties as $key => $value) {
            if (!array_key_exists($key, $baseProperties)) {
                $changes[$key] = ['old' => null, 'new' => $value];
            }
        }

        return $changes;
    }
}
