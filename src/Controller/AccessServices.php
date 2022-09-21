<?php

/**
 * @file
 * Contains \Drupal\feature_enabler\Controller\accessservices.
 */

namespace Drupal\feature_enabler\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Menu\MenuLinkInterface;
use Drupal\menu_link_content\Plugin\Menu\MenuLinkContent;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Serialization\Yaml;
use Drupal\webform\Entity\Webform;
use Drupal\webform\WebformInterface;

/**
 * Controller for setting access for features (view,webform,block,menu item,node)
 * service name is machine name for service
 * service action (0= disabled , 1 = enabled)
 */

class AccessServices extends ControllerBase {
  
  public function handle_access_services($service_name,$service_action,$service_type) {
    // chack if service name is view , block , webform
    if($service_type == 'view' || $service_type == 'webform' || $service_type == 'block' ){
      $view = \Drupal::entityTypeManager()->getStorage("$service_type")->load($service_name);
      if(!is_null($view)){
        if($service_action == 0 ){
          $view->setStatus(FALSE);
        }else{
          $view->setStatus(TRUE);
        }
        $view->save();
      }   
    }
    // if service name is menu item Done
    if($service_type == 'menu_link_content'){
      $menu_item_id = $service_name;
      $menu_link = \Drupal::entityTypeManager()->getStorage("menu_link_content")->load($menu_item_id);
      if(!is_null($menu_link)){
        $menu_link->enabled = $service_action;
        $menu_link->save();
      }
    }
    //if service is node
    if($service_type == 'content'){
      $nid = $service_name;
      $node = \Drupal\node\Entity\Node::load($nid);
      if(!is_null($node)){
        $node->status = $service_action;
        $node->save();
      }  
    }  
  }
}