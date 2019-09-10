<?php

namespace Drupal\formmilestone\Controller;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\customutil\CustomUtils;

Class FormmilestoneController {

    public function formmilestonelist() {

        $header = array(
            'milestonedesc' => t('Milestone Desc'),
            'file' => t('Attachment'),
            'delete' => t('Delete'),
        );
        

        $rows = array();
        // $getlist=Product_Biz::getproductlist();
        $query = db_select('appmilestone', 'a');
        $query->fields('a');
        $query->orderBy('a.appmilestonepk', 'ASC');

        $getlist = $query->execute();
       
        foreach ($getlist as $item) {
            $idarray = array('appmilestonepk' => $item->appmilestonepk);
            $delete_formmilestone = CustomUtils::deleteButton('formmilestone_example_delete', $idarray, 'extrasmall', 'Delete');
            $dispurl = Url::fromRoute('formmilestone_example_display', array('appmilestonepk' => $item->appmilestonepk));
            $display_formmilestone = \Drupal::l(t($item->milestonedesc), $dispurl);

            // Row with attributes on the row and some of its cells.
            $rows[] = array(
                'data' => array($display_formmilestone, $item->file, $delete_formmilestone)
            );
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
                                    List of Milestone
                                </h3>
                            </div>',
            '#prefix' => '<div class="kt-portlet__head kt-portlet__head--lg">',
            '#suffix' => '</div>'
        ];

//          $url = Url::fromUri('internal:/product/new',NULL);
//        $url = Url::fromRoute('mymodule_addcompany');
//        $url->setOptions($link_options);
//        $add_companylink = \Drupal::l(t('Add Company'), $url);
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
   //     $form['#attached']['library'][] = 'productmaster/productmasterlib';


        return $form;
    }

}
