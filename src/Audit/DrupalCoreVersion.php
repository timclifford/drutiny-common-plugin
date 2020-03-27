<?php

namespace Drutiny\Common\Audit;

use Drutiny\Audit;
use Drutiny\Sandbox\Sandbox;

/**
 *
 */
class DrupalCoreVersion extends Audit {

  /**
   * @inheritdoc
   */
  public function audit(Sandbox $sandbox) {

    $status = $sandbox->drush()->status();
    $stat = $sandbox->drush(['format' => 'json'])->status();
    $sandbox->setParameter('status', $stat);

    $command = array_values(preg_split("/[\s,]+/", $status));

    $output = $sandbox->exec('echo ' . $command[4]);

    if (empty($output)) {
     return FALSE;
    }

    $sandbox->setParameter('version', $output);

    return TRUE;
  }
}
