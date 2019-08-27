<?php

namespace Drupal\formfields\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
//use Drupal\Component\Utility\SafeMarkup;
//use Drupal\Component\Utility\Tags;
use Drupal\Component\Utility\Unicode;

/**
 * Defines a route controller for entity autocomplete form elements.
 */
class AutocompleteController extends ControllerBase {

    /**
     * Handler for autocomplete request.
     */
    public function productAutocomplete(Request $request) {
        $matches = array();
        $string = $request->query->get('q');
        $result = db_select('frtproduct', 'n')
                ->fields('n', array('productdesc', 'productpk'))
                ->condition('productdesc', '%' . db_like($string) . '%', 'LIKE')
//                ->condition('productcode', '%' . db_like($string) . '%', 'LIKE')
                ->execute();

        foreach ($result as $row) {
            $matches[$row->productpk] = $row->productdesc;
        }

        return new JsonResponse($matches);
    }

    static function getTemplateFields($templatepk) {
        $result = db_select('tragcustomtemplatefields', 'fc')
                ->fields('fc', array('slno', 'fcode', 'fname', 'ftype'))
                ->condition('customtemplatepk', $templatepk, '=')
                ->execute()
                ->fetchAll();
        return $result;
    }

    static function getTemplates() {
         $matches = array();
         $matches[] = 'Select Template';
        $result = db_select('tragcustomtemplate', 'fc')
                ->fields('fc', array('customtemplatepk', 'customtemplatename'))
                ->execute()
                ->fetchAll();
        foreach ($result as $row) {
            $matches[$row->customtemplatepk] = $row->customtemplatename;
        }
         return $matches;
    }
    
    
    public function manageAction() {

        $id = 1;

        $form = \Drupal::formBuilder()->getForm('Drupal\formfields\Form\FormbuildForm');

//        $form['type']['#title_display'] = 'invisible';

        return [ '#theme' => 'formfieldstheme',
            '#form' => $form,
            '#templatefields' => 'ss',
        ];
    }

}
