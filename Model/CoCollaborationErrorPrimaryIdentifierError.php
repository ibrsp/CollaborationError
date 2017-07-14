<?php
/**
 * COmanage Registry Collaboration Error Plugin Co Primary Identifier Error Model
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
 * @package       registry-plugin
 * @since         COmanage Registry v2.0.0
 * @license       Apache License, Version 2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */

class CoCollaborationErrorPrimaryIdentifierError extends AppModel {
  // Define class name for cake
  public $name = "CoCollaborationErrorPrimaryIdentifierError";

  // Add behaviors
  public $actAs = array('Containable');

  // Association rules from this model to other models
  public $belongsTo = array(
    // A Primary Identifier Error is attached to a CO
    "Co",
  );

  // Default display field for cake generated views
  public $displayField = "idp";

  // Validation rules for table elements
  public $validate = array(
    'co_id' => array(
      'rule' => 'numeric',
      'required' => true,
      'message' => 'A CO ID must be provided'
    ),
    'idp' => array( 
      'idp-rule-1' => array(
        'rule' => 'notBlank',
        'required' => true,
        'allowEmpty' => false,
      ),
      'idp-rule-2' => array(
        'rule' => array('maxLength', 256),
        'message' => 'IdP entityIDs must be no longer than 256 characters long'
      )
    ),
    'sp' => array(
      'sp-rule-1' => array(
        'rule' => 'notBlank',
        'required' => true,
        'allowEmpty' => false,
      ),
      'sp-rule-2' => array(
        'rule' => array('maxLength', 256),
        'message' => 'SP entityIDs must be no longer than 256 characters long'
      )
    ),
  );
  
}
