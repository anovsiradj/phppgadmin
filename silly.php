#!/usr/bin/env php
<?php

use Symfony\Component\Console\Output\Output;
use Symfony\Component\Filesystem\Filesystem;

require __DIR__ . '/vendor/autoload.php';

$app = new Silly\Application;

$app->command('index', function (Output $output) use ($app) {
	$app->runCommand('adodb', $output);
	$app->runCommand('clear');
});

/**
 * clear unused objects from packages in vendor (logs,docs,tests,etc),
 * because (maybe in the future) i need to publish it as an artifact.
 * 
 * @todo doit
 */
$app->command('clear', function () {
	// ...
});

/**
 * @link https://github.com/phppgadmin/phppgadmin/pull/31
 */
$app->command('adodb', function (Output $output) {
	$target = __DIR__ . '/libraries/adodb';
	$source = __DIR__ . '/vendor/adodb/adodb-php';

	$output->writeln(sprintf('[EXEC] %s => %s', $source, $target));

	$fs = new Filesystem;

	$fs->mirror($source, $target, null, [
		'copy_on_windows' => true,
		'override' => true,
		'delete' => true,
	]);

	$output->writeln('[DONE]');
});

$app->run();
