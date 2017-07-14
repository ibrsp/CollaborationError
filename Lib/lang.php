<?php
/**
 * COmanage Registry Collaboration Error Plugin Language File
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

global $cm_lang, $cm_texts;

// When localizing, the number in format specifications (eg: %1$s) indicates the argument
// position as passed to _txt.  This can be used to process the arguments in
// a different order than they were passed.

$cm_collaboration_error_texts['en_US'] = array(
  // Title, per-controller
  'ct.co_collaboration_error_primary_identifier_errors.1' => 'Primary Identifier Error',
  'ct.co_collaboration_error_primary_identifier_errors.pl' => 'Primary Identifier Errors',

  'ct.co_collaboration_error_configs.1' => 'Collaboration Error Configuration',
  'ct.co_collaboration_error_configs.pl' => 'Collaboration Error Configurations',

  // Menu
  'pl.co_collaboration_error.coconfig' => 'Collaboration Errors',
  'pl.co_collaboration_error.op.config' => 'Configure Collaboration Error Plugin',
  'pl.co_collaboration_error.op.view.primary_identifier_errors' => 'View Primary Identifier Errors',

  // Plugin texts
  'pl.co_collaboration_error_primary_identifier_error.sp.fd.name' => 'Service Provider', 
  'pl.co_collaboration_error_primary_identifier_error.idp.fd.name' => 'Identity Provider',

  'pl.co_collaboration_error_config.discovery_return_url.fd.name' => 'Discovery Return URL',
  'pl.co_collaboration_error_config.help_email.fd.name' => 'Helpdesk Email',
  'pl.co_collaboration_error_config.idpoflr_entityid.fd.name' => 'IdP of Last Resort entityID',
  'pl.co_collaboration_error_config.mdq_baseurl.fd.name' => 'MDQ Server Base URL',

);
