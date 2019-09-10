<?php

namespace Drupal\formdashboard\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\formdashboard\Controller\Formdashboard_biz;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

class Deleteformdashboard extends ConfirmFormBase {

    protected $apmdgpk;

    public function getFormID() {
        return 'formdashboard_delete';
    }

    public function getQuestion() {
        return t('Are you sure you want to delete Form Menu %appformmenupk?', array('%appformmenupk' => $this->appformmenupk));
    }

    public function getConfirmText() {
        return t('Delete');
    }

    public function getCancelUrl() {
        return new Url('formmenu_example.list');
    }

    public function buildForm(array $form, FormStateInterface $form_state, $appformmenupk = NULL) {
        $this->appformmenupk = $appformmenupk;
        return parent::buildForm($form, $form_state);
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        Formdashboard_biz::delete_formdashboard($this->appformmenupk);
//    watchdog('bd_contact', 'Deleted product  with id %id.', array('%id' => $this->id));
        drupal_set_message(t('Field %id has been deleted.', array('%id' => $this->appformmenupk)));
        return new RedirectResponse(\Drupal::url('formmenu_example.list'));
    }

}
