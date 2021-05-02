<?php

namespace Drupal\poormans_uptime_checker;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining an PMUCHost entity.
 */
interface PMUCHostInterface extends ConfigEntityInterface {
    public function getHostname();

    public function setHostname($host);

    public function getStatus();

    public function setStatus($status);

    public function getLastError();

    public function setLastError($error);
}
