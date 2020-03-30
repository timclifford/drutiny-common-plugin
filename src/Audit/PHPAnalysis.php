<?php

namespace Drutiny\Common\Audit;

use Drutiny\Audit;
use Drutiny\Sandbox\Sandbox;
use Drutiny\Annotation\Param;
use Drutiny\Annotation\Token;

/**
 *
 */
class PHPAnalysis extends Audit {

  /**
   * @inheritdoc
   */
  public function audit(Sandbox $sandbox) {

//    $ini = $sandbox->drush(['format' => 'json'])->evaluate(function () {
//      return ini_get_all();
//    });
//    $setting = $sandbox->getParameter('setting');

    $command = 'php -v | grep ^PHP | cut -d\' \' -f2';

    //Debug: print_r($command);
    $output = (string) $sandbox->exec($command);

    if (empty($output)) {
      return FALSE;
    }

    $sandbox->setParameter('setting', $output);

    return TRUE;
  }
}
