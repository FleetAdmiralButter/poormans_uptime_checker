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
        $header['last_error'] = $this->t('Last Known Error');
        return $header + parent::buildHeader();
    }

    /**
     * {@inheritdoc}
     */
    public function buildRow(EntityInterface $entity) {
        $row['hostname'] = $entity->getHostname();
        $row['status'] = $entity->getStatus();
        $row['last_error'] = $entity->getLastError();
        return $row + parent::buildRow($entity);
    }
}
