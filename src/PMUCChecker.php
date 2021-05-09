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

  private function isStatusTransitioning($host, $next_status) {
    return (!($host->getStatus() === $next_status));
  }

  private function sendNotification($host, $next_status, $fail_reason = null) {
    // Only send email when status is being changed.
    if ($this->isStatusTransitioning($host, $next_status) && \Drupal::config('poormans_uptime_checker.settings')->get('email')) {
      $subject = $host->getHostname() . ' is ' . $next_status . '.';
      $body = ($next_status === 'Up') ? $host->getHostname() . ' is ' . $next_status : $host->getHostname() . ' is ' . $next_status . '. Request failed with ' . $fail_reason;
      $params['context']['subject'] = $subject;
      $params['context']['message'] = $body;
      $to = \Drupal::config('poormans_uptime_checker.settings')->get('email');
      \Drupal::service('plugin.manager.mail')->mail('poormans_uptime_checker', 'notification', $to, 'en', $params);
    }
  }

  public function check_all() {
    // Load all config entities
     $hosts = $this->entity_manager->getStorage('PMUCHost')->loadMultiple();

     foreach($hosts as $host) {
         // Checking logic here
         $url = $host->getHostname();
         try {
             $response = $this->http_client->request('GET', $url);
             if ($response->getStatusCode() >= 200 && $response->getStatusCode() <300) {
                 // Success 200 response
                 $this->sendNotification($host, 'Up');
                 $host->setStatus('Up');
                 $host->save();
             } else {
                 // Fail, set errors
                 $fail_reason = 'Request failed with status code ' . $response->getStatusCode();
                 $this->sendNotification($host, 'Down', $fail_reason);
                 $host->setStatus('Down');
                 $host->setFailReason($fail_reason);
                 $host->save();
             }
         } catch (RequestException $e) {
              // Check if the host returned any data.
             $fail_reason = $e->getMessage();
             $this->sendNotification($host, 'Down', $fail_reason);
             $host->setStatus('Down');
             $host->setFailReason($fail_reason);
             $host->save();
         }
     }
  }
}
