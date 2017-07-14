<?php
/**
 * COmanage Registry Collaboration Error Plugin Co Config Fields
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
  $args['controller'] = 'co_collaboration_error_configs';
  $args['action'] = 'index';
  if(isset($cur_co)) {
    $args['co'] = $cur_co['Co']['id'];
  }
  $this->Html->addCrumb(_txt('ct.co_collaboration_error_configs.pl'), $args);
  $crumbTxt = _txt('op.' . $this->action . '-a', array(_txt('ct.co_collaboration_error_configs.1')));
  $this->Html->addCrumb($crumbTxt);
    
  if(isset($cur_co))
    print $this->Form->hidden('co_id', array('default' => $cur_co['Co']['id'])) . "\n";
?>
<table id="<?php print $this->action; ?>_co" class="ui-widget">
  <tbody>
    <tr class="line1">
      <td>
        <?php print ($e ? $this->Form->label('discovery_return_url', _txt('pl.co_collaboration_error_config.discovery_return_url.fd.name')) : _txt('pl.co_collaboration_error_config.discovery_return_url.fd.name')); ?><span class="required">*</span>
      </td>
      <td>
        <?php print ($e ? $this->Form->input('discovery_return_url') : filter_var($co_collaboration_error_configs[0]['CoCollaborationErrorConfig']['discovery_return_url'],FILTER_SANITIZE_SPECIAL_CHARS)); ?>
      </td>
    </tr>
    <tr class="line2">
      <td>
        <?php print ($e ? $this->Form->label('idpolr_entityid', _txt('pl.co_collaboration_error_config.idpoflr_entityid.fd.name')) : _txt('pl.co_collaboration_error_config.idpoflr_entityid.fd.name')); ?>
      </td>
      <td>
        <?php print ($e ? $this->Form->input('idpolr_entityid') : filter_var($co_collaboration_error_configs[0]['CoCollaborationErrorConfig']['idpoflr_entityid'],FILTER_SANITIZE_SPECIAL_CHARS)); ?>
      </td>
    </tr>
    <tr class="line1">
      <td>
        <?php print ($e ? $this->Form->label('mdq_baseurl', _txt('pl.co_collaboration_error_config.mdq_baseurl.fd.name')) : _txt('pl.co_collaboration_error_config.mdq_baseurl.fd.name')); ?>
      </td>
      <td>
        <?php print ($e ? $this->Form->input('mdq_baseurl') : filter_var($co_collaboration_error_configs[0]['CoCollaborationErrorConfig']['mdq_baseurl'],FILTER_SANITIZE_SPECIAL_CHARS)); ?>
      </td>
    </tr>
    <tr class="line2">
      <td>
        <?php print ($e ? $this->Form->label('help_email', _txt('pl.co_collaboration_error_config.help_email.fd.name')) : _txt('pl.co_collaboration_error_config.help_email.fd.name')); ?><span class="required">*</span>
      </td>
      <td>
        <?php print ($e ? $this->Form->input('help_email') : filter_var($co_collaboration_error_configs[0]['CoCollaborationErrorConfig']['help_email'],FILTER_SANITIZE_SPECIAL_CHARS)); ?>
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
