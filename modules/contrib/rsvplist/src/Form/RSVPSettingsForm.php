<?php
/**
 * @file
 * Contains \Drupal\rsvplist\Form\RSVPSettingsForm
 */
namespace Drupal\rsvplist\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form to configure RSVP List module settings
 */
 class RSVPSettingsForm extends ConfigFormBase
{
  /**
   * {@inheritDoc}
   */
  public function getFormId()
  {
    // Look for the form with this name and return its id
    return 'rsvplist_admin_settings';
  }
  /**
   * {@inheritDoc}
   */
  public function getEditableConfigNames ()
  {
    return ['rsvplist.settings'];
  }
  /**
   * Pass an array of form informations as the first argument, the current state of the form which is
   * an object of type FormStateInterface and also a request object that may or may not be null
   * 
   * {@inheritDoc}
   */
  public function buildForm (array $form, FormStateInterface $form_state, Request $request = null)
  {
    $types = node_type_get_names();
    $config = $this->config('rsvplist.settings');
    $form['rsvplist_types'] = array(
      '#type' => 'checkboxes',
      '#title' => $this-> t('The content types to enable RSVP collection for'),
      '#defauult_value' => $config->get('allowed_types'),
      '#options' => $types,
      '#description' => t('On the specified node types, an RSVP option will be available and can be enabled while that node is being edited.'),
    );
    $form['array_filter'] = array('#type' => 'value', '#value' => true);
    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $allowed_types = array_filter($form_state->getValue('rsvplist_types'));
    sort($allowed_types);
    $this->config('rsvplist.settings')->set('allowed_types', $allowed_types)->save();
    parent::submitForm($form, $form_state);
  }
}