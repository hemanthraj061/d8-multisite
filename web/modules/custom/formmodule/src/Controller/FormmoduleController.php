<?php

namespace Drupal\formmodule\Controller;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\customutil\CustomUtils;

Class FormmoduleController {

    public function formmodulelist($apmdgpk) {

        
	$headerquery = db_select('appmdgroup', 'a');
        $headerquery->fields('a');
        $headerquery->condition('apmdgpk', $apmdgpk, '=');
        $result = $headerquery->execute()->fetchAssoc();
	$gethdr = json_decode($result['aptablefields'], true);
	foreach ($gethdr as $itm)  {$header[$itm] = db_query("SELECT apmddesc from {appmetadata} WHERE apmdname = :apmdname LIMIT 1", array(":apmdname" => $itm))->fetchField();
	  $headers[] = $itm;
	}
	$header['operations'] = t('Edit');
        $header['deletecomp'] = t('Delete');

        
        $rows = array();
        // $getlist=Product_Biz::getproductlist();
        $query = db_select('xappform', 'a');
        $query->fields('a');
        $query->condition('appformid', $apmdgpk, '=');
        

        $getlist = $query->execute();
       


        $link_options = array('attributes' => array('class' => array('btn btn-xs default btn-editable'),),);
        $link_options_delete = array('attributes' => array('class' => array('btn', 'btn-danger'),),);
        foreach ($getlist as $item) {
	    $r = json_decode($item->appgroupfields, true);
	    foreach ($r as $key => $value) {
		if (in_array($key, $headers)) {
		  if (strpos($key, 'date') !== false) $row[] = date('m / d / Y', strtotime($value));
		  else $row[] = $value;
		}
	    }
            $idarray = array('apmdgpk' => $apmdgpk, 'appformpk' => $item->appformpk);
            $edit_formmodule = CustomUtils::editButton('formmodule_example_edit', $idarray, 'extrasmall', 'Edit');
            $delete_formmodule = CustomUtils::deleteButton('formmodule_example_delete', $idarray, 'extrasmall', 'Delete');
            $dispurl = Url::fromRoute('formmodule_example_display', $idarray);
            $row[0] = \Drupal::l(t($row[0]), $dispurl);
	    $row[] = $edit_formmodule;
	    $row[] = $delete_formmodule;
            // Row with attributes on the row and some of its cells.
            $rows[] = array(
                'data' => $row
            );
	    unset($row);
        }

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
                                    List of ' . $result['apmdgroupname'] . '
                                </h3>
                            </div>',
            '#prefix' => '<div class="kt-portlet__head kt-portlet__head--lg">',
            '#suffix' => '</div>'
        ];

//          $url = Url::fromUri('internal:/product/new',NULL);
//        $url = Url::fromRoute('mymodule_addcompany');
//        $url->setOptions($link_options);
//        $add_companylink = \Drupal::l(t('Add Company'), $url);
        $add_formmodule = CustomUtils::addButton('formmodule_example.form', array('apmdgpk' => $apmdgpk), 'medium', 'Add ' . $result['apmdgroupname'].' Form');

        $form['tablebody']['table_heading']['submit'] = [
            '#markup' => $add_formmodule,
            '#prefix' => '<div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">',
            '#suffix' => '</div></div></div>',
        ];




        $form['tablebody']['company_table'] = array(
            '#theme' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#attributes' => array(
                'id' => 'kt_table_1',
                'class' => "table table-striped- table-bordered table-hover"
            ),
            '#prefix' => '<div class="kt-portlet__body">',
            '#suffix' => '</div>',
        );
//        $form['pager'] = array(
//            '#type' => 'pager'
//        );
       // $form['#attached']['library'][] = 'productmaster/productmasterlib';


        return $form;
    }

}
