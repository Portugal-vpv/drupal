<?php
/**
 * @file
 * 
 * Contains \Drupal\rsvplist\Form\RSVPForm
 */

namespace Drupal\rsvplist\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an RSVP Email form
 */

class RSVPForm extends FormBase
{
    /**
     * (@inheritDoc)
     */

    public function getFormId ()
    {
        # Every drupal form has an ID and the following 
        # string is now the ID of our form.
        return 'rsvplist_email_form'; 
    }

    /**
     * (@inheritDoc)
     * 
     * OBS!!! might need to use a & after array -> 'array &$form'
     */
    public function buildForm (array $form, FormStateInterface $form_state)
    {
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        $form['email'] = array(
          /**
           * The t('field_name') allows you to translate the field_name
           * Reminder : if youre building an array there needs to be a comma
           * at the end of each line.
           * 
           * Attributes are prefaced by the # and form fields come after the defined 
           * attribute, as shown below.
           */
          '#title' => t('Email Address'),
          '#type' => 'textfield',
          '#size' => 25,
          '#description' => t("We'll send updates to the email address you provide."),
          '#required' => true,
        );
        $form['submit'] = array(
            '#type' => 'hidden',
            '#value' => $nid,
        );
        return $form;
    }
    /**
     *
     * @param array $form
     * @param FormStateInterface $form_state
     * @return void
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $value = $form_state->getValue('email');
        if ( $value == ! \Drupal::service( 'email.validator' )->isValid($value) )
        {
            $form_state->setErrorByName ('email', t('The email address %mail is not valid.', array( '%mail' => $value)));
        }
    }
    /**
     * (@inheritDoc)
     */
    public function submitForm (array &$form, FormStateInterface $form_state) 
    {
        $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
        
        \Drupal::database()->insert('rsvplist')
            ->fields(array(
                'mail' => $form_state->getValue('email'),
                'nid' => $form_state->getValue('nid'),
                'uid'=> $form_state->getValue('uid'),
                'created' => time(),
                )
            )
            ->execute();
        \Drupal::messenger()->addMessage (t('Thank you for your RSVP, you are on the list for the event.'));
    }
}