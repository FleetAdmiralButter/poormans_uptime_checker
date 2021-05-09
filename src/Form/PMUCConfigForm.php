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

      $form['cron'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Run with cron'),
        '#default_value' => $config->get('cron'),
        '#description' => $this->t('Run the uptime checker with Drupal cron (Not recommended).'),
      ];

      return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }

    /**
     * {@inheritdoc}
     */
    public function getEditableConfigNames() {
        return [
          'poormans_uptime_checker.settings'
          ];
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      $config = $this->config('poormans_uptime_checker.settings');
      $config->set('cron', $form_state->getValue('cron'));
      $config->save();

      return parent::submitForm($form, $form_state);
    }
}
