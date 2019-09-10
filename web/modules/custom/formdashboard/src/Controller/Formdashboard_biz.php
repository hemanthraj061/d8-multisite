<?php

namespace Drupal\formdashboard\Controller;

Class Formdashboard_biz {

    static function getformdashboarddet($appformmenupk = NULL) {
	$result = array();
        if (!empty($appformmenupk)) {
            $headerquery = db_select('appformmenu', 'a');
            $headerquery->fields('a');
            $headerquery->condition('appformmenupk', $appformmenupk, '=');
            $result = $headerquery->execute()->fetchAssoc();

        }

        return $result;
    }

    static function save_formdashboard($form, $form_state) {
        $values = $form_state->getValues();
        //DbTransaction
        $transaction = db_transaction();

        $insertid = db_insert('appformmenu')
                ->fields(array(
                    'menuname' => $values['menuname'],
                    'formlist' => $values['formlist'],
                    'createdby' => \Drupal::currentUser()->id()
                ))
                ->execute();

        if (!$insertid) {
            $transaction->rollback();
        } else {
            return $insertid;
        }
   }



    static function edit_formdashboard($form, $form_state, $appformmenupk = '') {

        $values = $form_state->getValues();
        //DbTransaction

        $transaction = db_transaction();

        $update = db_update('appformmenu')
                ->fields(array(
                    'menuname' => $values['menuname'],
                    'formlist' => $values['formlist'],
                    'updatedby' => \Drupal::currentUser()->id(),
                    'updatedtime' => date('Y-m-d H:i:s', time())
                ))
                ->condition('appformmenupk', $appformmenupk, '=')
                ->execute();

        if (!$update) {
            $transaction->rollback();
        } else {
            return $update;
        }
    }

    static function delete_formdashboard($appformmenupk) {
        db_delete('appformmenu')
                ->condition('appformmenupk', $appformmenupk)
                ->execute();
    }

}
