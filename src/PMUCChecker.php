<?php

namespace Drupal\poormans_uptime_checker;

use \GuzzleHttp\Exception\RequestException;
class PMUCChecker {
  private $database;
  private $config;
  private $http_client;
  private $entity_manager;

  public function __construct() {
    $this->database = \Drupal::service('database');
    $this->config = \Drupal::config('poormans_uptime_checker.settings');
    $this->http_client = \Drupal::service('http_client');
    $this->entity_manager = \Drupal::entityManager();
  }

  public function check_all() {
    // Load all config entities
     $hosts = $this->entity_manager->getStorage('PMUCHost')->loadMultiple();

     foreach($hosts as $host) {
         // Checking logic here
         $url = $host->getHostname();
         try {
             $request = $this->http_client->request('GET', $url);
             if ($request->getStatusCode() >= 200 && $request->getStatusCode() <300) {
                 // Success 200 response
                 $host->setStatus('Up');
                 $host->save();
             } else {
                 // Fail, set errors
                 $fail_reason = 'Request failed with status code ' . $request->getStatusCode();
                 $host->setStatus('Down');
                 $host->setFailReason($fail_reason);
                 $host->save();
             }
         } catch (RequestException $e) {
              // Connection error
             $host->setStatus('Down');
             $host->setFailReason($e->getMessage());
             $host->save();
         }
     }
  }
}
