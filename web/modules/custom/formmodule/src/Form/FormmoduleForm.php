<?php

namespace Drupal\formmodule\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\file\Entity\File;
use Drupal\customutil\CustomUtils;
use Drupal\formmodule\Controller\Formmodule_biz;
use Drupal\formmodule\Controller\AutocompleteController;

 
/**
 * Form with examples on how to use cache.
 */
class FormmoduleForm extends FormBase {

    public $apmdgpk;
      

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'formmodule_example_form';
    }


    public function buildForm(array $form, FormStateInterface $form_state, $formmode = '', $apmdgpk = '', $appformpk = '') {

        $this->apmdgpk = $apmdgpk;
        $this->appformpk = $appformpk;
        $this->formmode = $formmode;
        $display_mode = FALSE;
        if ($this->formmode == 'DISPLAY') {

            $this->display_mode = TRUE;
        }

        $formmoduledet = Formmodule_biz::getformmoduledet($apmdgpk, $appformpk);
	$formmilestone = Formmodule_biz::getformmilestone($apmdgpk, $appformpk);

        $query = db_select('appmdgroup', 'a');
        $query->fields('a');
        $query->condition('apmdgpk', $apmdgpk, '=');
        $result = $query->execute()->fetchAssoc();
	$form['formtitle'] = [
            '#markup' => '<i class="fa fa-gift"></i> &nbsp;'. $result['apmdgroupname'] .' Info',
            '#prefix' => '<div class="kt-portlet__head"><div class="kt-portlet__head-label">',
            '#suffix' => '</div></div>',
        ];
	$this->apmdgroupname = $result['apmdgroupname'];
        $form['formbody'] = [
            '#markup' => '<form role="form" class="kt-form">
                        <div class="form-body">
                        <div class="row">'
        ];
	if (!isset($this->display_mode)) {
	$form['submitup'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#prefix' => '<div class="row"><div class="col-md-6">&nbsp;</div><div class="col-md-6">&nbsp;</div><div class="col-md-6">',
            '#suffix' => '</div>'
        ];
	}
        else {
	$edit_formfields = CustomUtils::addButton('formmodule_example_edit', array('apmdgpk' => $apmdgpk, 'appformpk' => $appformpk), 'medium', 'Edit '. $result['apmdgroupname'] . ' Form');
        
        $form['buttons']['submitedit'] = [
            '#markup' => $edit_formfields,
            '#prefix' => '<div class="row"><div class="col-md-6">&nbsp;</div><div class="col-md-6">&nbsp;</div><div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div>&nbsp;&nbsp;',
        ];
	$add_formfields = CustomUtils::addButton('formmodule_example.form', array('apmdgpk' => $apmdgpk), 'medium', 'Add '. $result['apmdgroupname'] . ' Form');

        $form['buttons']['submitadd'] = [
            '#markup' => $add_formfields,
            '#prefix' => '<div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div>&nbsp;&nbsp;',
        ];
	}
        $link_options = array(
            'attributes' => array(
                'class' => array(
                    'btn',
                    'btn-danger',
                ),
            ),
        );
        $url = Url::fromRoute('formmodule_example.list', array('apmdgpk' => $apmdgpk));
        $url->setOptions($link_options);
        $cancel_formmodulelink = \Drupal::l(t('Cancel'), $url);

        $form['buttons']['cancel'] = [
            '#markup' => $cancel_formmodulelink,
            '#prefix' => '<div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div></div>',
        ];
        $getfields = json_decode($result['apmdfields'], true);
	$values = json_decode($formmoduledet['appgroupfields'],true);
	$references = json_decode($result['references'],true);
	if ($formmode == 'NEW') {
	$form['tabscontent']['one']['productinfo1'] = $this->formmoduletab($getfields, $values, $form_state, $result['layout'], $references);
	}
	else {
	$form['formcoverstart']['#markup'] = '<div class="kt-portlet">';
        $form['formbody']['#markup'] = '<div class="kt-portlet__body">';
        
        $form['tabs'] = [
            '#markup' => '',
            '#prefix' => '<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">',
            '#suffix' => '</ul>',
        ];
        $form['tabs']['one'] = [
            '#markup' => '<a class="nav-link active" data-toggle="tab" href="#kt_tabs_2_1">Form</a>',
            '#prefix' => '<li class="nav-item">',
            '#suffix' => '</li>',
        ];
        $form['tabs']['two'] = [
            '#markup' => '<a class="nav-link" data-toggle="tab" href="#kt_tabs_2_2">Timeline</a>',
            '#prefix' => '<li class="nav-item">',
            '#suffix' => '</li>',
        ];
	if (isset($this->display_mode)) {
        $form['tabs']['three'] = [
            '#markup' => '<a class="nav-link" data-toggle="tab" href="#kt_tabs_2_3">Map View</a>',
            '#prefix' => '<li class="nav-item">',
            '#suffix' => '</li>',
        ];
	}
        $form['tabscontent'] = [
//            '#markup' => '',
            '#prefix' => '<div class="tab-content">',
            '#suffix' => '</div>',
        ];
        $form['tabscontent']['one'] = [
//            '#markup' =>  '',
            '#prefix' => '<div class="tab-pane active" id="kt_tabs_2_1" role="tabpanel">',
            '#suffix' => '</div>',
        ];
        $form['tabscontent']['two'] = [
//            '#markup' =>  '',
            '#prefix' => '<div class="tab-pane" id="kt_tabs_2_2" role="tabpanel">',
            '#suffix' => '</div>',
        ];
        if (isset($this->display_mode)) {
        $form['tabscontent']['three'] = [
//            '#markup' => '',
            '#prefix' => '<div class="tab-pane" id="kt_tabs_2_3" role="tabpanel">',
            '#suffix' => '</div>',
        ];
	}

        $form['tabscontent']['one']['productinfo1'] = $this->formmoduletab($getfields, $values, $form_state, $result['layout'], $references);
        $form['tabscontent']['two']['productinfo2'] = $this->milestonetab($formmilestone, $apmdgpk, $appformpk);
        if (isset($this->display_mode)) {
        $form['tabscontent']['three']['productinfo3'] = $this->maptab($formmilestone, $apmdgpk, $appformpk);
	}
        $form['formbodyend']['#markup'] = '</div>';
        $form['formcoverend']['#markup'] = '</div>';
	}
	$form['latitude'] = ['#type' => 'hidden', '#attributes' => ['id' => 'edit-latitude']];
        $form['longitude'] = ['#type' => 'hidden', '#attributes' => ['id' => 'edit-longitude']];
	$form['lat'] = ['#type' => 'hidden', '#attributes' => ['id' => 'edit-lat']];
        $form['long'] = ['#type' => 'hidden', '#attributes' => ['id' => 'edit-long']];
	if (isset($this->display_mode)) {
		$form['latitude']['#default_value'] = $formmoduledet['latitude'];
		$form['longitude']['#default_value'] = $formmoduledet['longitude'];
	}
        $i = count($getfields) - 1;
	if (!isset($this->display_mode)) {
	$form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#prefix' => ($i % 2 == 0) ? '<div class="row"><div class="col-md-6">&nbsp;</div><div class="col-md-6">&nbsp;</div><div class="col-md-6">' : '<div class="row"><div class="col-md-6">&nbsp;</div><div class="col-md-6">&nbsp;</div><div class="col-md-6">',
            '#suffix' => '</div>',
	];
	}
        else {
	$edit_formfields = CustomUtils::addButton('formmodule_example_edit', array('apmdgpk' => $apmdgpk, 'appformpk' => $appformpk), 'medium', 'Edit '. $result['apmdgroupname'] . ' Form');

        $form['actions']['submitedit'] = [
            '#markup' => $edit_formfields,
            '#prefix' => ($i % 2 == 0) ? '<div class="row"><div class="col-md-6">&nbsp;</div><div class="col-md-6">&nbsp;</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="kt-portlet__head-toolbar"><div class="kt-portlet__head-wrapper"><div class="kt-portlet__head-actions">' : '<div class="row"><div class="col-md-6">&nbsp;</div><div class="col-md-6">&nbsp;</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="kt-portlet__head-toolbar"><div class="kt-portlet__head-wrapper"><div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div>&nbsp;&nbsp;',
        ];
	$add_formfields = CustomUtils::addButton('formmodule_example.form', array('apmdgpk' => $apmdgpk), 'medium', 'Add '. $result['apmdgroupname'] . ' Form');

        $form['actions']['submitadd'] = [
            '#markup' => $add_formfields,
            '#prefix' => '<div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div>&nbsp;&nbsp;',
        ];
	}
        $url = Url::fromRoute('formmodule_example.list', array('apmdgpk' => $apmdgpk));
        $url->setOptions($link_options);
        $cancel_formmodulelink = \Drupal::l(t('Cancel'), $url);

        $form['actions']['cancel'] = [
            '#markup' => $cancel_formmodulelink,
            '#prefix' => '<div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div></div>',
        ];
        $form['formend'] = [
            '#markup' => '</form></div></div>'
        ];


        $form['#attributes']['enctype'] = 'multipart/form-data';
	if ($formmode == 'NEW' || $formmode == 'EDIT') {
	$form['#attributes']['onclick'] = 'if(navigator.geolocation){
	    navigator.geolocation.getCurrentPosition(function(position){
		document.getElementById("edit-latitude").value = position.coords.latitude;
		document.getElementById("edit-longitude").value = position.coords.longitude;
		document.getElementById("edit-lat").value = position.coords.latitude;
		document.getElementById("edit-long").value = position.coords.longitude;
	    });
	}this.onclick=null;';
	}
        $form['#attached']['library'][] = 'formmodule/formmodulelib';
        return $form;
    }
    public function formmoduletab($getfields, $values, $form_state, $layout = NULL, $references = NULL) {
	$ftype = ['DATE' => 'date', 'CHAR' => 'textfield', 'AUTO' => 'textfield', 'SELECT' => 'select', 'FLOAT' => 'textfield', 'CHECK' => 'checkboxes', 'INT' => 'textfield', 'RADIO' => 'textfield', 'TEXT' => 'textarea'];
	$i = 0;$j = 0;$k = 0;
	$count = count($getfields) - 1;
	$modulelist = array_keys($references);
	foreach ($modulelist as $module) {
	$query = db_select('appform', 'a');
	$query->join('appmdgroup', 'b', "b.apmdgroupname = a.appgroupname AND b.apmdgroupid = '$module'");
        $query->fields('a', ['appgroupfields']);
	$getlist = $query->execute();
	foreach ($getlist as $item) {
	    $opt[] = json_decode($item->appgroupfields, true)[$references[$module][1]];
	}
        $option[$references[$module][0]] = $opt;
	}
        foreach ($getfields as $fld) {
	$desc = CustomUtils::getLabel($fld);
	$type = db_query("SELECT apmdtype from {appmetadata} WHERE apmdname = :apmdname AND apmdtype <> 'HEAD' LIMIT 1", array(":apmdname" => $fld))->fetchField();
	$options = json_decode(db_query("SELECT apmdoptions from {appmetadata} WHERE apmdname = :apmdname AND apmdtype <> 'HEAD' LIMIT 1", array(":apmdname" => $fld))->fetchField(), true);
	$hdesc = db_query("SELECT apmddesc from {appmetadata} WHERE apmdname = :apmdname AND apmdtype = 'HEAD' LIMIT 1", array(":apmdname" => $fld))->fetchField();
	if (!empty($hdesc)) {
	   $j++;$k = 0;
	   $form['h'. $j] = ['#type' => 'details', '#title' => $this->t($desc), '#open' => ($j == 1) ? TRUE : FALSE];
	}
	else {
	$form['h'. $j][$fld] = [
            '#type' => $ftype[$type],
            '#title' => $this->t($desc),
            '#default_value' => ($form_state->getValue($fld) != false) ? $form_state->getValue($fld) : $values[$fld],
	    '#attributes' =>  isset($this->display_mode) ? ['readonly' => 'readonly', 'style' => 'background:#F2F3F8;'] : [], 
	   // '#description' => empty($aplandesc) ? '' : $this->t($aplandesc),
            '#prefix' => ($i == 0 || $k == 0) ? '<div class="'.(($layout == 'TWO') ? "row" : "fullwidth").'"><div class="col-md-6">' : '<div class="col-md-6">',
            '#suffix' => ($i == $count) ? '</div></div>' : '</div>'
        ];
	if ($type == 'DATE') {
	  //$form['h'. $j][$fld]['#date_date_format'] = 'm / d / Y'; 
	  $form['h'. $j][$fld]['#default_value'] = !empty($values[$fld]) ? date('Y-m-d', strtotime($values[$fld])) : date('Y-m-d');
	}
	if ($type == 'SELECT' || $type == 'RADIO' || $type == 'CHECK') {
	  if (isset($this->display_mode)) $form['h'. $j][$fld]['#disabled'] = TRUE;
	  $form['h'. $j][$fld]['#options'] = !empty($option[$fld]) ? [$desc => $option[$fld]] : $options;
	}
	}
	if (empty($hdesc)) {$i++;$k++;}
	}
	return $form;
    }
    public function milestonetab($formmilestone, $apmdgpk, $appformpk) {
	if (!isset($this->display_mode)) {
	$form['milestonedesc'] = [
                '#type' => 'textfield',
                '#title' => t('Milestone Description'),
                '#default_value' => isset($formmilestone['milestonedesc']) ? $formmilestone['milestonedesc'] : '',
		'#attributes' => isset($this->display_mode) ? ['readonly' => 'readonly', 'style' => 'background:#F2F3F8;'] : '',
                '#prefix' => '<div class="row"><div class="col-md-12 col-sm-10">',
                '#suffix' => '</div>',
            ];
	$form['attachment'] = [
            '#type' => 'managed_file',
            '#title' => t('Attachment'),
            '#attributes' =>  isset($this->display_mode) ? ['disabled' => 'disabled'] : [], 
	    '#multiple' => TRUE,
	    '#disabled' => isset($this->display_mode) ? TRUE : FALSE,
            '#upload_location' => 'public://items',
	    '#upload_validators' => array(
	       'file_validate_extensions' => array('pdf doc docx rtf txt xls xlsx csv bmp jpg jpeg png gif tiff mp3 mp4'),
	       'file_validate_size' => array(25600000),
	     ),
	];
	$form['location'] = [
                '#type' => 'textfield',
                '#title' => t('Location'),
                '#default_value' => isset($formmilestone['location']) ? $formmilestone['location'] : '',
		'#attributes' => isset($this->display_mode) ? ['readonly' => 'readonly', 'style' => 'background:#F2F3F8;'] : '',
                '#prefix' => '<div class="col-md-12 col-sm-10">',
                '#suffix' => '</div></div>',
            ];
	}
	else {
	global $base_url;
	$query = db_select('appmilestone', 'a');
	$query->fields('a');
        $query->condition('a.botype', 'formmodule', '=');
        $query->condition('a.bopk', $apmdgpk.'-'.$appformpk, '=');
        $query->orderBy('a.appmilestonepk', 'ASC');
        $files = $query->execute();
	$i = 0;
	$mark = [];
	$link_options = array(
            'attributes' => array(
                'target' => '_blank',
            ),
        );
	$form['milestone'] = ['#markup' => '<div class="timeline">'];
        foreach($files as $file) {
	  $form['milestone'][$i] = ['#markup' => '<div class="col-md-12 container right"><div class="content"><h6>'.$file->milestonedesc.'</h6><p>' . date('m / d / Y h:i:s A', strtotime($file->datetime)) . '</p><div class="body"><a href="'.$base_url.'/sites/default/files/items/'.$file->file.'" target="_blank">'.$file->file.'</a></div></div></div>'];
	  if (!empty($file->latitude)) {
	     $dispurl = Url::fromRoute('formmilestone_example_display', array('appmilestonepk' => $file->appmilestonepk));
	     $dispurl->setOptions($link_options);
             $display_formmilestone = \Drupal::l(t($file->milestonedesc), $dispurl);
	     $mark[] = ['latitude' => $file->latitude, 'longitude' => $file->longitude, 'content' => $display_formmilestone];
	  }
	  $i++;
	}
	$form['mark'] = ['#type' => 'hidden', '#default_value' => json_encode($mark), '#attributes' => ['id' => 'edit-mark']];
	$form['milestone']['#suffix'] = '</div>';
	}
	return $form;
    }
    public function maptab($formmilestone, $apmdgpk, $appformpk) {
	$form['map'] = ['#markup' => '<div id="map-link" style="height:300px !important;"></div>'];
	return $form;
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {
 	/*if ($form_state->getValue('apmdgroupid') == '') {
            $form_state->setErrorByName('apmdgroupid', $this->t('Please enter proper value'));
        }

        if ($form_state->getValue('apmdgroupname') == '') {
            $form_state->setErrorByName('apmdgroupname', $this->t('Please enter group name'));
        }

        if ($form_state->getValue('apmdfields') == '') {
            $form_state->setErrorByName('apmdfields', $this->t('Please enter fields'));
        }

        if ($form_state->getValue('aptablefields') == '') {
            $form_state->setErrorByName('aptablefields', $this->t('Please enter table fields'));
        }

        if ($form_state->getValue('apkeyfields') == '') {
            $form_state->setErrorByName('apkeyfields', $this->t('Please enter appkeyfields'));
        }
 	$apmdgroupid = db_query("SELECT apmdgpk from {appmdgroup} WHERE apmdgroupid = :apmdgroupid AND apmdgpk <> :apmdgpk LIMIT 1", array(":apmdgroupid" => $form_state->getValue('apmdgroupid'), ":apmdgpk" => $this->apmdgpk))->fetchField();

        if (!empty($apmdgroupid)) {
            $form_state->setErrorByName('apmdgroupid', $this->t('There is already one Group with this id. Please enter different apmdgroupid'));
        }*/
        
//        $form_state->setRebuild();
    }

    public function fapiExampleMultistepFormNextSubmit(array &$form, FormStateInterface $form_state) {
        $form_state->setRebuild();
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
       // $apmdgpk = $form_state->getValue('apmdgpk');
        
      //  $vals = $form_state->getValues();

        switch ($this->formmode) {
            case 'NEW':
                $returnval = Formmodule_biz::save_formmodule($form, $form_state, $this->apmdgpk, $this->apmdgroupname);
                if ($returnval == 'FAIL') {                    
                } else {
                    drupal_flush_all_caches();
                    drupal_set_message(t("Formmodule Saved Successfully"));
                    $form_state->setRedirect('formmodule_example_display', array('apmdgpk' => $this->apmdgpk, 'appformpk' => $returnval));
                }
                break;
            case 'EDIT':
                $returnval = Formmodule_biz::edit_formmodule($form, $form_state, $this->apmdgpk, $this->appformpk);
                if ($returnval == 'FAIL') {
                    
                } else {
                    drupal_flush_all_caches();
                    drupal_set_message(t("Formmodule Updated Successfully"));
                    $form_state->setRedirect('formmodule_example_display', array('apmdgpk' => $this->apmdgpk, 'appformpk' => $this->appformpk));
                }
                break;
            default:
                $form_state->setRedirect('formmodule_example.list', array('apmdgpk' => $this->apmdgpk));
                break;
        }





    }
    
    /**
     * Callback for ajax_example_autotextfields.
     *
     * Selects the piece of the form we want to use as replacement markup and
     * returns it as a form (renderable array).
     */
    public function textfieldsCallback($form, FormStateInterface $form_state) {
        $form_state->setRebuild();
        return $form['textfields_container'];
    }

}
