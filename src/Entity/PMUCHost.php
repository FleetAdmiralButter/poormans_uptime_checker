<?php

namespace Drupal\poormans_uptime_checker\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\poormans_uptime_checker\PMUCHostInterface;

/**
 * Defines the Example entity.
 *
 * @ConfigEntityType(
 *   id = "PMUChost",
 *   label = @Translation("Poor Mans Uptime Checker Host Configuration Entity"),
 *   handlers = {
 *     "list_builder" = "Drupal\example\Controller\ExampleListBuilder",
 *     "form" = {
 *       "add" = "Drupal\example\Form\ExampleForm",
 *       "edit" = "Drupal\example\Form\ExampleForm",
 *       "delete" = "Drupal\example\Form\ExampleDeleteForm",
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
 *     "status",
 *     "last_error"
 *   },
 *   links = {
 *     "edit-form" = "/admin/config/system/example/{example}",
 *     "delete-form" = "/admin/config/system/example/{example}/delete",
 *   }
 * )
 */
class Example extends ConfigEntityBase implements PMUCHostInterface {

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $label;

    protected $hostname;
    protected $status;
    protected $last_error;

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
        return $this->last_error;
    }

    public function setLastError($error) {
        $this->last_error = $error;
    }
}
