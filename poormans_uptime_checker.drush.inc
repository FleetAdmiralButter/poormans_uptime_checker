<?php

/**
 * @file
 * Drush integration.
 */

use Drupal\poormans_uptime_checker\Controller\PMUCController;

/**
 * Implements hook_drush_help().
 */
function poormans_uptime_checker_drush_help($section) {
  switch ($section) {
    case 'pmuc-check-all':
      return dt('Runs an uptime check against all hosts.');
  }
}

/**
 * Implements hook_drush_command().
 */
function poormans_uptime_checker_drush_command() {
  $cmd = [];
  $cmd['pmuc-check-all'] = [
    'description' => dt('Runs an uptime check against all hosts.'),
  ];

  return $cmd;
}

function drush_poormans_uptime_checker_pmuc_check_all() {
  \Drupal::service('poormans_uptime_checker.checker')->check_all();
}
