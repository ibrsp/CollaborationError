<?php
/**
 * COmanage Registry Collaboration Error Plugin Co Primary Identifier Index View
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

  // Add breadcrumbs
  $this->Html->addCrumb(_txt('ct.co_collaboration_error_primary_identifier_errors.pl'));

  // Add page title
  $params = array();
  $params['title'] = $title_for_layout;

  // Add top links
  $params['topLinks'] = array();

  if($permissions['add']) {
    $params['topLinks'][] = $this->Html->link(
      _txt('op.add-a', array(_txt('ct.co_collaboration_error_primary_identifier_errors.1'))),
      array(
        'controller' => 'co_collaboration_error_primary_identifier_errors',
        'action' => 'add',
        'co' => $this->params['named']['co']
      ),
      array('class' => 'addbutton')
    );
  }

  print $this->element("pageTitleAndButtons", $params);

?>

<table id="co_collaboration_error_primary_identifier_errors" class="ui-widget">
  <thead>
    <tr class="ui-widget-header">
      <th><?php print $this->Paginator->sort('id', _txt('fd.id.seq')); ?></th>
      <th><?php print $this->Paginator->sort('created', _txt('fd.created.tz', array($vv_tz))); ?></th>
      <th><?php print $this->Paginator->sort('idp', _txt('pl.co_collaboration_error_primary_identifier_error.idp.fd.name')); ?></th>
      <th><?php print $this->Paginator->sort('sp', _txt('pl.co_collaboration_error_primary_identifier_error.sp.fd.name')); ?></th>
      <th><?php print _txt('fd.actions'); ?></th>
    </tr>
  </thead>
  
  <tbody>
    <?php $i = 0; ?>
    <?php foreach ($co_collaboration_error_primary_identifier_errors as $pie): ?>
    <tr class="line<?php print ($i % 2)+1; ?>">
      <td><?php print $pie['CoCollaborationErrorPrimaryIdentifierError']['id']; ?></td>
      <td><?php print $this->Time->niceShort($pie['CoCollaborationErrorPrimaryIdentifierError']['created'], $vv_tz); ?></td>
      <td><?php print filter_var($pie['CoCollaborationErrorPrimaryIdentifierError']['idp'],FILTER_SANITIZE_SPECIAL_CHARS); ?></td>
      <td><?php print filter_var($pie['CoCollaborationErrorPrimaryIdentifierError']['sp'],FILTER_SANITIZE_SPECIAL_CHARS); ?></td>
      <td>
        <?php
          if($permissions['edit']) {
            print $this->Html->link(
              _txt('op.edit'),
              array(
                'controller' => 'co_collaboration_error_primary_identifier_errors',
                'action' => 'edit',
                $pie['CoCollaborationErrorPrimaryIdentifierError']['id']
              ),
              array('class' => 'editbutton')
            ) . "\n";
          }
            
          if($permissions['delete']) {
            print '<button type="button" class="deletebutton" title="' . _txt('op.delete')
              . '" onclick="javascript:js_confirm_generic(\''
              . _txt('js.remove') . '\',\''    // dialog body text
              . $this->Html->url(              // dialog confirm URL
                array(
                  'controller' => 'co_collaboration_error_primary_identifier_errors',
                  'action' => 'delete',
                  $pie['CoCollaborationErrorPrimaryIdentifierError']['id']
                )
              ) . '\',\''
              . _txt('op.remove') . '\',\''    // dialog confirm button
              . _txt('op.cancel') . '\',\''    // dialog cancel button
              . _txt('op.remove') . '\',[\''   // dialog title
              . filter_var(_jtxt($pie['CoCollaborationErrorPrimaryIdentifierError']['id']),FILTER_SANITIZE_STRING)  // dialog body text replacement strings
              . '\']);">'
              . _txt('op.delete')
              . '</button>';
          }
        ?>
        <?php ; ?>
      </td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
  </tbody>
  
  <tfoot>
    <tr class="ui-widget-header">
      <th colspan="5">
        <?php print $this->element("pagination"); ?>
      </th>
    </tr>
  </tfoot>
</table>
