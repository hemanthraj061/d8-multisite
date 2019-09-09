<?php

namespace Drupal\formdashboard\Controller;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\customutil\CustomUtils;

Class FormdashboardController {

    public function formdashboard() {
        

        $rows = array();
        $query = db_select('appmdgroup', 'a');
        $query->fields('a');
        
        $getlist = $query->execute();
        global $base_url;
	foreach ($getlist as $item) {
            $rows[] = '<div class="col-md-6"><img src="'.$base_url.'/modules/custom/formdashboard/forms.png">' . CustomUtils::editButton('formmodule_example.list', array('apmdgpk' => $item->apmdgpk), 'medium', $item->apmdgroupname) . '</div>';
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
                                    Form Configuration
                                </h3>
                            </div>',
            '#prefix' => '<div class="kt-portlet__head kt-portlet__head--lg">',
            '#suffix' => '</div>'
        ];



        $form['tablebody']['company_table'] = array(
            '#markup' => '<div class="row formconf">' . implode("\t", $rows) . '</div>',
        );

        $form['#attached']['library'][] = 'formdashboard/formdashboard';


        return $form;
    }

}
