<?php

namespace Didslm\Differ;

class Differ
{
    public static function diff(object|array $base, object|array $compare): array
    {
        $differ = new ObjectDiffer();
        $differ->setBase($base);

        return $differ->getChanges($compare);
    }

    public static function hasChanges(object|array $base, object|array $compare): bool
    {
        $differ = new ObjectDiffer();
        $differ->setBase($base);

        return $differ->hasChanges($compare);
    }
}