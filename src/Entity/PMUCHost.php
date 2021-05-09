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
 *     "hostname" = "hostname",
 *     "fail_reason" = "fail_reason",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "hostname",
 *     "fail_reason",
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
    protected $fail_reason;

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

    public function getFailReason()
    {
      return $this->fail_reason;
    }

    public function setFailReason($reason) {
      // Set the new value
      $this->set('fail_reason', $reason);
      return $this;
    }
}
