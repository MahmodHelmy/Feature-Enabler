<?php
/**
 * @file
 * Contains \Drupal\feature_enabler\Controller\AccessServiceFields.
 */

namespace Drupal\feature_enabler\Controller;
use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for adding field to access services taxonomy
 */
class AccessServiceFields extends ControllerBase {
  
  public function AddingAccessServiceFields($vid) {
    // access id field 
    // check if field storage is exist and delete it
    $FieldStorageConfig = \Drupal\field\Entity\FieldStorageConfig::loadByName('taxonomy_term', 'field_access_id');
    if(!is_null($FieldStorageConfig)){
      $FieldStorageConfig->delete();
    }
    \Drupal\field\Entity\FieldStorageConfig::create(
      array(      
        'field_name' => 'field_access_id',
        'entity_type' => 'taxonomy_term',
        'type' => 'string',
        'settings' => array(
          'max_length' => 255,
          'is_ascii' => FALSE,
          'case_sensitive' => FALSE,
        ),
        'module' => 'core',
        'locked' => FALSE,
        'cardinality' => 1
      )
    )->save();
    \Drupal\field\Entity\FieldConfig::create(
        array(      
          'field_name' => 'field_access_id',
          'entity_type' => 'taxonomy_term',
          'bundle' => $vid,
          'label' => 'Access ID',
          'description' => 'adding machine name for selected services',
          'required' => TRUE,
        )
    )->save();
    // service type field 
    $FieldStorageConfig = \Drupal\field\Entity\FieldStorageConfig::loadByName('taxonomy_term', 'field_services_type');
    if(!is_null($FieldStorageConfig)){
      $FieldStorageConfig->delete();
    }
    \Drupal\field\Entity\FieldStorageConfig::create(
      array(      
        'field_name' => 'field_services_type',
        'entity_type' => 'taxonomy_term',
        'type' => 'list_string',
        'settings' => array(
          'allowed_values' => array(
            'block' => "block",
            'view' => "view",
            'webform' => "webform",
            'content' => "content",
            'menu_link_content' => "menu link content",
          ),
        ),
        'module' => 'core',
        'locked' => FALSE,
        'cardinality' => 1
      )
    )->save();
    \Drupal\field\Entity\FieldConfig::create(
      array(      
        'field_name' => 'field_services_type',
        'entity_type' => 'taxonomy_term',
        'bundle' => $vid,
        'label' => 'Services Type',
        'description' => 'Select type of service ',
        'required' => TRUE,
      )
    )->save();
    // service type field 
    $FieldStorageConfig = \Drupal\field\Entity\FieldStorageConfig::loadByName('taxonomy_term', 'field_access_action');
    if(!is_null($FieldStorageConfig)){
      $FieldStorageConfig->delete();
    }
    \Drupal\field\Entity\FieldStorageConfig::create(
      array(      
        'field_name' => 'field_access_action',
        'entity_type' => 'taxonomy_term',
        'type' => 'list_string',
        'settings' => array(
          'allowed_values' => array(
            0 => "Disabled",
            1 => "Enabled",
          ),
        ),
        'module' => 'core',
        'locked' => FALSE,
        'cardinality' => 1      
      )
    )->save();
    \Drupal\field\Entity\FieldConfig::create(
      array(      
        'field_name' => 'field_access_action',
        'entity_type' => 'taxonomy_term',
        'bundle' => $vid,
        'label' => 'Access Action',
        'description' => 'Select action that will be applied on selected services',
        'required' => TRUE,
      )
    )->save();  
    // service type field 
    $FieldStorageConfig = \Drupal\field\Entity\FieldStorageConfig::loadByName('taxonomy_term', 'field_access_type');
    if(!is_null($FieldStorageConfig)){
      $FieldStorageConfig->delete();
    }
    \Drupal\field\Entity\FieldStorageConfig::create(
      array(      
        'field_name' => 'field_access_type',
        'entity_type' => 'taxonomy_term',
        'type' => 'entity_reference',
        'settings' => array(
            'handler' => "default:taxonomy_term",
            'target_type' => 'taxonomy_term',
            'handler_settings' => [
              'target_bundles' => [
                "access_types" => "access_types",
              ],
            ],
        ),
        'module' => 'core',
        'locked' => FALSE,
        'cardinality' => 1      
      )
    )->save();
    \Drupal\field\Entity\FieldConfig::create(
      array(      
          'field_name' => 'field_access_type',
          'entity_type' => 'taxonomy_term',
          'bundle' => $vid,
          'label' => 'Access Type',
          'description' => 'Select access type to be related with this service',
          'required' => TRUE,
      )
    )->save();      
  }
}