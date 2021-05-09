<?php

namespace Drupal\poormans_uptime_checker\Controller;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of PMUCHost entities.
 */
class PMUCHostListBuilder extends ConfigEntityListBuilder {

    /**
     * {@inheritdoc}
     */
    public function buildHeader() {
        $header['hostname'] = $this->t('Hostname');
        $header['status'] = $this->t('Last Known Status');
        $header['fail_reason'] = $this->t('Last Error');
        return $header + parent::buildHeader();
    }

    /**
     * {@inheritdoc}
     */
    public function buildRow(EntityInterface $entity) {
        $row['hostname'] = $entity->getHostname();
        $row['status'] = $entity->getStatus();
        $row['fail_reason'] = $entity->getFailReason();
        return $row + parent::buildRow($entity);
    }
}
