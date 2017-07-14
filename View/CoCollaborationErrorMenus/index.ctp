<?php
/**
 * COmanage Registry Collaboration Error Plugin CO Menus Index View
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
 * @since         COmanage Registry v0.8
 * @license       Apache License, Version 2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */

  // Add breadcrumbs
  print $this->element("coCrumb");
  $this->Html->addCrumb(_txt('pl.co_collaboration_error.coconfig'));

  // Add page title
  $params = array();
  $params['title'] = $title_for_layout;

  // Add top links
  $params['topLinks'] = array();

  print $this->element("pageTitleAndButtons", $params);

?>

<table id="co_collaboration_error_menus" class="ui-widget">
  <thead>
    <tr class="ui-widget-header">
      <th><?php print _txt('fd.actions'); ?></th>
    </tr>
  </thead>
  
  <tbody>
    <tr class="line1">
      <td>
        <?php
            
            print $this->Html->link(
              _txt('pl.co_collaboration_error.op.config'),
              array(
                'controller' => 'co_collaboration_error_configs',
                'action' => 'add',
                'co:' . $cur_co['Co']['id']
              ),
              array('class' => 'configurebutton')
            ) . "\n";

            print $this->Html->link(
              _txt('pl.co_collaboration_error.op.view.primary_identifier_errors'),
              array(
                'controller' => 'co_collaboration_error_primary_identifier_errors',
                'action' => 'index',
                'co:' . $cur_co['Co']['id']
              ),
              array('class' => 'viewbutton')
            ) . "\n";
          
        ?>
      </td>
    </tr>
  </tbody>
  
</table>

