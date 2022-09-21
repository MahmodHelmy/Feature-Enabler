<?php  
/**  
 * @file  
 * Contains Drupal\feature_enabler\Form.  
 */  

/**
 * @author Mahmoud Helmy
 *
 * Copyright (c) 2021. Naseej
 */
namespace Drupal\feature_enabler\Form;  
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  
use Drupal\feature_enabler\Controller\AccessServices;

class ActiveServicesType extends ConfigFormBase { 

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'feature_enabler.access_type',
      
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'access_type';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $feature_enabler_config = $this->config('feature_enabler.access_type');
    // getting all available types from access types taxonomy
    $list_types = array();
    $query = \Drupal::entityQuery('taxonomy_term');
    $query->condition('vid', "access_types");
    $tids = $query->execute();
    $terms = \Drupal\taxonomy\Entity\Term::loadMultiple($tids);
    foreach ($terms as $term) {
      $list_types[$term->id()] = $term->name->value;
    }
    //print_r($list_types);
    $form['type'] = [
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => $this
        ->t('Select Type'),
      '#options' =>$list_types,
      '#default_value' => $feature_enabler_config->get('type'),
    ];
   

    $form['actions']['submit'] = [
        '#type' => 'submit',
        '#submit' => ['::submitForm'],
        '#button_type' => 'primary',
        '#value' => $this->t('Save Configuration'),
    ];
    return parent::buildForm($form, $form_state);  
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('feature_enabler.access_type')
       ->set('type', $form_state->getValue('type'))
       ->save();
    $select_type = $form_state->getValue('type');
    // getting all service depend on selected type 
    $query = \Drupal::database()->select('taxonomy_term__field_access_type', 't')
    ->fields('t', ['entity_id'])
    ->condition('field_access_type_target_id', $select_type);
    $query->condition('field_access_type_target_id', $select_type);
    $results = $query->execute();
    while ($content = $results->fetchAssoc()) {
      $tids  = $content['entity_id'];
      $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($tids);
      $service_name = $term->field_access_id->value;
      $service_action = $term->field_access_action->value;
      $service_type = $term->field_services_type->value;            
      $accessservices = new AccessServices;
      $accessservices->handle_access_services($service_name,$service_action,$service_type);
    }
  }

}