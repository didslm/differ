# Differ Library

This library provides a simple way to compare two objects and get a list of differences.

## Installation

```bash
composer require didslm/differ
```

## Usage

```php
use Didslm\Differ\Differ;

Differ::setBase($object);

//do some changes to $object

$changeSet = Differ::getChanges($object);
// $changeSet is an array of changes

$hasChanges = Differ::hasChanges($object1, $object2); // bool
```



