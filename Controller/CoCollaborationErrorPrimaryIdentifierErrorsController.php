<?php
/**
 * COmanage Registry Collaboration Error Plugin Co Primary Identifier Error Controller
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

class CoCollaborationErrorPrimaryIdentifierErrorsController extends StandardController {
  // Class name, used by Cake
  public $name = "CoCollaborationErrorPrimaryIdentifierErrors";

  public $uses = array(
    'CollaborationError.CoCollaborationErrorPrimaryIdentifierError', 
    'CollaborationError.CoCollaborationErrorConfig'
  );

  // Establish pagination parameters for HTML views
  public $paginate = array(
    'limit' => 25,
    'order' => array(
      'CoCollaborationErrorPrimaryIdentifierError.id' => 'desc'
    )
  );

  // This controller needs a CO to be set
  public $requires_co = true;


  /**
   * Callback before other controller methods are invoked or views are rendered.
   *
   * @since  COmanage Registry 2.0.0
   * @return void
   */
  
  function beforeFilter() {
    // If action is 'handle' temporarily set requires_co to be false to
    // work around the parent AppController logic for named parameters
    // only being allowed for a discrete set of actions. We explicitly
    // handle the 'co' named parameter in the fuction for the 'handle' 
    // action.
    if($this->action == 'handle') {
      $this->requires_co = false;
    }

    // Invoke the normal parent filtering logic.
    parent::beforeFilter();  

    // Allow anonymous access since user not authenticated
    $this->Auth->allow('handle');
  }

  /**
   * Query MDQ server for IdP metadata.
   *
   * @since COmanage Registry 2.0.0
   * @param string $idp IdP entityID
   * @param string $mdqBaseUrl Base URL for the MDQ server
   * @param return array Array of metadata information
   */

  function getMetadata($idp, $mdqBaseUrl) {
    $metadata = array();

    // Return no metadata if no MDQ server configured.
    if(empty($mdqBaseUrl)) {
      return $metadata;
    }

    // Query MDQ server for entity metadata.
    $parsedUrl = parse_url($mdqBaseUrl);

    $uri = array();
    $uri['scheme'] = $parsedUrl['scheme'];
    $uri['host']   = $parsedUrl['host'];
    $uri['path']   = $parsedUrl['path'] . '/entities/' . urlencode($idp);

    $request = array();
    $request['method'] = 'GET';
    $request['header'] = array('Accept', 'application/samlmetadata+xml');
    $request['uri']    = $uri;

    $httpSocket = new HttpSocket();
    $response = $httpSocket->request($request);

    // Return no metadata if the response from the MDQ server is
    // anything other than 200.
    if(!$response->isOk()) {
      return $metadata;
    }

    // Create XML document from the body payload.
    $xml = new SimpleXMLElement($response->body);

    // Register the namespaces we need to parse the XML.
    $xml->registerXPathNamespace("md", "urn:oasis:names:tc:SAML:2.0:metadata");
    $xml->registerXPathNamespace("mdui", "urn:oasis:names:tc:SAML:metadata:ui");

    // Parse for the mdui:DisplayName
    $nodes = $xml->xpath("/md:EntityDescriptor/md:IDPSSODescriptor/md:Extensions/mdui:UIInfo/mdui:DisplayName");
    if($nodes) {
      $metadata['mdui']['displayName'] = (string) $nodes[0];
    }

    // Parse for the OrganizationDisplayName
    $nodes = $xml->xpath("/md:EntityDescriptor/md:Organization/md:OrganizationDisplayName");
    if($nodes) {
      $metadata['organization']['organizationDisplayName'] = (string) $nodes[0];
    }

    // Parse for the OrganizationName
    $nodes = $xml->xpath("/md:EntityDescriptor/md:Organization/md:OrganizationName");
    if($nodes) {
      $metadata['organization']['organizationName'] = (string) $nodes[0];
    }

    // Parse for a mdui:Logo, there may be more than one, for now we just take the first one found.
    $nodes = $xml->xpath("/md:EntityDescriptor/md:IDPSSODescriptor/md:Extensions/mdui:UIInfo/mdui:Logo");
    if($nodes) {
      $metadata['mdui']['logo'] = (string) $nodes[0];
    }

    return $metadata;
  }

  /**
   * Handle a Primary Identifier Error.
   *
   * @since COmanage Registry 2.0.0
   * @return void
   */

  function handle() {

    // If the CO is not present then we can only show
    // the user a generic error page.
    $coId = $this->request->params['named']['co'];

    if(empty($coId) || !preg_match('/^\d+$/', $coId)) {
      $this->render('CollaborationError.CoCollaborationErrorPrimaryIdentifierErrors/generic');
      return;
    }

    // Verify the anonymously input CO ID represents a valid CO.
    $args = array();
    $args['conditions']['Co.id'] = $coId;
    $args['contain']             = true; 
    if(!$this->CoCollaborationErrorPrimaryIdentifierError->Co->find('first', $args)) {
      $this->render('CollaborationError.CoCollaborationErrorPrimaryIdentifierErrors/generic');
      return;
    }

    // Pull the configuration for this CO.
    $args = array();
    $args['conditions']['Co.id'] = $coId;
    $args['contain']             = true; 

    $config = $this->CoCollaborationErrorConfig->find('first', $args);
    if(!$config) {
      // If a CO is valid the the plugin has not been configured yet we
      // just redirect to the generic landing page for now.
      $this->render('CollaborationError.CoCollaborationErrorPrimaryIdentifierErrors/generic');
      return;
    }

    $this->set('vv_help_email', $config['CoCollaborationErrorConfig']['help_email']);

    // Parse the IdP and SP entityIDs from the query string and record the data.
    $idp = $this->request->query('idp');
    $sp = $this->request->query('sp');

    if(empty($idp) || empty($sp)) {
      $this->render('CollaborationError.CoCollaborationErrorPrimaryIdentifierErrors/generic');
      return;
    }

    $data = array();
    $data['co_id'] = $coId;
    $data['idp']   = $idp;
    $data['sp']    = $sp;

    if(!$this->CoCollaborationErrorPrimaryIdentifierError->save($data)) {
      $this->render('CollaborationError.CoCollaborationErrorPrimaryIdentifierErrors/generic');
      return;
    }

    // Set the discovery return URL.
    $this->set('vv_discovery_return_url', $config['CoCollaborationErrorConfig']['discovery_return_url']);

    // Set the IdP of Last Resort entityID.
    $this->set('vv_idpoflr_entityid', $config['CoCollaborationErrorConfig']['idpolr_entityid']);

    // Set the entityID for the IdP.
    $this->set('vv_idp_entityid', $idp);

    // Query for the metadata for this IdP.
    $metadata = $this->getMetadata($idp, $config['CoCollaborationErrorConfig']['mdq_baseurl']);
    $this->set('vv_idp_metadata', $metadata);

    // Don't display the login button in the view.
    $this->set('noLoginLogout', true);
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
    
    // All operations require platform or CO administrator
    // except for handling a new primary identifier error
    // using the 'handle' action.
    
    // Add a new error?
    $p['add'] = ($roles['cmadmin'] || $roles['coadmin']);

    // Delete an existing error?
    $p['delete'] = ($roles['cmadmin'] || $roles['coadmin']);
    
    // Edit an existing error?
    $p['edit'] = ($roles['cmadmin'] || $roles['coadmin']);

    // Handle a new error?
    $p['handle'] = true;
    
    // View all existing errors?
    $p['index'] = ($roles['cmadmin'] || $roles['coadmin']);
    
    // View an existing error?
    $p['view'] = ($roles['cmadmin'] || $roles['coadmin']);
    
    $this->set('permissions', $p);
    return $p[$this->action];
  }
}
