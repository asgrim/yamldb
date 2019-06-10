# YamlDb

Note: this is a silly project, not intended for production.

This library allows you to use a YAML file as a database in a PHP project.

[![CircleCI](https://circleci.com/gh/asgrim/yamldb/tree/master.svg?style=svg)](https://circleci.com/gh/asgrim/yamldb/tree/master)

## Installation

Install with `composer require asgrim/yamldb`.

## Usage

```php
$yamlDb = new \Asgrim\YamlDb\YamlDb('storage.yaml');

$generatedId = $yamlDb->insert(['foo' => 'bar']);

// Later...

$myData = $yamlDb->findById($generatedId); // ['foo' => 'bar']
```

## Why

Why not.

