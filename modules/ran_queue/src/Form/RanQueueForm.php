<?php

namespace Drupal\ran_queue\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class RanQueueForm extends ConfigFormBase {
  public function getFormId() {
    return 'ran_queue_settings';
  }

  public function getEditableConfigNames() {
    return ['ran_queue.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ran_queue.settings');
    $form['host'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Host'),
      '#default_value' => $config->get('host'),
    );
    $form['username'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#default_value' => $config->get('username'),
    );
    $form['password'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Password'),
      '#default_value' => $config->get('password'),
    );
    $form['vhost'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Vhost'),
      '#default_value' => $config->get('vhost'),
    );

    return parent::buildForm($form, $form_state);
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validate submitted form data.
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('ran_queue.settings');
    $config->set('host', $form_state->getValue('host'));
    $config->set('username', $form_state->getValue('username'));
    $config->set('password', $form_state->getValue('password'));
    $config->set('vhost', $form_state->getValue('vhost'));
    $config->save();
  }
}
