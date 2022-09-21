<?php
/**
 * @file
 * Contains \Drupal\feature_enabler\Controller\AddingServicesFeatures.
 */

namespace Drupal\feature_enabler\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\taxonomy\Entity\Term;

/**
 * Controller for adding field to Adding Services Features
 */
class AddingServicesFeatures extends ControllerBase {

  public function HandelAddingServicesFeatures() {
    // adding access types opac , portal with action type array(key=>action_type , value=>access_type)
    $access_types = array(
      0=>'Opac',
      1=>'Portal'
    );
    // service list array(service machine name , service type)
    $services_list = array(
      "contact_form"=>"webform",
      "eservices"=>"view",
      "views_block__eservices_homepage_eservices"=>"block",
      "views_block__upcoming_events_block"=>"block",
      "views_block__home_page_blocks_recent_news"=>"block",
      "eresources"=>"view",
      "homepageaboutusblock"=>"block",
      "homepagefaqblock"=>"block",
      "11"=>"menu_link_content", // E-Services link in main menu
      "45"=>"menu_link_content", // 	E-Resources link in main menu
      "1"=>"menu_link_content", // contact us link in main menu
      "35"=>"menu_link_content", // my account in user account menu
      "22"=>"menu_link_content", // my account in Dashboard  menu
      "23"=>"menu_link_content",// e-services in Dashboard  menu
      "36"=>"menu_link_content",// contact us link in footer menu
      "61"=>"menu_link_content",// FAQs link in footer menu
      "59"=>"menu_link_content",// 	Privacy Policy link in footer menu
   //   ""=>"menu_link_content",

    );
    foreach($access_types as $action_type=>$access_type){
      $term = Term::create([
        'name' => "$access_type",
        'vid' => 'access_types',
      ]);
      $term->save();
      $access_type_id = $term->id();
      // adding serivices with type
      foreach($services_list as $service_id => $service_type){
        $service_term = Term::create([
          'name' => "$access_type $service_id",
          'vid' => 'access_services',
        ]);
        $service_term->field_access_id->value = $service_id;
        $service_term->field_services_type->value = $service_type;
        $service_term->field_access_action->value = $action_type;
        $service_term->field_access_type->target_id = $access_type_id;
        $service_term->save();
      }
    }
  }
}
