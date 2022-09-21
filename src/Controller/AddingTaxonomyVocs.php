<?php
/**
 * @file
 * Contains \Drupal\feature_enabler\Controller\AccessServiceFields.
 */

namespace Drupal\feature_enabler\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\feature_enabler\Controller\AccessServiceFields;

/**
 * Controller for adding Adding Taxonomy Vocs
 */
class AddingTaxonomyVocs extends ControllerBase {
  
  public function HandleAddingTaxonomyVocs($vid,$name,$description,$fields) {
    $Vocabulary_exist = \Drupal\taxonomy\Entity\Vocabulary::load($vid);
    if (is_null($Vocabulary_exist)) {
      $vocabulary = \Drupal\taxonomy\Entity\Vocabulary::create(array(
            'vid' => $vid,
            'description' =>$description,
            'name' => $name,
      ));
      $vocabulary->save();
      if(!is_null($fields)){
        $AccessServiceFields = new AccessServiceFields;
        $AccessServiceFields->AddingAccessServiceFields($vid);
      }
    }
  }
}