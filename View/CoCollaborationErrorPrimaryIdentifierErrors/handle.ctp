<?php
/**
 * COmanage Registry Collaboration Error Plugin Co Primary Identifier Handle View
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

  $params = array();
  $params['inline'] = false;

  print $this->Html->css('CollaborationError.boxed', $params);

?>

<div id="content">
<div id="content-inner">

  <h1>We're sorry, but you cannot enroll in the NIAID Science Forum at this time.</h1>
  <p>The NIAID Science Forum requires information about you that your login server
  <?php 
    $displayName = "";
    if(isset($vv_idp_metadata['mdui']['displayName'])) {
      $displayName = $vv_idp_metadata['mdui']['displayName'];
    } elseif (isset($vv_idp_metadata['organization']['organizationDisplayName'])) {
      $displayName = $vv_idp_metadata['organization']['organizationDisplayName'];
    } elseif (isset($vv_idp_metadata['organization']['organizationName'])) {
      $displayName = $vv_idp_metadata['organization']['organizationName'];
    }

    if($displayName) {
      print "(" . $displayName . ") ";
    }
  ?>
  did not release.</p>
  
  <p>To proceed, you may wish to:</p>
  
  <div class="boxed-content">
    <div class="box-title">1. Try one of these social providers:</div>
    <ul class="box-content">
      <li>
        <a href="<?php print $vv_discovery_return_url; ?>?entityID=https%3A%2F%2Fgoogle.cirrusidentity.com%2Fgateway">
          <div class="IdPSelectPreferredIdPImg"><img class="IdPSelectIdPImg" src="https://google.cirrusidentity.com/idp/logo/google_80_60.png" alt="Google" width="80" height="60"></div>
          <div class="IdPSelectTextDiv">Google</div>                      
        </a>
      </li>
      <li>
        <a href="<?php print $vv_discovery_return_url; ?>?entityID=https%3A%2F%2Fwin-live.cirrusidentity.com%2Fgateway">
          <div class="IdPSelectPreferredIdPImg"><img class="IdPSelectIdPImg" src="https://win-live.cirrusidentity.com/idp/logo/win-live_80_60.png" alt="Windows Live (Hotmail)" width="80" height="60"></div>
          <div class="IdPSelectTextDiv">Windows Live (Hotmail)</div>
        </a>
      </li>
      <li>
        <a href="<?php print $vv_discovery_return_url; ?>?entityID=https%3A%2F%2Fyahoo.cirrusidentity.com%2Fgateway">
          <div class="IdPSelectPreferredIdPImg"><img class="IdPSelectIdPImg" src="https://yahoo.cirrusidentity.com/idp/logo/yahoo_80_60.png" alt="Yahoo!" width="80" height="60"></div>
          <div class="IdPSelectTextDiv">Yahoo!</div>
        </a>
      </li>
    </ul>  
  </div>
  
  <div class="boxed-content">
    <div class="box-title">2. Try again:</div>
    <ul class="box-content">
      <li>
        <a href="<?php print $vv_discovery_return_url; ?>?entityID=<?php print urlencode($vv_idp_entityid); ?>">
          <div class="IdPSelectPreferredIdPImg">
            <?php if(isset($vv_idp_metadata['mdui']['logo']) && preg_match('/^https:/', $vv_idp_metadata['mdui']['logo'])): ?>
            <img class="IdPSelectIdPImg" src="<?php print $vv_idp_metadata['mdui']['logo']; ?>" alt=<?php print $displayName; ?> width="80" height="60">
            <?php else:
              $params = array();
              $params['class']  = "IdPSelectIdPImg";
              $params['alt']    = $displayName;
              $params['width']  = "80";
              $params['height'] = "60";
              print $this->Html->image('CollaborationError.last-resort-icon_80_60.png', $params);
              ?>
            <?php endif; ?>
          </div>
        <div class="IdPSelectTextDiv">Return<?php if($displayName) {print " to " . $displayName;} ?></div>                      
        </a>
      </li>
    </ul>  
  </div>
  
  <?php if($vv_idpoflr_entityid): ?>
  <div class="boxed-content">
    <div class="box-title">3. As a last resort, try:</div>
    <ul class="box-content">
      <li>
        <a href="<?php print $vv_discovery_return_url; ?>?entityID=">
          <div class="IdPSelectPreferredIdPImg">
            <?php
              $params = array();
              $params['class']  = "IdPSelectIdPImg";
              $params['alt']    = "IdP of Last Resort";
              $params['width']  = "80";
              $params['height'] = "60";
              print $this->Html->image('CollaborationError.last-resort-icon_80_60.png', $params);
            ?>
            </div>
          <div class="IdPSelectTextDiv">IdP of Last Resort</div>                      
        </a>
      </li>
    </ul>  
  </div>
  <?php endif; ?>
  
</div>  
