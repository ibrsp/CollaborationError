<?php
/**
 * COmanage Registry Collaboration Error Plugin Co Config Controller
 *
 * Portions licensed to the University Corporation for Advanced Internet
 * Development, Inc. ("UCAID") under one or more contributor license agreements.
 * See the NOTICE file distributed with this work for additional information
 * regarding copyright ownership.
 *
 * UCAID licenses this file to you under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with the
 * License. You may obtain a copy of the License at:
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * 
 * @link          http://www.internet2.edu/comanage COmanage Project
 * @package       registry
 * @since         COmanage Registry v2.0.0
 * @license       Apache License, Version 2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */

App::uses("StandardController", "Controller");
App::uses("HttpSocket", "Network/Http");

class CoCollaborationErrorConfigsController extends StandardController {
  // Class name, used by Cake
  public $name = "CoCollaborationErrorConfigs";

  // Establish pagination parameters for HTML views
  public $paginate = array(
    'limit' => 25,
    'order' => array(
      'CoCollaborationErrorConfig.id' => 'asc'
    )
  );

  // This controller needs a CO to be set
  public $requires_co = true;

  /**
   * Add a CO Collaboration Error Config
   *
   * @since  COmanage Registry v2.0.0
   */
  
  public function add() {
    // add() here deviates a bit from the typical behavior, since CO Collaboration 
    // Error Config has a 1-1 relationship to CO. We first check to see if there 
    // is an existing CO Collaboration Error Config record for the current CO. 
    // If there is then we redirect to edit().
    
    $args = array();
    $args['conditions']['CoCollaborationErrorConfig.co_id'] = $this->cur_co['Co']['id'];
    $args['contain'] = false;
    
    $config = $this->CoCollaborationErrorConfig->find('first', $args);
    
    if($config) {
      $this->redirect(array('action' => 'edit', $config['CoCollaborationErrorConfig']['id']));
    } 

    // No existing configuration for this CO so call the parent add().
    parent::add();
  }

  /**
   * Edit a CO Collaboration Error Config
   *
   * @since  COmanage Registry v2.0.0
   */
  public function edit($id) {
    parent::edit($id);

    // Create a more useful title
    $this->set('title_for_layout', _txt('op.edit-f',
                                        array(_txt('ct.co_collaboration_error_configs.1'),
                                              $this->viewVars['co_collaboration_error_configs'][0]['Co']['name'])));
  }

  /**
   * View CO Collaboration Error Configs
   *
   * @since  COmanage Registry v2.0.0
   */
  
  public function index() {
    // index() here deviates a bit from the typical behavior, since CO Collaboration 
    // Error Config has a 1-1 relationship to CO. We first check to see if there 
    // is an existing CO Collaboration Error Config record for the current CO. 
    // If there is then we redirect to edit() otherwise we redirect to add().
    
    $args = array();
    $args['conditions']['CoCollaborationErrorConfig.co_id'] = $this->cur_co['Co']['id'];
    $args['contain'] = false;
    
    $config = $this->CoCollaborationErrorConfig->find('first', $args);
    
    if($config) {
      $this->redirect(array('action' => 'edit', $config['CoCollaborationErrorConfig']['id']));
    } else {
      $this->redirect(array('action' => 'add'));
    }
  }

  /**
   * Authorization for this Controller, called by Auth component
   * - precondition: Session.Auth holds data used for authz decisions
   * - postcondition: $permissions set with calculated permissions
   *
   * @since  COmanage Registry 2.0.0
   * @return Array Permissions
   */
  
  function isAuthorized() {
    $roles = $this->Role->calculateCMRoles();

    // Construct the permission set for this user, which will also be passed to the view.
    $p = array();
    
    // All operations require platform or CO administrator.
    
    // Add a new config?
    $p['add'] = ($roles['cmadmin'] || $roles['coadmin']);

    // Delete an existing config?
    $p['delete'] = ($roles['cmadmin'] || $roles['coadmin']);
    
    // Edit an existing config?
    $p['edit'] = ($roles['cmadmin'] || $roles['coadmin']);

    // View all existing configs?
    $p['index'] = ($roles['cmadmin'] || $roles['coadmin']);
    
    // View an existing config?
    $p['view'] = ($roles['cmadmin'] || $roles['coadmin']);
    
    $this->set('permissions', $p);
    return $p[$this->action];
  }
}
