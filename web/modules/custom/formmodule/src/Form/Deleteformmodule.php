<?php

namespace Drupal\formmodule\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\formmodule\Controller\Formmodule_biz;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

class Deleteformmodule extends ConfirmFormBase {

    protected $apmdgpk;

    public function getFormID() {
        return 'formmodule_delete';
    }

    public function getQuestion() {
        return t('Are you sure you want to delete Form %apmdgpk?', array('%apmdgpk' => $this->apmdgpk));
    }

    public function getConfirmText() {
        return t('Delete');
    }

    public function getCancelUrl() {
        return new Url('formmodule_example.list', array('apmdgpk' => $this->apmdgpk));
    }

    public function buildForm(array $form, FormStateInterface $form_state, $apmdgpk = NULL, $appformpk = NULL) {
        $this->apmdgpk = $apmdgpk;
        $this->appformpk = $appformpk;
        return parent::buildForm($form, $form_state);
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        Formmodule_biz::delete_formmodule($this->appformpk);
//    watchdog('bd_contact', 'Deleted product  with id %id.', array('%id' => $this->id));
        drupal_set_message(t('Form %id has been deleted.', array('%id' => $this->apmdgpk)));
        return new RedirectResponse(\Drupal::url('formmodule_example.list', array('apmdgpk' => $this->apmdgpk)));
    }

}
