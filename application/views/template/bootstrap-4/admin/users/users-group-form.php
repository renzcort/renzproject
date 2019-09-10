<div class="content-body flex-grow-1" id="users">
  <div class="users-group-form" id="middle-content">
    <?php
      $attributes = array(
        'class' => 'form',
        'id'    => 'MyForm',
      );
      echo form_open($action.(isset($id) ? '/edit/'.$id : '/create'), $attributes);
    ?>
    <input type ="hidden" name="button" value="<?php echo $button_name; ?>">
    <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
    <input type ="hidden" name="table" value="<?php echo $table; ?>">
    <div class="form-group">
      <label class="heading required" for="inputName">Name</label>
      <small class="form-text text-muted">What this site will be called in the CP.</small>
      <input type="text" name="name" class="form-control"
      value="<?php echo (!empty($getDataby_id->name) ? $getDataby_id->name : set_value('name')); ?>">
      <div class="form-error"><?php echo form_error('name'); ?></div>
    </div>
    <div class="form-group">
      <label class="heading required" for="inputHandle">Handle</label>
      <label class="form-text text-muted">How you’ll refer to this site in the templates.</label>
      <input type="text" name="handle" class="form-control"
      value="<?php echo (!empty($getDataby_id->handle) ? $getDataby_id->handle : set_value('handle')); ?>">
      <div class="form-error"><?php echo form_error('handle'); ?></div>
    </div>
    <hr>
    <h5 class="heading">Permissions</h5>
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
                $handle = $usrgrp->handle;
                echo '
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="usersAssigns['.$usrgrp->handle.']" 
                    value="true" data-handle="'.$usrgrp->handle.'"
                    '.((!empty($permission->usersAssigns->$handle) && $permission->usersAssigns->$handle == TRUE) ? 'checked' : '').'>
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
    ?>
    
    <?php if ($globals) { ?>
    <div class="form-group">
      <label for="inputGlobal" class="heading">Global Sets</label>
      <?php 
        foreach ($globals as $glo) {
          echo '
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="editGlobal['.$glo->handle.']" value="true"
              '.((!empty($permission->editGlobal) && in_array($glo->handle, $editGlobal)) ? 'checked' : '').'>
              <label class="form-check-label" for="defaultCheck1">Edit “'.$glo->name.'”</label>
            </div>';
        } 
      ?>
    </div>
    <?php } ?>
    <?php
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
    <?php echo form_close();?>
  </div>
</div>