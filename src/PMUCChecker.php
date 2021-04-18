<?php

namespace Drupal\poormans_uptime_checker;

use \GuzzleHttp\Exception\RequestException;
class PMUCChecker {
  private $database;
  private $config;
  private $http_client;

  public function __construct() {
    $this->database = \Drupal::service('database');
    $this->config = \Drupal::config('poormans_uptime_checker.settings');
    $this->http_client = \Drupal::service('http_client');
  }

  // Quick and dirty to get this running.
  // Database queries and updates need to be rebuilt to be less dumb.
  public function check_all(){
    $fail_reason = '';
    $hosts = $this->database->query("SELECT * FROM {pmuc_hosts}")->fetchAll();
    foreach($hosts as $host) {
      try {
        $request = $this->http_client->request('GET', $host->hostname);
        if ($request->getStatusCode() >= 200 && $request->getStatusCode() <300) {
          // This query is garbage.
          $this->database->query("UPDATE {pmuc_hosts} SET status = 1  WHERE hostname = :hostname", [
            ':hostname' => $host->hostname
          ]);
        } else {
          $fail_reason = 'Request failed with status code ' . $request->getStatusCode();
          // This query is garbage.
          $this->database->query("UPDATE {pmuc_hosts} SET status = 0, last_error = :error WHERE hostname = :hostname", [
            ':error' => $fail_reason,
            ':hostname' => $host->hostname
          ]);
        }
      } catch (RequestException $e) {
        // This query is garbage.
        $this->database->query("UPDATE {pmuc_hosts} SET status = 0, last_error = :error WHERE hostname = :hostname", [
          ':error' => $e->getMessage(),
          ':hostname' => $host->hostname
        ]);
      }
    }
  }
}
