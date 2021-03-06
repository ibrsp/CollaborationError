<?php
/**
 * COmanage Registry Collaboration Error Plugin Co Primary Identier Error Fields
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

  // Determine if fields are editable
  $e = false;
  
  if(($this->action == "add" && $permissions['add']) || ($this->action == "edit" && $permissions['edit']))
    $e = true;
    
  // We shouldn't get here if we don't have at least read permission, but check just in case
  
  if(!$e && !$permissions['view'])
    return(false);

  // Add breadcrumbs
  print $this->element("coCrumb");
  $args = array();
  $args['plugin'] = 'collaboration_error';
  $args['controller'] = 'co_collaboration_error_primary_identifier_errors';
  $args['action'] = 'index';
  if(isset($cur_co)) {
    $args['co'] = $cur_co['Co']['id'];
  }
  $this->Html->addCrumb(_txt('ct.co_collaboration_error_primary_identifier_errors.pl'), $args);
  $crumbTxt = _txt('op.' . $this->action . '-a', array(_txt('ct.co_collaboration_error_primary_identifier_errors.1')));
  $this->Html->addCrumb($crumbTxt);
    
  if(isset($cur_co))
    print $this->Form->hidden('co_id', array('default' => $cur_co['Co']['id'])) . "\n";
?>
<table id="<?php print $this->action; ?>_co" class="ui-widget">
  <tbody>
    <tr class="line1">
      <td>
        <?php print ($e ? $this->Form->label('idp', _txt('pl.co_collaboration_error_primary_identifier_error.idp.fd.name')) : _txt('pl.co_collaboration_error_primary_identifier_error.idp.fd.name')); ?>
      </td>
      <td>
        <?php print ($e ? $this->Form->input('idp') : filter_var($co_collaboration_error_primary_identifier_errors[0]['CoCollaborationErrorPrimaryIdentifierError']['idp'],FILTER_SANITIZE_SPECIAL_CHARS)); ?>
      </td>
    </tr>
    <tr class="line2">
      <td>
        <?php print ($e ? $this->Form->label('sp', _txt('pl.co_collaboration_error_primary_identifier_error.sp.fd.name')) : _txt('pl.co_collaboration_error_primary_identifier_error.sp.fd.name')); ?><span class="required">*</span>
      </td>
      <td>
        <?php print ($e ? $this->Form->input('sp', array('class' => 'focusFirst')) : filter_var($co_collaboration_error_primary_identifier_errors[0]['CoCollaborationErrorPrimaryIdentifierError']['sp'],FILTER_SANITIZE_SPECIAL_CHARS)); ?>
      </td>
    </tr>
    <tr>
      <td>
        <em><span class="required"><?php print _txt('fd.req'); ?></span></em><br />
      </td>
      <td>
        <?php
          if($e) {
            print $this->Form->submit($submit_label);
            print $this->Form->button(_txt('op.reset'), 
                                      array('type'=>'reset'));
          }
        ?>
      </td>
    </tr>
  </tbody>
</table>
