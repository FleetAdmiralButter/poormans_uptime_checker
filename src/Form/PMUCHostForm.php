<?php

namespace Drupal\poormans_uptime_checker\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form handler for the PMUCHost add and edit forms.
 */
class PMUCHostForm extends EntityForm {

    /**
     * Constructs an PMUCHostForm object.
     *
     * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
     *   The entityTypeManager.
     */
    public function __construct(EntityTypeManagerInterface $entityTypeManager) {
        $this->entityTypeManager = $entityTypeManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('entity_type.manager')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function form(array $form, FormStateInterface $form_state) {
        $form = parent::form($form, $form_state);

        $pmuchost = $this->entity;

        $form['id'] = [
            '#type' => 'machine_name',
            '#title' => 'Machine Name',
            '#default_value' => $pmuchost->id(),
            '#machine_name' => [
                'exists' => [$this, 'exist'],
            ],
            '#disabled' => !$pmuchost->isNew(),
        ];
        $form['hostname']  = [
            '#type' => 'textfield',
            '#title' => 'Hostname',
            '#maxlength' => 255,
            '#default_value' => $pmuchost->getHostname(),
            '#description' => $this->t("URL of the host to check."),
            '#required' => TRUE,
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $form, FormStateInterface $form_state) {
        $pmuchost = $this->entity;
        $pmuchost->setFailReason('No Error');
        $pmuchost->setStatus('Never Checked');
        $status = $pmuchost->save();

        if ($status === SAVED_NEW) {
            $this->messenger()->addMessage($this->t('Created.', [
                '%label' => $pmuchost->label(),
            ]));
        }
        else {
            $this->messenger()->addMessage($this->t('Updated.', [
                '%label' => $pmuchost->label(),
            ]));
        }

        $form_state->setRedirect('entity.poormans_uptime_checker_pmuc.collection');
    }

    /**
     * Helper function to check whether an PMUCHost configuration entity exists.
     */
    public function exist($id) {
        $entity = $this->entityTypeManager->getStorage('PMUCHost')->getQuery()
            ->condition('id', $id)
            ->execute();
        return (bool) $entity;
    }

}
