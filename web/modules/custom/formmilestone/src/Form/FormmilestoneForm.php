<?php

namespace Drupal\formmilestone\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\customutil\CustomUtils;
use Drupal\formmilestone\Controller\Formmilestone_biz;
use Drupal\formmilestone\Controller\AutocompleteController;


/**
 * Form with examples on how to use cache.
 */
class FormmilestoneForm extends FormBase {

    public $appmilestonepk;
      

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'formmilestone_example_form';
    }


    public function buildForm(array $form, FormStateInterface $form_state, $formmode = '', $appmilestonepk = '') {

        $this->appmilestonepk = $appmilestonepk;
        $this->formmode = $formmode;
        $display_mode = FALSE;
        if ($this->formmode == 'DISPLAY') {

            $this->display_mode = TRUE;
        }

        $formmilestonedet = Formmilestone_biz::getformmilestonedet($appmilestonepk);

        $form['formtitle'] = [
            '#markup' => '<i class="fa fa-gift"></i> &nbsp;Milestone Info',
            '#prefix' => '<div class="kt-portlet__head"><div class="kt-portlet__head-label">',
            '#suffix' => '</div></div>',
        ];

        $form['formbody'] = [
            '#markup' => '<form role="form" class="kt-form">
                        <div class="form-body">
                        <div class="row">'
        ];

        $link_options = array(
            'attributes' => array(
                'class' => array(
                    'btn',
                    'btn-danger',
                ),
            ),
        );
        $url = Url::fromRoute('formmilestone_example.list');
        $url->setOptions($link_options);
        $cancel_formmodulelink = \Drupal::l(t('Cancel'), $url);

        $form['buttons']['cancel'] = [
            '#markup' => $cancel_formmodulelink,
            '#prefix' => '<div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => isset($this->display_mode) ? '</div></div></div><div class="col-md-6"></div>' : '</div></div></div>',
        ];
        $form['milestonedesc'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Milestone Description'),
            '#default_value' =>  ($form_state->getValue('milestonedesc') != false)? $form_state->getValue('milestonedesc') :$formmilestonedet['milestonedesc'],
	    '#attributes' =>  isset($this->display_mode) ? ['readonly' => 'readonly', 'style' => 'background:#F2F3F8;'] : [], 
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        ];
	$form['datetime'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Date'),
            '#default_value' => ($form_state->getValue('datetime') != false) ? $form_state->getValue('datetime') : date('m / d / Y h:i:s A', strtotime($formmilestonedet['datetime'])),
            '#attributes' =>  isset($this->display_mode) ? ['readonly' => 'readonly', 'style' => 'background:#F2F3F8;'] : [], 
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        ];
	
	$form['file'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Attachment'),
            '#default_value' => ($form_state->getValue('file') != false) ? $form_state->getValue('file') : $formmilestonedet['file'],
            '#attributes' =>  isset($this->display_mode) ? ['readonly' => 'readonly', 'style' => 'background:#F2F3F8;'] : [], 
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        ];
	$form['filemime'] = [
            '#type' => 'textfield',
            '#title' => $this->t('File Type'),
            '#default_value' => ($form_state->getValue('filemime') != false) ? $form_state->getValue('filemime') : $formmilestonedet['filemime'],
            '#attributes' =>  isset($this->display_mode) ? ['readonly' => 'readonly', 'style' => 'background:#F2F3F8;'] : [], 
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        ];
	$form['latitude'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Latitude'),
            '#default_value' => ($form_state->getValue('latitude') != false) ? $form_state->getValue('latitude') : $formmilestonedet['latitude'],
            '#attributes' =>  isset($this->display_mode) ? ['readonly' => 'readonly', 'style' => 'background:#F2F3F8;'] : [], 
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        ];
	$form['longitude'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Longitude'),
            '#default_value' => ($form_state->getValue('longitude') != false) ? $form_state->getValue('longitude') : $formmilestonedet['longitude'],
            '#attributes' =>  isset($this->display_mode) ? ['readonly' => 'readonly', 'style' => 'background:#F2F3F8;'] : [], 
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        ];
	
        $url = Url::fromRoute('formmilestone_example.list');
        $url->setOptions($link_options);
        $cancel_formmodulelink = \Drupal::l(t('Cancel'), $url);

        $form['actions']['cancel'] = [
            '#markup' => $cancel_formmodulelink,
            '#prefix' => '<div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div>',
        ];
        $form['formbodyend'] = [
            '#markup' => '</form></div></div>'
        ];


        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
 	/*if ($form_state->getValue('apmdname') == '') {
            $form_state->setErrorByName('apmdname', $this->t('Please enter name'));
        }

        if ($form_state->getValue('apmdtype') == '') {
            $form_state->setErrorByName('apmdtype', $this->t('Please enter type'));
        }

        if ($form_state->getValue('apmddesc') == '') {
            $form_state->setErrorByName('apmddesc', $this->t('Please enter field description'));
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

        $appmilestonepk = $form_state->getValue('appmilestonepk');
        // drupal_set_message(t('An error occurred and processing did not complete.'), 'error');


        // $values = $form_state->getValues();

        // $insertid = db_insert('tragformmilestone')
        //         ->milestone(array(
        //             'formmilestoneno' => $values['formmilestoneno'],
        //             'formmilestonedate' => $values['formmilestonedate'],
        //             'packdate' => $values['packdate'],
        //             'usebydate' => $values['usebydate'],
        //             'netweight' => $values['netweight'],
        //             'packedweight' => $values['packedweight'],
        //             'formmilestonetext' => $values['formmilestonetext'],
        //             'productdesc' => $values['productcode'],
        //         ))
        //         ->execute();

        // if ($insertid) {
        //     $query = db_select('tragcustomtemplatemilestone', 'tempmilestone');
        //     $query->milestone('tempmilestone', ['fcode', 'source']);
        //     $query->condition('customtemplatepk', $customtemplatepk, '=');
        //     $result = $query->execute()->fetchAll();
        //     foreach ($result as $k => $val) {
        //         $fcode = $values[$val->fcode];
        //         $insertprod = db_insert('trproductinfo')
        //                 ->milestone(array(
        //                     'apmdgpk' => $insertid,
        //                     'productpk' => 1, //$values['productcode'],
        //                     'lablecode' => $val->fcode,
        //                     'labledesc' => $fcode,
        //                         // 'updatedby' => $values['formmilestonetext'],
        //                 ))
        //                 ->execute();
        //     }
        // }

        // //$form_state->setRebuild();
        // $form_state->setRedirect('formmilestone_example.list');

       // $vals = $form_state->getValues();

      /*  switch ($this->formmode) {
            case 'NEW':
                $returnval = Formmilestone_biz::save_formmilestone($form, $form_state);
                if ($returnval == 'FAIL') {                    
                } else {
                    drupal_set_message(t("Formmilestone details Saved Successfully"));
                    $form_state->setRedirect('formmilestone_example_display', array('appmilestonepk' => $returnval));
                }
                break;
            case 'EDIT':
                $returnval = Formmilestone_biz::edit_formmilestone($form, $form_state, $this->appmilestonepk);
                if ($returnval == 'FAIL') {
                    
                } else {
                    drupal_set_message(t("Formmilestone Updated Successfully"));
                    $form_state->setRedirect('formmilestone_example_display', array('appmilestonepk' => $this->appmilestonepk));
                }
                break;
            default:
                $form_state->setRedirect('formmilestone_example.list');
                break;
        }*/





    }

}
