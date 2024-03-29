<?php

namespace Drupal\formmodule\Controller;
use Drupal\file\Entity\File;

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
	$latitude = empty($values['latitude']) ? '0' : $values['latitude'];
	$longitude = empty($values['longitude']) ? '0' : $values['longitude'];
	unset($values['submitup']);
        unset($values['submit']);
        unset($values['form_build_id']);
        unset($values['form_token']);
        unset($values['form_id']);
        unset($values['op']);
        unset($values['latitude']);
        unset($values['longitude']);
        unset($values['lat']);
        unset($values['long']);
        unset($values['location']);
        unset($values['milestonedesc']);
        unset($values['attachment']);
        //DbTransaction
        $transaction = db_transaction();
	$insertid = db_insert('appform')
                ->fields(array(
                    'appformid' => $apmdgpk,
                    'appgroupname' => $apmdgroupname,
                    'appgroupfields' => json_encode($values, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT),
                    'latitude' => $latitude,
                    'longitude' => $longitude,
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
        $milestonedesc = empty($values['milestonedesc']) ? ' ' : $values['milestonedesc'];
	$latitude = empty($values['lat']) ? '0' : $values['lat'];
	$longitude = empty($values['long']) ? '0' : $values['long'];
	//DbTransaction
	unset($values['submitup']);
        unset($values['submit']);
        unset($values['form_build_id']);
        unset($values['form_token']);
        unset($values['form_id']);
        unset($values['op']);
	unset($values['latitude']);
        unset($values['longitude']);
        unset($values['lat']);
        unset($values['long']);
        unset($values['location']);
        unset($values['milestonedesc']);
        unset($values['attachment']);
        
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
	$image = $form_state->getValue('attachment');

   if ($image[0]) {
	foreach ($image as $val) {
	$file = File::load($val);
        $file->setPermanent();
	$file->save();
	$file_usage = \Drupal::service('file.usage'); 
	$file_usage->add($file, 'formmodule', $apmdgpk . '-' . $appformpk, \Drupal::currentUser()->id());
	$query = db_select('file_managed', 'a');
	$query->join('file_usage', 'b', 'b.fid = a.fid');
        $query->fields('a');
        $query->fields('b');
        $query->condition('b.module', 'formmodule', '=');
        $query->condition('b.type', $apmdgpk.'-'.$appformpk, '=');
        $query->orderBy('a.fid', 'DESC');
        $query->range(0, 1);
        $attach = $query->execute()->fetchAssoc();
	
	$insertid = db_insert('appattachment')
                ->fields([
                    'fid' => $attach['fid'],
                    'uid' => $attach['uid'],
                    'filename' => $attach['filename'],
                    'filemime' => $attach['filemime'],
                    'uri' => $attach['uri'],
                    'module' => $attach['module'],
                    'type' => $attach['type']
                ])
                ->execute();
	if (!empty($milestonedesc)) {
	$insertmile = db_insert('appmilestone')
                ->fields([
                    'datetime' => date('Y-m-d H:i:s', time()),
                    'milestonedesc' => $milestonedesc,
                    'file' => $attach['filename'],
                    'filemime' => $attach['filemime'],
                    'url' => $attach['uri'],
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'bopk' => $apmdgpk.'-'.$appformpk,
                    'botype' => 'formmodule'
                ])
                ->execute();
	}
	}
   }
   else {
	if (!empty($milestonedesc) && $milestonedesc != ' ') {
	$insertmile = db_insert('appmilestone')
                ->fields([
                    'datetime' => date('Y-m-d H:i:s', time()),
                    'milestonedesc' => $milestonedesc,
                    'file' => '',
                    'filemime' => '',
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'url' => '',
                    'bopk' => $apmdgpk.'-'.$appformpk,
                    'botype' => 'formmodule'
                ])
                ->execute();
	}
   }
        if (!$update) {
            $transaction->rollback();
        } else {
            return $update;
        }
    }

    static function delete_formmodule($appformpk) {
        $query = db_select('appform', 'a');
        $query->fields('a');
        $query->condition('appformpk', $appformpk, '=');
        $result = $query->execute()->fetchAssoc();
	$bopk = $result['appformid'].'-'.$appformpk;
	db_delete('appform')
                ->condition('appformpk', $appformpk)
                ->execute();
	db_delete('appattachment')
                ->condition('module', 'formmodule')
                ->condition('type', $bopk)
                ->execute();
	db_delete('appmilestone')
                ->condition('botype', 'formmodule')
                ->condition('bopk', $bopk)
                ->execute();
    }

}
