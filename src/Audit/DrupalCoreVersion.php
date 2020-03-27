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

     $status = $sandbox->drush(['format' => 'json'])->status();
     $rootPath = $status['root'];

     $test = [];

     // $command = "echo $rootPath";

     $command = <<<EOT
      stat=`{$status}`;
      echo "test";
      readarray -t array <<<"$(jq -r '.[]' <<<"$stat")"
      EOT;


     // Execute
     $output = $sandbox->exec($command);

     $version = $output;


     if (empty($version)) {
       return FALSE;
     }

     $sandbox->setParameter('version', $version);

     return TRUE;
  }

}
