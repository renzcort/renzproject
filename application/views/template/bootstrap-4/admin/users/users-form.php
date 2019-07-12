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
    echo form_open($action.(isset($id) ? '/'.$id : ''), $attributes); 
  ?>
  <div class="middle-content">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="settings-tab">
        <input type ="hidden" id="button_name" name="button" value="<?php echo $button_name; ?>">
        <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
        <input type ="hidden" name="table" value="<?php echo $table; ?>">
        <input type ="hidden" name="fields_element" value="<?php echo $fields_element; ?>">
        <input type ="hidden" name="header" value="<?php echo $title; ?>">
        <input type ="hidden" name="subtitle" value="<?php echo $subtitle; ?>">
        <input type ="hidden" name="content" value="<?php echo $content; ?>">
        <input type ="hidden" name="action" value="<?php echo $action; ?>">
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
            <div class="form-error"><?php echo form_error('handle'); ?></div>
          </div>
        </div>
        <div class="form-group">
          <label class="heading required" for="inputEmail">Email</label>
          <input type="email" name="email" class="form-control"  placeholder="Email" 
          value="<?php echo (!empty($getDataby_id->email) ? $getDataby_id->email : set_value('username')); ?>">
          <div class="form-error"><?php echo form_error('username'); ?></div>
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
                  <input class="form-check-input" type="checkbox" name="sectionEdit['.$sec->handle.']" data-handle="'.$sec->handle.'" value="true">
                  <label class="form-check-label" for="defaultCheck1">Edit “'.$sec->name.'”</label>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sectionPublishLiveChange['.$sec->handle.']" value="true">
                    <label class="form-check-label" for="defaultCheck1">Publish live changes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sectionEditOtherAuthors['.$sec->handle.']" value="true">
                    <label class="form-check-label" for="defaultCheck1">Edit other authors’ drafts</label>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="sectionPublishOtherAuthors['.$sec->handle.']" value="true">
                      <label class="form-check-label" for="defaultCheck1">Publish other authors’ drafts</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="sectionDelete['.$sec->handle.']" value="true">
                      <label class="form-check-label" for="defaultCheck1">Delete other authors’ drafts</label>
                    </div>
                  </div>
                </div>
              </div>'; 
          } 
        }
        ?>
        <?php if ($globals) { ?>
        <div class="form-group">
          <label for="inputGlobal" class="heading">Global Sets</label>
          <?php foreach ($globals as $glo) {
            echo '
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="global'.$glo->handle.'Edit" value="true">
            <label class="form-check-label" for="defaultCheck1">Edit “'.$ass->name.'”</label>
          </div>';
          } ?>
        </div>
        <?php } ?>
        <?php 
        if ($assets) {
          foreach ($assets as $ass) {
            echo '<div class="form-group" id="assets" data-handle="'.$ass->handle.'">
            <label for="inputGlobal" class="heading">Volume '.($ass->name ? "- {$sec->name}" : '').'</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="volumeViewVolume['.$ass->handle.']" value="true">
              <label class="form-check-label" for="defaultCheck1">View volume</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="volumeUploadFiles['.$ass->handle.']" value="true">
                <label class="form-check-label" for="defaultCheck1">Upload files</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="volumeCreateSubfolder['.$ass->handle.']" value="true">
                <label class="form-check-label" for="defaultCheck1">Create subfolders</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="volumeRemoveFilesAndFolders['.$ass->handle.']" value="true">
                <label class="form-check-label" for="defaultCheck1">Remove files and folders</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="volumeEditImages['.$ass->handle.']" value="true">
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
            <input class="form-check-input" type="checkbox" name="utilitiesUpdates" value="true">
            <label class="form-check-label" for="defaultCheck1">Updates</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="utilitiesSystemReport" value="true">
            <label class="form-check-label" for="defaultCheck1">System Report</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="utilitiesPHPInfo" value="true">
            <label class="form-check-label" for="defaultCheck1">PHP Info</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="utilitiesSystemMessage" value="true">
            <label class="form-check-label" for="defaultCheck1">System Messages</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="utilitiesAssetIndexes" value="true">
            <label class="form-check-label" for="defaultCheck1">Asset Indexes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="utilitiesClearCaches" value="true">
            <label class="form-check-label" for="defaultCheck1">Clear Caches</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="utilitiesDeprecationWarnings" value="true">
            <label class="form-check-label" for="defaultCheck1">Deprecation Warnings</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="utilitiesDatabaseBackup" value="true">
            <label class="form-check-label" for="defaultCheck1">Database Backup</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="utilitiesFindAndReplace" value="true">
            <label class="form-check-label" for="defaultCheck1">Find and Replace</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="utilitiesMigrations" value="true">
            <label class="form-check-label" for="defaultCheck1">Migrations</label>
          </div>
        </div>
      </div>

    <?php
      if (json_encode($users_settings->fields_id) != NULL) {
        echo '
      <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="layout-tab">
        </div>
      </div>';
       
      } 
    ?>
    </div>
  </div>
  <?php echo form_close(); ?>
</div>
