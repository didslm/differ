<?php

namespace Didslm\Differ\Tests;

use Didslm\Differ\ObjectDiffer;
use PHPUnit\Framework\TestCase;

class ObjectDifferTest extends TestCase
{
    public function testShouldCompareTwoArrays()
    {
        $objectDiffer = new ObjectDiffer();
        $objectDiffer->setBase(['foo' => 'bar']);
        $this->assertTrue($objectDiffer->hasChanges(['foo' => 'baz']));
    }

    public function testShouldCompareTwoObjectsStates()
    {
        $baseObject = (object) ['name' => 'John', 'age' => 30];
        $compareObject = (object) ['name' => 'John', 'age' => 30];

        $objectDiffer = new ObjectDiffer();
        $objectDiffer->setBase($baseObject);
        $this->assertFalse($objectDiffer->hasChanges($compareObject));
    }

    public function testShouldDetectChanges()
    {
        // Test case 2: Changes detected
        $baseObject = (object) ['name' => 'John', 'age' => 23];
        $compareObject = (object) ['name' => 'Jane', 'age' => 30];

        $objectDiffer = new ObjectDiffer();
        $objectDiffer->setBase($baseObject);
        $this->assertCount(2, $objectDiffer->getChanges($compareObject));
        $this->assertTrue($objectDiffer->hasChanges($compareObject));
    }

    public function testShouldDetectChangesFromArray()
    {
        $baseObject = ['name' => 'John', 'age' => 23];
        $compareObject = ['name' => 'Jane', 'age' => 30];

        $objectDiffer = new ObjectDiffer();
        $objectDiffer->setBase($baseObject);
        $this->assertCount(2, $objectDiffer->getChanges($compareObject));
        $this->assertTrue($objectDiffer->hasChanges($compareObject));
    }

    public function testShouldFailWhenComparingTwoDifferentObjects()
    {
        $baseObject = new \stdClass();
        $compareObject = [];

        $objectDiffer = new ObjectDiffer();
        $objectDiffer->setBase($baseObject);
        $this->expectException(\TypeError::class);
        $objectDiffer->hasChanges($compareObject);
    }


}
