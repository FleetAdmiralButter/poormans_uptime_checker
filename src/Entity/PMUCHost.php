<?php

namespace Drupal\poormans_uptime_checker\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\poormans_uptime_checker\PMUCHostInterface;

/**
 * Defines the PMUCHost entity.
 *
 * @ConfigEntityType(
 *   id = "PMUCHost",
 *   label = @Translation("Poor Mans Uptime Checker Host Configuration Entity"),
 *   handlers = {
 *     "list_builder" = "Drupal\poormans_uptime_checker\Controller\PMUCHostListBuilder",
 *     "form" = {
 *       "add" = "Drupal\poormans_uptime_checker\Form\PMUCHostForm",
 *       "edit" = "Drupal\poormans_uptime_checker\Form\PMUCHostForm",
 *       "delete" = "Drupal\poormans_uptime_checker\Form\PMUCHostDeleteForm",
 *     }
 *   },
 *   config_prefix = "pmuc",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "hostname",
 *   },
 *   links = {
 *     "edit-form" = "/admin/config/pmuc/pmuchost/{PMUCHost}",
 *     "delete-form" = "/admin/config/pmuc/pmuchost/{PMUCHost}/delete",
 *   }
 * )
 */
class PMUCHost extends ConfigEntityBase implements PMUCHostInterface {

    protected $id;
    protected $hostname;
    protected $status;
    protected $last_message;

    public function getHostname() {
        return $this->hostname;
    }

    public function setHostname($host) {
        $this->hostname = $host;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getLastError() {
        return $this->last_message;
    }

    public function setLastError($error) {
        //drush_print('Hello '. $error);
        $this->last_message = $error;
    }
}
