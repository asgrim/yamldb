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

## Doctrine DBAL Driver

You can now use YamlDb as a Doctrine DBAL driver. Note that not all queries are supported.

```php
use Asgrim\YamlDb\Database\FlysystemBackedYamlDb;
use Asgrim\YamlDb\Doctrine\YamlDbDriver;
use Asgrim\YamlDb\YamlDb;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

$doctrineConnection = DriverManager::getConnection(
    [
        'driverClass' => YamlDbDriver::class,
        YamlDb::class => new FlysystemBackedYamlDb(new Filesystem(new Local('/var/lib/yamldb'))),
    ],
    new Configuration()
);

$doctrineConnection->insert('myGreatTable', ['foo' => 'bar']);
```

## Why

Why not.

