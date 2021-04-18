<?php

namespace Drupal\poormans_uptime_checker\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Main controller for PMUC.
 *
 * @package Drupal\poormans_uptime_checker\Controller
 */
class PMUCController extends ControllerBase{

  private $database;
  private $config;

  public function __construct() {
    $this->database = \Drupal::service('database');
    $this->config = \Drupal::config('poormans_uptime_checker.settings');
  }

  public function status() {
    $data = [];
    $render_array = [];
    $hosts = $this->database->query("SELECT * FROM {pmuc_hosts}")->fetchAll();
    foreach ($hosts as $host) {
      $data[] = [
        'hostname' => $host->hostname,
        'check_type' => $host->check_type,
        'status' => $host->status ? 'Up' : 'Down',
        'last_error' => $host->last_error,
      ];
    }
    $render_array = [
      '#theme' => 'uptime-status',
      '#items' => $data,
    ];
    return $render_array;
  }
}
