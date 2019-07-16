<div class="tabs flex-grow-1 " id="users-form">
  <ul class="nav nav-tabs d-flex flex-row flex-nowrap" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#account" role="tab" aria-controls="settings" aria-selected="true">Account</a>
    </li>
    <?php
      if (json_encode($users_settings->fields_id) != NULL) {
        echo '
        <li class="nav-item">
          <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
        </li>'; 
      } 
    ?>
    <li class="nav-item">
      <a class="nav-link" id="layout-tab" data-toggle="tab" href="#permissions" role="tab" aria-controls="layout" aria-selected="false">Permissions</a>
    </li>
  </ul>
  <?php
    $attributes = array('class' => 'form',
                        'id' => 'MyForm',
                  ); 
    echo form_open($action.(isset($id) ? '/edit/'.$id : '/create'), $attributes); 
  ?>
  <div class="middle-content">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="settings-tab">
        <input type ="hidden" id="button_name" name="button" value="<?php echo $button_name; ?>">
        <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
        <div class="form-group">
          <label class="heading required" for="inputUsername">Username</label>
          <input type="text" name="username" class="form-control"  placeholder="Username" 
          value="<?php echo (!empty($getDataby_id->username) ? $getDataby_id->username : set_value('username')); ?>">
          <div class="form-error"><?php echo form_error('username'); ?></div>
        </div>
        <div class="d-flex flex-row flex-nowrap justify-content-between">
          <div class="form-group w-50 pr-3">
            <label class="heading required" for="inputFirstname">Firstname</label>
            <input type="text" name="firstname" class="form-control"  placeholder="Firstname" 
            value="<?php echo (!empty($getDataby_id->firstname) ? $getDataby_id->firstname : set_value('firstname')); ?>">
            <div class="form-error"><?php echo form_error('firstname'); ?></div>
          </div>
          <div class="form-group w-50 pl-3">
            <label class="heading required" for="inputLastname">Lastname</label>
            <input type="text" name="lastname" class="form-control"  placeholder="Lastname" 
            value="<?php echo (!empty($getDataby_id->lastname) ? $getDataby_id->lastname : set_value('lastname')); ?>">
            <div class="form-error"><?php echo form_error('lastname'); ?></div>
          </div>
        </div>
        <div class="form-group">
          <label class="heading required" for="inputEmail">Email</label>
          <input type="email" name="email" class="form-control"  placeholder="Email" 
          value="<?php echo (!empty($getDataby_id->email) ? $getDataby_id->email : set_value('username')); ?>">
          <div class="form-error"><?php echo form_error('email'); ?></div>
        </div>
      </div>
      <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="layout-tab">
        <div class="form-group">
          <label class="heading required" for="inputUsersgroup">Users group</label>
          <?php 
            if ($usersgroup) {
              echo '
                <select class="form-control costum-select" name="group">';
                foreach ($usersgroup as $key) {
                  echo '<option value="'.$key->id.'" 
                  '.((!empty($getDataby_id->group_id) && $getDataby_id->group_id == $key->id) ? 'selected' : '' ).'>
                  '.$key->name.'
                  </option>';  
                }
               echo '</select>';
            } else {
              echo '<small class="form-text text-muted">What this field will be called in the CP.</small>';
            }
          ?>
        </div>
        <div class="form-group">
          <label class="heading required" for="inputPermissions">Permissions</label>
          <?php 
            if ($permissions) {
              echo '
                <select class="form-control costum-select" name="role">';
                foreach ($permissions as $key) {
                  echo '<option value="'.$key->id.'" 
                  '.((!empty($getDataby_id->role_id) && $getDataby_id->role_id == $key->id) ? 'selected' : '' ).'>
                  '.$key->name.'
                  </option>';  
                }
               echo '</select>';
            } else {
              echo '<small class="form-text text-muted">What this field will be called in the CP.</small>';
            }
          ?>
        </div>
        
        <div id="usersgroup-form">
          <div class="form-group">
            <label for="inputGeneral" class="heading">General</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="generalAccessOff" value="true"
              <?php echo ((!empty($permission->generalAccessOff) && $permission->generalAccessOff == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Access the site when the system is off</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="generalAccessCP" value="true"
              <?php echo ((!empty($permission->generalAccessCP) && $permission->generalAccessCP == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Access the CP</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="generalAccessCPOffline" value="true"
                <?php echo ((!empty($permission->generalAccessCPOffline) && $permission->generalAccessCPOffline == TRUE) ? 'checked' : '');?>>
                <label class="form-check-label" for="defaultCheck1">Access the CP when the system is offline</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="generalPerformPluginUpdate" value="true"
                <?php echo ((!empty($permission->generalPerformPluginUpdate) && $permission->generalPerformPluginUpdate == TRUE) ? 'checked' : '');?>>
                <label class="form-check-label" for="defaultCheck1">Perform Craft CMS and plugin updates</label>
              </div>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="generalCustomizeElementSource" value="true"
              <?php echo ((!empty($permission->generalCustomizeElementSource) && $permission->generalCustomizeElementSource == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Customize element sources</label>
            </div>
          </div>
          <div class="form-group">
            <label for="inputUsers" class="heading">Users</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="usersEdit" value="true"
              <?php echo ((!empty($permission->usersEdit) && $permission->usersEdit == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Edit users</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="usersModerate" value="true"
              <?php echo ((!empty($permission->usersModerate) && $permission->usersModerate == TRUE) ? 'checked' : '');?>>
                <label class="form-check-label" for="defaultCheck1">Moderate users</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="usersAssignEdit" value="true"
              <?php echo ((!empty($permission->usersAssignEdit) && $permission->usersAssignEdit == TRUE) ? 'checked' : '');?>>
                <label class="form-check-label" for="defaultCheck1">Assign user Edit</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="usersAssignGroups" value="true"
              <?php echo ((!empty($permission->usersAssignGroups) && $permission->usersAssignGroups == TRUE) ? 'checked' : '');?>>
                <label class="form-check-label" for="defaultCheck1">Assign user groups</label>
                <?php 
                  if ($usersgroup) {
                    foreach ($usersgroup as $usrgrp) {
                      echo '
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="usersAssigns['.$usrgrp->handle.']" value="true"
                        '.((!empty($permission->usersAssigns[$usrgrp->handle]) && $permission->usersAssigns[$usrgrp->handle] == TRUE) ? 'checked' : '').'>
                        <label class="form-check-label" for="defaultCheck1">Assign users to “'.$usrgrp->name.'”</label>
                      </div>';
                    }
                  }
                ?>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="usersAdministrate" value="true"
              <?php echo ((!empty($permission->usersAdministrate) && $permission->usersAdministrate == TRUE) ? 'checked' : '');?>>
                <label class="form-check-label" for="defaultCheck1">Administrate users</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="usersImpersonate" value="true"
              <?php echo ((!empty($permission->usersImpersonate) && $permission->usersImpersonate == TRUE) ? 'checked' : '');?>>
                <label class="form-check-label" for="defaultCheck1">Impersonate users</label>
              </div>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="usersDelete" value="true"
              <?php echo ((!empty($permission->usersDelete) && $permission->usersDelete == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Delete users</label>
            </div>
          </div>

          <?php
            if ($section) {
              foreach ($section as $sec) {
                echo '  
                  <div class="form-group" id="section" data-handle="'.$sec->handle.'">
                    <label for="inputSection" class="heading">Section '.($sec->name ? "- {$sec->name}" : '').'</label>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="sectionEdit['.$sec->handle.']" data-handle="'.$sec->handle.'" value="true"
                      '.((!empty($permission->sectionEdit) && in_array($sec->handle, $sectionEdit)) ? 'checked' : '').'>
                      <label class="form-check-label" for="defaultCheck1">Edit “'.$sec->name.'”</label>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sectionPublishLiveChange['.$sec->handle.']" value="true"
                        '.((!empty($permission->sectionPublishLiveChange) && in_array($sec->handle, $sectionPublishLiveChange)) ? 'checked' : '').'>
                        <label class="form-check-label" for="defaultCheck1">Publish live changes</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sectionEditOtherAuthors['.$sec->handle.']" value="true"
                        '.((!empty($permission->sectionEditOtherAuthors) && in_array($sec->handle, $sectionEditOtherAuthors)) ? 'checked' : '').'>
                        <label class="form-check-label" for="defaultCheck1">Edit other authors’ drafts</label>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="sectionPublishOtherAuthors['.$sec->handle.']" value="true"
                          '.((!empty($permission->sectionPublishOtherAuthors) && in_array($sec->handle, $sectionPublishOtherAuthors)) ? 'checked' : '').'>
                          <label class="form-check-label" for="defaultCheck1">Publish other authors’ drafts</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="sectionDelete['.$sec->handle.']" value="true"
                          '.((!empty($permission->sectionDelete) && in_array($sec->handle, $sectionDelete)) ? 'checked' : '').'>
                          <label class="form-check-label" for="defaultCheck1">Delete other authors’ drafts</label>
                        </div>
                      </div>
                    </div>
                  </div>'; 
              } 
            }

            if ($globals) {
              echo 
                '<div class="form-group">
                  <label for="inputGlobal" class="heading">Global Sets</label>';
              foreach ($globals as $glo) {
                echo '
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="editGlobal['.$glo->handle.']" value="true"
                '.((!empty($permission->editGlobal) && in_array($sec->handle, $editGlobal)) ? 'checked' : '').'>
                <label class="form-check-label" for="defaultCheck1">Edit “'.$ass->name.'”</label>
              </div>';
              }
              echo '</div>';
            } 

            if ($assets) {
              foreach ($assets as $ass) {
                echo '<div class="form-group" id="assets" data-handle="'.$ass->handle.'">
                <label for="inputGlobal" class="heading">Volume '.($ass->name ? "- {$sec->name}" : '').'</label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="volumeView['.$ass->handle.']" value="true"
                  '.((!empty($permission->volumeView) && in_array($ass->handle, $volumeView)) ? 'checked' : '').'>
                  <label class="form-check-label" for="defaultCheck1">View volume</label>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="volumeUploadFiles['.$ass->handle.']" value="true"
                    '.((!empty($permission->volumeUploadFiles) && in_array($ass->handle, $volumeUploadFiles)) ? 'checked' : '').'>
                    <label class="form-check-label" for="defaultCheck1">Upload files</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="volumeCreateSubfolder['.$ass->handle.']" value="true"
                    '.((!empty($permission->volumeCreateSubfolder) && in_array($ass->handle, $volumeCreateSubfolder)) ? 'checked' : '').'>
                    <label class="form-check-label" for="defaultCheck1">Create subfolders</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="volumeRemoveFilesAndFolders['.$ass->handle.']" value="true"
                    '.((!empty($permission->volumeRemoveFilesAndFolders) && in_array($ass->handle, $volumeRemoveFilesAndFolders)) ? 'checked' : '').'>
                    <label class="form-check-label" for="defaultCheck1">Remove files and folders</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="volumeEditImages['.$ass->handle.']" value="true"
                    '.((!empty($permission->volumeEditImages) && in_array($ass->handle, $volumeEditImages)) ? 'checked' : '').'>
                    <label class="form-check-label" for="defaultCheck1">Edit images</label>
                  </div>
                </div>
              </div>';
              } 
            }
          ?>
          <div class="form-group">
            <label for="inputGlobal" class="heading">Utilities</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="utilitiesUpdates" value="true"
              <?php echo ((!empty($permission->utilitiesUpdates) && $permission->utilitiesUpdates == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Updates</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="utilitiesSystemReport" value="true"
              <?php echo ((!empty($permission->utilitiesSystemReport) && $permission->utilitiesSystemReport == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">System Report</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="utilitiesPHPInfo" value="true"
              <?php echo ((!empty($permission->utilitiesPHPInfo) && $permission->utilitiesPHPInfo == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">PHP Info</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="utilitiesSystemMessage" value="true"
              <?php echo ((!empty($permission->utilitiesSystemMessage) && $permission->utilitiesSystemMessage == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">System Messages</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="utilitiesAssetIndexes" value="true"
              <?php echo ((!empty($permission->utilitiesAssetIndexes) && $permission->utilitiesAssetIndexes == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Asset Indexes</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="utilitiesClearCaches" value="true"
              <?php echo ((!empty($permission->utilitiesClearCaches) && $permission->utilitiesClearCaches == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Clear Caches</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="utilitiesDeprecationWarnings" value="true"
              <?php echo ((!empty($permission->utilitiesDeprecationWarnings) && $permission->utilitiesDeprecationWarnings == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Deprecation Warnings</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="utilitiesDatabaseBackup" value="true"
              <?php echo ((!empty($permission->utilitiesDatabaseBackup) && $permission->utilitiesDatabaseBackup == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Database Backup</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="utilitiesFindAndReplace" value="true"
              <?php echo ((!empty($permission->utilitiesFindAndReplace) && $permission->utilitiesFindAndReplace == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Find and Replace</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="utilitiesMigrations" value="true"
              <?php echo ((!empty($permission->utilitiesMigrations) && $permission->utilitiesMigrations == TRUE) ? 'checked' : '');?>>
              <label class="form-check-label" for="defaultCheck1">Migrations</label>
            </div>
          </div>
        </div>
      </div>

    <?php
      if (json_encode($users_settings->fields_id) != NULL) {
        echo '
          <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="layout-tab">';
          if ($element) {
            foreach ($fields_id as $id) {
              foreach ($fields as $key) {
                if ($id == $key->id) {
                  $settings   = json_decode($key->settings);
                  $fieldsName = "fields_{$key->handle}";
                  echo '<div class="form-group">
                    <label class="heading" for="input'.$key->handle.'">'.ucfirst($key->name).'</label>';
                    if ($key->type_name == 'plainText') {
                      if ($settings->plainLineBreak == 1) {
                        echo '<textarea class="form-control"
                              name="fields_'.$key->handle.'" 
                              id="textarea"
                              rows="'.$settings->plainInitialRows.'"
                              placeholder="'.$settings->plainPlaceholder.'">'.(!empty($getDataby_id->$fieldsName) ? trim(strip_tags($getDataby_id->$fieldsName)) : '').'</textarea>';        
                      } else {
                        echo '<input type="text" class="form-control" 
                                name="fields_'.$key->handle.'" 
                                placeholder="'.(!empty($setttings->plainPlaceholder) ? $setttings->plainPlaceholder : '').'"
                                maxlength="'.(!empty($settings->plainCharlimit) ? $settings->plainCharlimit : '').'"
                                value="'.(!empty($getDataby_id->$fieldsName) ? $getDataby_id->$fieldsName : set_value($fieldsName)).'">';                    
                      }
                    } elseif ($key->type_name == 'assets') {
                      foreach ($assets as $ast) {
                        if ($ast->id == $settings->assetsSourcesList) {
                          $data['name'] = $ast->name;
                        }
                      }

                      echo '<div id="fields-assets-entries">
                              <ul class="list-unstyled selected">';
                                if (!empty($getDataby_id->$fieldsName)) {
                                  $assetsList = explode(', ', $getDataby_id->$fieldsName);
                                  if ($assets_content) {
                                    foreach ($assets_content as $astcont) {
                                      $filename   = explode('.', $astcont->file);
                                      $name       = current($filename);
                                      $thumb      = current($filename).'_thumb.'.end($filename);
                                      $file_thumb = base_url("{$astcont->path}/{$thumb}");
                                      $getSize    = get_headers($file_thumb, 1);
                                      if (in_array($astcont->id, $assetsList)) {
                                        echo '
                                            <li><input type="hidden" name="'.$fieldsName.'[]" value="'.$astcont->id.'">
                                              <img src="'.$file_thumb.'" class="img-thumbnail assets-list" 
                                              data-id="'.$astcont->id.'" heigth="20" width="30"/>
                                              <label for="input'.$name.'">'.$name.'</label>
                                              <a><i class="fa fa-times" aria-hidden="true"></i></a
                                            </li>';
                                      }
                                    }
                                  }
                                }
                      echo '</ul>';
                      echo '<div>
                              <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#assetsModal"
                              data-assets-id = "'.$settings->assetsSourcesList.'" 
                              data-assets-fields="fields_'.$key->handle.'"
                              data-assets-source="'.$settings->assetsSourcesInput.'">
                            + New Assets</button></div>';
                      echo '</div>';
                    } elseif ($key->type_name == 'richText') {
                    } elseif ($key->type_name == 'categories') {
                    } elseif ($key->type_name == 'checkboxes') {
                      $val = $settings->checkboxesValue; 
                      $i = 0;
                      foreach ($settings->checkboxesLabel as $chk => $value) {
                        $checkResult[] = array(
                          'label' => $value,
                          'value' => $val[$i]
                        );
                        $i++;
                      }

                      if (!empty($getDataby_id->$fieldsName)) {
                        $checkList = explode(', ', $getDataby_id->$fieldsName);
                      }

                      foreach ($checkResult as $chkResult) {
                        echo '<div class="form-check">
                                <input class="form-check-input" 
                                  type="checkbox" 
                                  name="fields_'.$key->handle.'[]" 
                                  value="'.$chkResult['value'].'"
                                  '.((!empty($getDataby_id->$fieldsName) && in_array($chkResult['value'], $checkList)) ? 'checked' : '').'>
                                <label class="form-check-label" 
                                  for="defaultCheck1">'.$chkResult['label'].'
                                </label>
                              </div>';
                      }
                    } elseif ($key->type_name == 'dateTime') {
                    } elseif ($key->type_name == 'dropdown') {
                      $val = $settings->dropdownValue; 
                      $i = 0;
                      foreach ($settings->dropdownLabel as $drp => $value) {
                        $dropResult[] = array(
                          'label' => $value,
                          'value' => $val[$i]
                        );
                        $i++;
                      }
                      if (!empty($getDataby_id->$fieldsName)) {
                        $checkList = explode(', ', $getDataby_id->$fieldsName);
                      }
                      echo '<select class="form-control costum-select" name="fields_'.$key->handle.'">';
                      foreach ($dropResult as $drpResult) {
                        echo '<option value="'.$drpResult['value'].'"
                        '.((!empty($getDataby_id->$fieldsName) && in_array($drpResult['value'], $checkList)) ? 'selected' : '').'>
                        '.$drpResult['label'].'</option>';
                      }
                      echo '</select>';
                    } elseif ($key->type_name == 'radio') {
                      $val = $settings->radioValue; 
                      $i = 0;
                      foreach ($settings->radioLabel as $rad => $value) {
                        $radioResult[] = array(
                          'label' => $value,
                          'value' => $val[$i]
                        );
                        $i++;
                      }
                      if (!empty($getDataby_id->$fieldsName)) {
                        $checkList = explode(', ', $getDataby_id->$fieldsName);
                      }
                      foreach ($radioResult as $radResult) {
                        echo '<div class="form-check">
                                <input class="form-check-input" type="radio" name="fields_'.$key->handle.'[]"  value="'.$radResult['value'].'"
                                '.((!empty($getDataby_id->$fieldsName) && in_array($radResult['value'], $checkList)) ? 'checked' : '').'>
                                <label class="form-check-label" for="defaultCheck1">'.$radResult['label'].'</label>
                              </div>';
                      }
                    }
                  echo '</div>';
                }
              }
            }
          }        
        echo '</div>';
      } 
    ?>
    </div>
  </div>
  <?php echo form_close(); ?>
</div>
