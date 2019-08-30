<?php

namespace Drupal\formmilestone\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\formmilestone\Controller\Formmilestone_biz;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

class Deleteformmilestone extends ConfirmFormBase {

    protected $apmdgpk;

    public function getFormID() {
        return 'formmilestone_delete';
    }

    public function getQuestion() {
        return t('Are you sure you want to delete Milestone %appmilestonepk?', array('%appmilestonepk' => $this->appmilestonepk));
    }

    public function getConfirmText() {
        return t('Delete');
    }

    public function getCancelUrl() {
        return new Url('formmilestone_example.list');
    }

    public function buildForm(array $form, FormStateInterface $form_state, $appmilestonepk = NULL) {
        $this->appmilestonepk = $appmilestonepk;
        return parent::buildForm($form, $form_state);
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        Formmilestone_biz::delete_formmilestone($this->appmilestonepk);
//    watchdog('bd_contact', 'Deleted product  with id %id.', array('%id' => $this->id));
        drupal_set_message(t('Field %id has been deleted.', array('%id' => $this->appmilestonepk)));
        return new RedirectResponse(\Drupal::url('formmilestone_example.list'));
    }

}
