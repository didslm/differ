<?php

namespace Didslm\Differ;

interface DifferInterface
{
    public function setBase(object|array $base): self;

    public function compare(object|array $compare): bool;

    public function hasChanges(object|array $obj): bool;

    public function getChanges(object|array $obj): array;
}