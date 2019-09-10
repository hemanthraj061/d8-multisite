<?php

namespace Drupal\formmilestone\Controller;

Class Formmilestone_biz {

    static function getformmilestonedet($appmilestonepk = NULL) {
	$result = array();
        if (!empty($appmilestonepk)) {
            $headerquery = db_select('appmilestone', 'a');
            $headerquery->fields('a');
            $headerquery->condition('appmilestonepk', $appmilestonepk, '=');
            $result = $headerquery->execute()->fetchAssoc();

        }

        return $result;
    }

    static function save_formmilestone($form, $form_state) {
  /*      $values = $form_state->getValues();
        //DbTransaction
        $transaction = db_transaction();

        $insertid = db_insert('appmetadata')
                ->milestone(array(
                    'apmdtype' => $values['apmdtype'],
                    'apmdlength' => $values['apmdlength'],
                    'apmddesc' => $values['apmddesc'],
                    'apmdname' => $values['apmdname'],
                    'apmdoptions' => $values['apmdoptions'],
                    'createdby' => \Drupal::currentUser()->id()
                ))
                ->execute();

        if (!$insertid) {
            $transaction->rollback();
        } else {
            return $insertid;
        }*/
   }



    static function edit_formmilestone($form, $form_state, $apmdpk = '') {

      /*  $values = $form_state->getValues();
        //DbTransaction

        $transaction = db_transaction();

        $update = db_update('appmetadata')
                ->milestone(array(
                    'apmdtype' => $values['apmdtype'],
                    'apmdlength' => $values['apmdlength'],
                    'apmddesc' => $values['apmddesc'],
                    'apmdname' => $values['apmdname'],
                    'apmdoptions' => $values['apmdoptions'],
                    'updatedby' => \Drupal::currentUser()->id(),
                    'updatedtime' => date('Y-m-d H:i:s', time())
                ))
                ->condition('apmdpk', $apmdpk, '=')
                ->execute();

        if (!$update) {
            $transaction->rollback();
        } else {
            return $update;
        }*/
    }

    static function delete_formmilestone($appmilestonepk) {
        db_delete('appmilestone')
                ->condition('appmilestonepk', $appmilestonepk)
                ->execute();
    }

}
