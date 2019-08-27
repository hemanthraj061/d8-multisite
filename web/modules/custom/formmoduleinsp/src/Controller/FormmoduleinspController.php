<?php

namespace Drupal\formmoduleinsp\Controller;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\customutil\CustomUtils;

Class FormmoduleinspController {

    public function formmoduleinsplist($appinspformpk) {

        
	$headerquery = db_select('appinspectionform', 'a');
        $headerquery->fields('a');
        $headerquery->condition('appinspformpk', $appinspformpk, '=');
        $result = $headerquery->execute()->fetchAssoc();
        $header = array(
            'appinspformid' => t('Inspection ID'),
            'appinspformname' => t('Form Name'),
            'appinspauditor' => t('Auditor'),
            'appinspauditee' => t('Auditee'),
            'appauditdate' => t('Audit Date'),
            'appinspstatus' => t('Status'),
        //    'operations' => t('Edit'),
        //    'deletecomp' => t('Delete'),
        );

        $form['tablebody'] = array(
            '#markup' => '',
            '#prefix' => '<div class="kt-portlet kt-portlet--mobile">',
            '#suffix' => '</div>'
        );

        $form['tablebody']['table_heading'] = [
            '#markup' => '<div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon2-line-chart"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    List of ' . $result['appinspformname'] . '
                                </h3>
                            </div>',
            '#prefix' => '<div class="kt-portlet__head kt-portlet__head--lg">',
            '#suffix' => '</div>'
        ];

        $add_formmoduleinsp = CustomUtils::addButton('formmoduleinsp_example.form', array('appinspformpk' => $appinspformpk), 'medium', 'Add ' . $result['appinspformname'].' Form');

        $form['tablebody']['table_heading']['submit'] = [
            '#markup' => $add_formmoduleinsp,
            '#prefix' => '<div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div>',
        ];
	$form['formcoverstart']['#markup'] = '<div class="kt-portlet">';
        $form['formbody']['#markup'] = '<div class="kt-portlet__body">';
        
        $form['tabs'] = [
            '#markup' => '',
            '#prefix' => '<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">',
            '#suffix' => '</ul>',
        ];
        $form['tabs']['one'] = [
            '#markup' => '<a class="nav-link active" data-toggle="tab" href="#kt_tabs_2_1">Audit</a>',
            '#prefix' => '<li class="nav-item">',
            '#suffix' => '</li>',
        ];
        $form['tabs']['two'] = [
            '#markup' => '<a class="nav-link" data-toggle="tab" href="#kt_tabs_2_2">Feedback</a>',
            '#prefix' => '<li class="nav-item">',
            '#suffix' => '</li>',
        ];
        $form['tabs']['three'] = [
            '#markup' => '<a class="nav-link" data-toggle="tab" href="#kt_tabs_2_3">Completed</a>',
            '#prefix' => '<li class="nav-item">',
            '#suffix' => '</li>',
        ];

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
        $form['tabscontent']['three'] = [
            '#markup' => '',
            '#prefix' => '<div class="tab-pane" id="kt_tabs_2_3" role="tabpanel">',
            '#suffix' => '</div>',
        ];

        $form['tabscontent']['one']['productinfo1'] = $this->inspectiontab($appinspformpk, 'Audit', $header);
        $form['tabscontent']['two']['productinfo2'] = $this->inspectiontab($appinspformpk, 'Feedback', $header);
        $form['tabscontent']['three']['productinfo3'] = $this->inspectiontab($appinspformpk, 'Completed', $header);
        $form['formbodyend']['#markup'] = '</div>';
        $form['formcoverend']['#markup'] = '</div>';

        return $form;
    }
    function inspectiontab($appinspformpk, $appstatus, $header) {
	$rows = array();
        // $getlist=Product_Biz::getproductlist();
        $query = db_select('appinspectionform', 'a');
	$query->join('appinspectiondtl', 'b', 'b.appinspformpk = a.appinspformpk');
        $query->fields('a');
        $query->fields('b');
        $query->condition('a.appinspformpk', $appinspformpk, '=');
        $query->condition('a.appinspstatus', $appstatus, '=');
        $query->range(0, 1);
        $getlist = $query->execute();
       


        $link_options = array('attributes' => array('class' => array('btn btn-xs default btn-editable'),),);
        $link_options_delete = array('attributes' => array('class' => array('btn', 'btn-danger'),),);
        foreach ($getlist as $item) {
       //     $idarray = array('appinspformpk' => $item->appinspformpk, 'appinspdtlpk' => $item->appinspdtlpk);
       //     $edit_forminspection = CustomUtils::editButton('formmoduleinsp_example_edit', $idarray, 'extrasmall', 'Edit');
          //  $delete_forminspection = CustomUtils::deleteButton('forminspection_example_delete', $idarray, 'extrasmall', 'Delete');
            $dispurl = Url::fromRoute('formmodulelistinsp_example_display', array('appinspformpk' => $item->appinspformpk));
            $display_forminspection = \Drupal::l(t($item->appinspformid), $dispurl);

            // Row with attributes on the row and some of its cells.
            $rows[] = array(
                'data' => array($display_forminspection, $item->appinspformname, $item->appinspauditor, $item->appinspauditee, date('m / d / Y', strtotime($item->appauditdate)), $item->appinspstatus)
            );
        }
	$form['tablebody']['company_table'] = array(
            '#theme' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#attributes' => array(
                'id' => 'kt_table_2',
                'class' => "table table-striped- table-bordered table-hover"
            ),
            '#prefix' => '<div class="kt-portlet__body">',
            '#suffix' => '</div>',
        );
	return $form;
    }
}

