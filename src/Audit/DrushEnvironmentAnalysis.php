<?php

namespace Drutiny\Common\Audit;

use Drutiny\Audit;
use Drutiny\Sandbox\Sandbox;

/**
 *
 */
class DrushEnvironmentAnalysis extends Audit {

  /**
   * @inheritdoc
   */
  public function audit(Sandbox $sandbox) {

    //$status = $sandbox->drush()->status();
    $stat = $sandbox->drush(['format' => 'json'])->status();
    $sandbox->setParameter('status', $stat);

    //$command = array_values(preg_split("/[\s,]+/", $stat));

    //Debug: print_r($command);
    //$output = $sandbox->exec('echo ' . print_r($command));

    $output = [
      'version' => $sandbox->exec('echo ' . $stat['drupal-version']),
      'bootstrap_status' => $sandbox->exec('echo ' . $stat['bootstrap']),
      'theme' => $sandbox->exec('echo ' . $stat['theme']),
      'drush_version' => $sandbox->exec('echo ' . $stat['drush-version']),
    ];

    if (empty($output)) {
     return FALSE;
    }

    $sandbox->setParameter('info', $output);

    return TRUE;
  }
}
