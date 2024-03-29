<?php

namespace Drupal\formbuild\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\formbuild\Controller\Formbuild_biz;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

class Deleteformbuild extends ConfirmFormBase {

    protected $apmdgpk;

    public function getFormID() {
        return 'formbuild_delete';
    }

    public function getQuestion() {
        return t('Are you sure you want to delete Metadata Group %apmdgpk?', array('%apmdgpk' => $this->apmdgpk));
    }

    public function getConfirmText() {
        return t('Delete');
    }

    public function getCancelUrl() {
        return new Url('formbuild_example.list');
    }

    public function buildForm(array $form, FormStateInterface $form_state, $apmdgpk = NULL) {
        $this->apmdgpk = $apmdgpk;
        return parent::buildForm($form, $form_state);
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        Formbuild_biz::delete_formbuild($this->apmdgpk);
//    watchdog('bd_contact', 'Deleted product  with id %id.', array('%id' => $this->id));
        drupal_set_message(t('Metadata Group %id has been deleted.', array('%id' => $this->apmdgpk)));
        return new RedirectResponse(\Drupal::url('formbuild_example.list'));
    }

}
