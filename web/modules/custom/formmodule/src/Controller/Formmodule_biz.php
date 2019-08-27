<?php

namespace Drupal\formmodule\Controller;

Class Formmodule_biz {

    static function getformmoduledet($apmdgpk = NULL, $appformpk = NULL) {
	$result = array();
        if (!empty($apmdgpk)) {
            $headerquery = db_select('appform', 'a');
            $headerquery->fields('a');
            $headerquery->condition('appformid', $apmdgpk, '=');
            $headerquery->condition('appformpk', $appformpk, '=');
            $result = $headerquery->execute()->fetchAssoc();

        }

        return $result;
    }

    static function getformmilestone($apmdgpk = NULL, $appformpk = NULL) {
	$result = array();
        if (!empty($apmdgpk)) {
            $headerquery = db_select('appmilestone', 'a');
            $headerquery->fields('a');
            $headerquery->condition('bopk', $appformpk, '=');
            $headerquery->condition('botype', 'formmodule', '=');
            $result = $headerquery->execute()->fetchAssoc();

        }

        return $result;
    }
    
    static function save_formmodule($form, $form_state, $apmdgpk = '', $apmdgroupname = '') {
        $values = $form_state->getValues();
	unset($values['submitup']);
        unset($values['submit']);
        unset($values['form_build_id']);
        unset($values['form_token']);
        unset($values['form_id']);
        unset($values['op']);
        //DbTransaction
        $transaction = db_transaction();
	$insertid = db_insert('appform')
                ->fields(array(
                    'appformid' => $apmdgpk,
                    'appgroupname' => $apmdgroupname,
                    'appgroupfields' => json_encode($values, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT),
                    'createdby' => \Drupal::currentUser()->id()
                ))
                ->execute();

        if (!$insertid) {
            $transaction->rollback();
        } else {
            return $insertid;
        }
   }



    static function edit_formmodule($form, $form_state, $apmdgpk = '', $appformpk = '') {

        $values = $form_state->getValues();
        //DbTransaction
	unset($values['submitup']);
        unset($values['submit']);
        unset($values['form_build_id']);
        unset($values['form_token']);
        unset($values['form_id']);
        unset($values['op']);

        $transaction = db_transaction();

        $update = db_update('appform')
                ->fields(array(
                    'appgroupfields' => json_encode($values, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT),
                    'updatedby' => \Drupal::currentUser()->id(),
		    'updatedtime' => date('Y-m-d H:i:s', time())
                ))
            //    ->condition('appformid', $apmdgpk, '=')
                ->condition('appformpk', $appformpk, '=')
                ->execute();

        if (!$update) {
            $transaction->rollback();
        } else {
            return $update;
        }
    }

    static function delete_formmodule($appformpk) {
        db_delete('appform')
                ->condition('appformpk', $appformpk)
                ->execute();
    }

}
