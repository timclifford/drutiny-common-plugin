<?php

namespace DrutinyTests\Audit;

use Drutiny\Common\Audit\DrupalCoreVersion;
use Drutiny\Container;
use Drutiny\Policy;
use Drutiny\Sandbox\Sandbox;
use Drutiny\Target\Registry as TargetRegistry;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class DrupalCoreVersionTest extends TestCase {

  protected $target;

  public function __construct()
  {
    Container::setLogger(new NullLogger());
    $this->target = TargetRegistry::getTarget('drush', '');
    parent::__construct();
  }

  public function testPass()
  {
    $policy = Policy::load('common:DrupalCoreVersion');
    $sandbox = new Sandbox($this->target, $policy);

    $sandbox->setParameter('version', '8.0.0');
    $response = $sandbox->run();

    $this->assertEquals(trim($response->getSuccess()), 'Core version: 8.0.0');
  }
}
