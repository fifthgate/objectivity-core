<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Tests;

use Orchestra\Testbench\TestCase;

abstract class ObjectivityCoreTestCase extends TestCase {

	protected function getEnvironmentSetUp($app): void
    {
		$app['config']->set('key', 'base64:j84cxCjod/fon4Ks52qdMKiJXOrO5OSDBpXjVUMz61s=');
	    // Setup default database to use sqlite :memory:
	    $app['config']->set('database.default', 'testbench');
	    $app['config']->set('database.connections.testbench', [
	        'driver'   => 'sqlite',
	        'database' => ':memory:',
	        'prefix'   => '',
	    ]);
	}
}