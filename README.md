# YamlDb

Note: this is a silly project, not intended for production.

This library allows you to use a YAML file as a database in a PHP project.

[![CircleCI](https://circleci.com/gh/asgrim/yamldb/tree/master.svg?style=svg)](https://circleci.com/gh/asgrim/yamldb/tree/master)

## Installation

Install with `composer require asgrim/yamldb`.

## Usage

```php
use Asgrim\YamlDb\Database\FlysystemBackedYamlDb;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

$yamlDb = new FlysystemBackedYamlDb(new Filesystem(new Local('/var/lib/yamldb')));

$generatedId = $yamlDb->insert(['foo' => 'bar']);

// Later...

$myData = $yamlDb->findById($generatedId); // ['foo' => 'bar']
```

## Why

Why not.

