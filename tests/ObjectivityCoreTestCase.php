<?php

namespace Fifthgate\Objectivity\Core\Tests;

use Orchestra\Testbench\TestCase;
use Fifthgate\SmartMenu\SmartMenuServiceProvider;
use Fifthgate\SmartMenu\Service\Interfaces\MenuServiceInterface;

abstract class ObjectivityCoreTestCase extends TestCase {

	protected $menuService;

	protected $testMenuArray = [
        "mainMenu" => [
            "title" => "Main Menu",
            "items" => [
                "home" => [
                    "link_text" => "Home",
                    "href" => "/",
                    "weight" => 1
                ],
                "subItem" => [
                    "link_text" => "Sub Item",
                    "href" => "/subitem",
                    "weight" => 2,
                    "children" => [
                        "child1" => [
                            "link_text" => "Child 1",
                            "href" => "/subitem/child1",
                            "weight" => 1
                        ],
                        "child2" => [
                            "link_text" => "Child 2",
                            "href" => "/subitem/child2",
                            "weight" => 2
                        ]
                    ]
                ]
            ]
        ]
    ];
    
  	protected function getPackageProviders($app) {
	    /*return [
	    	SmartMenuServiceProvider::class
	    ];*/
	}

	protected function getEnvironmentSetUp($app)
	{
		$app['config']->set('key', 'base64:j84cxCjod/fon4Ks52qdMKiJXOrO5OSDBpXjVUMz61s=');
	    // Setup default database to use sqlite :memory:
	    $app['config']->set('database.default', 'testbench');
	    $app['config']->set('database.connections.testbench', [
	        'driver'   => 'sqlite',
	        'database' => ':memory:',
	        'prefix'   => '',
	    ]);
	    //$app['config']->set('smartmenu', $this->testMenuArray);
	}

	/**
	 * Setup the test environment.
	 */
	protected function setUp(): void {
	    parent::setUp();
		//$this->menuService = $this->app->get(MenuServiceInterface::class);
	}
}