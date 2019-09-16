<?php

namespace Drupal\formdashboard\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\customutil\CustomUtils;
use Drupal\formdashboard\Controller\Formdashboard_biz;
use Drupal\formdashboard\Controller\AutocompleteController;


/**
 * Form with examples on how to use cache.
 */
class FormdashboardForm extends FormBase {

    public $appformmenupk;
      

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'formdashboard_example_form';
    }


    public function buildForm(array $form, FormStateInterface $form_state, $formmode = '', $appformmenupk = '') {

        $this->appformmenupk = $appformmenupk;
        $this->formmode = $formmode;
        $display_mode = FALSE;
        if ($this->formmode == 'DISPLAY') {

            $this->display_mode = TRUE;
        }

        $formdashboarddet = Formdashboard_biz::getformdashboarddet($appformmenupk);

        $form['formtitle'] = [
            '#markup' => '<i class="fa fa-gift"></i> &nbsp;Form Menu Info',
            '#prefix' => '<div class="kt-portlet__head"><div class="kt-portlet__head-label">',
            '#suffix' => '</div></div>',
        ];

        $form['formbody'] = [
            '#markup' => '<form role="form" class="kt-form">
                        <div class="form-body">
                        <div class="row">'
        ];

        if (!isset($this->display_mode)) {
	$form['submitup'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#prefix' => '<div class="col-md-6">&nbsp;</div><div class="col-md-6">&nbsp;</div><div class="col-md-6">',
            '#suffix' => '</div>'
        ];
	}
	else {
	$edit_formfields = CustomUtils::addButton('formdashboard_example_edit', array('appformmenupk' => $appformmenupk), 'medium', 'Edit Form Menu');

        $form['buttons']['submitedit'] = [
            '#markup' => $edit_formfields,
            '#prefix' => '<div class="col-md-6">&nbsp;</div><div class="col-md-6">&nbsp;</div><div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div>&nbsp;&nbsp;',
        ];
	$add_formfields = CustomUtils::addButton('formdashboard_example.form', '', 'medium', 'Add Form Menu');

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
        $url = Url::fromRoute('formmenu_example.list');
        $url->setOptions($link_options);
        $cancel_formmodulelink = \Drupal::l(t('Cancel'), $url);

        $form['buttons']['cancel'] = [
            '#markup' => $cancel_formmodulelink,
            '#prefix' => '<div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => isset($this->display_mode) ? '</div></div></div><div class="col-md-6"></div>' : '</div></div></div>',
        ];
        $form['menuname'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Menu Name'),
            '#default_value' =>  ($form_state->getValue('menuname') != false)? $form_state->getValue('menuname') :$formdashboarddet['menuname'],
	    '#attributes' =>  isset($this->display_mode) ? ['readonly' => 'readonly', 'style' => 'background:#F2F3F8;'] : [], 
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        ];
	
	$form['formlist'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Form List'),
            '#default_value' => ($form_state->getValue('formlist') != false) ? $form_state->getValue('formlist') : $formdashboarddet['formlist'],
            '#attributes' =>  isset($this->display_mode) ? ['readonly' => 'readonly', 'style' => 'background:#F2F3F8;'] : [], 
            '#prefix' => '<div class="col-md-6">',
            '#suffix' => '</div>'
        ];
	
        if (!isset($this->display_mode)) {
	$form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#prefix' => '<div class="col-md-6">&nbsp;</div><div class="col-md-6">&nbsp;</div><div class="col-md-6">',
            '#suffix' => '</div>'
        ];
	}
	else {
	$edit_formfields = CustomUtils::addButton('formdashboard_example_edit', array('appformmenupk' => $appformmenupk), 'medium', 'Edit Form Menu');

        $form['actions']['submitedit'] = [
            '#markup' => $edit_formfields,
            '#prefix' => '<div class="col-md-6">&nbsp;</div><div class="col-md-6">&nbsp;</div><div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div>&nbsp;&nbsp;',
        ];
	$add_formfields = CustomUtils::addButton('formdashboard_example.form', '', 'medium', 'Add Form Menu');

        $form['actions']['submitadd'] = [
            '#markup' => $add_formfields,
            '#prefix' => '<div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div>&nbsp;&nbsp;',
        ];
	}
        $url = Url::fromRoute('formmenu_example.list');
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

        $appformmenupk = $form_state->getValue('appformmenupk');

        switch ($this->formmode) {
            case 'NEW':
                $returnval = Formdashboard_biz::save_formdashboard($form, $form_state);
                if ($returnval == 'FAIL') {                    
                } else {
                    drupal_flush_all_caches();
                    drupal_set_message(t("Formmenu details Saved Successfully"));
                    $form_state->setRedirect('formdashboard_example_display', array('appformmenupk' => $returnval));
                }
                break;
            case 'EDIT':
                $returnval = Formdashboard_biz::edit_formdashboard($form, $form_state, $this->appformmenupk);
                if ($returnval == 'FAIL') {
                    
                } else {
                    drupal_flush_all_caches();
                    drupal_set_message(t("Formmenu Updated Successfully"));
                    $form_state->setRedirect('formdashboard_example_display', array('appformmenupk' => $this->appformmenupk));
                }
                break;
            default:
                $form_state->setRedirect('formmenu_example.list');
                break;
        }





    }

}
