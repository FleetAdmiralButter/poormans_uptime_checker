<?php

namespace Drupal\poormans_uptime_checker\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Site\Settings;
class PMUCConfigForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'poormans_uptime_checker_config_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
      $form = parent::buildForm($form, $form_state);
      $config = $this->config('poormans_uptime_checker.settings');

      $form['data'] = [
        '#type' => 'textarea',
        '#title' => $this->t('Domain List'),
        '#default_value' => '',
        '#description' => $this->t('Enter a list of HTTP hosts to check for uptime.'),
      ];

      $form['timeout'] = [
        '#type' => 'number',
        '#title' => $this->t('Threshold'),
        '#default_value' => $config->get('timeout'),
        '#description' => $this->t('Amount of time to wait for a response from a host before timing out.'),
      ];

      return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
      $pattern = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
      $host_list = $form_state->getValue('data');
      $host_list = explode(PHP_EOL, $host_list);
      foreach ($host_list as $host) {
        if (!preg_match($pattern, $host)) {
          $form_state->setErrorByName('data', $this->t('Hosts must be in the form of https://subdomain.example.com or http://subdomain.example.com.'));

          // Return on first failed validation.
          return;
        }
      }
    }

    /**
     * {@inheritdoc}
     */
    public function getEditableConfigNames() {

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      $database = \Drupal::database();
      $database->truncate('pmuc_hosts')->execute();

      $host_list = $form_state->getValue('data');

      $host_list = explode(PHP_EOL, $host_list);


      foreach ($host_list as $host) {
        $database->insert('pmuc_hosts')
          ->fields([
            'hostname' => str_replace(array("\n", "\t", "\r"), '', $host),
            'check_type' => 'http',
            'last_error' => 'No known outages.',
            'status' => null,
          ])
          ->execute();
      }

      return parent::submitForm($form, $form_state);
    }
}
