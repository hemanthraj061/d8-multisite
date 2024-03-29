<?php
/**
 * @file
 * Contains \Drupal\first_module\Controller\FirstController.
 */
 
namespace Drupal\first_module\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Mail\MailManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
 
class FirstController extends FormBase {
  /**
   * The mail manager.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * Constructs a new EmailExampleGetFormPage.
   *
   * @param \Drupal\Core\Mail\MailManagerInterface $mail_manager
   *   The mail manager.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   */
  public function __construct(MailManagerInterface $mail_manager, LanguageManagerInterface $language_manager) {
    $this->mailManager = $mail_manager;
    $this->languageManager = $language_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {




    $form = new static(
      $container->get('plugin.manager.mail'),
      $container->get('language_manager')
    );
    $form->setMessenger($container->get('messenger'));
    return $form;
  }

  public function getFormId() {
    return 'first_module';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['intro'] = [
      '#markup' => t('Use this form to send a message to an e-mail address. No spamming!'),
    ];
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => t('E-mail address'),
      '#required' => TRUE,
    ];
    $form['message'] = [
      '#type' => 'textarea',
      '#title' => t('Message'),
      '#required' => TRUE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Submit'),
    ];

//$form['comments'] = \Drupal::formBuilder()->getForm('Drupal\commentapi\Form\CommentsModule');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!valid_email_address($form_state->getValue('email'))) {
      $form_state->setErrorByName('email', t('That e-mail address is not valid.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_values = $form_state->getValues();
    $module = 'first_module';
    $key = 'first_message';
    $to = $form_values['email'];
    $from = $this->config('system.site')->get('mail');
    $params = $form_values;
    $language_code = $this->languageManager->getDefaultLanguage()->getId();
    $send_now = TRUE;
    $renderable = [
  '#theme' => 'mail_temp',
      '#title' => 'Test Value',
      '#description' => $result,
];
$rendered = \Drupal::service('renderer')->render($renderable);
$params['message'] = $rendered;
    $result = $this->mailManager->mail($module, $key, $to, $language_code, $params, $from, $send_now);
    if ($result['result'] == TRUE) {
      $this->messenger()->addMessage(t('Your message has been sent.'));
    }
    else {
      $this->messenger()->addMessage(t('There was a problem sending your message and it was not sent.'), 'error');
    }
  }

}
