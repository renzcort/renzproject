<div class="middle-content flex-grow-1" id="usersgroup-form">
  <?php
    $attributes = array(
      'class' => 'form',
      'id' => 'MyForm',
    );
    echo form_open($action.(isset($id) ? '/edit/'.$id : '/create'), $attributes); 
  ?>
  <input type="hidden" name="button" value="<?php echo $button_name; ?>">
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
      <input class="form-check-input" type="checkbox" name="generalAccessOff" value="true">
      <label class="form-check-label" for="defaultCheck1">Access the site when the system is off</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="generalAccessCP" value="true">
      <label class="form-check-label" for="defaultCheck1">Access the CP</label>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="generalAccessCPOffline" value="true">
        <label class="form-check-label" for="defaultCheck1">Access the CP when the system is offline</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="generalPerformPluginUpdate" value="true">
        <label class="form-check-label" for="defaultCheck1">Perform Craft CMS and plugin updates</label>
      </div>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="generalCustomizeElementSource" value="true">
      <label class="form-check-label" for="defaultCheck1">Customize element sources</label>
    </div>
  </div>
  <div class="form-group">
    <label for="inputUsers" class="heading">Users</label>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="usersEdit" value="true">
      <label class="form-check-label" for="defaultCheck1">Edit users</label>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="usersModerate" value="true">
        <label class="form-check-label" for="defaultCheck1">Moderate users</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="usersAssignEdit" value="true">
        <label class="form-check-label" for="defaultCheck1">Assign user Edit</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="usersAssignGroups" value="true">
        <label class="form-check-label" for="defaultCheck1">Assign user groups</label>
        <?php 
          if ($usersgroup) {
            foreach ($usersgroup as $usrgrp) {
              echo '
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="usersAssign'.$usrgrp->handle.'" value="true">
                <label class="form-check-label" for="defaultCheck1">Assign users to “'.$usrgrp->name.'”</label>
              </div>';
            }
          }
        ?>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="usersAdministrate" value="true">
        <label class="form-check-label" for="defaultCheck1">Administrate users</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="usersImpersonate" value="true">
        <label class="form-check-label" for="defaultCheck1">Impersonate users</label>
      </div>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="usersDelete" value="true">
      <label class="form-check-label" for="defaultCheck1">Delete users</label>
    </div>
  </div>

  <?php
  if ($section) {
    foreach ($section as $sec) {
      echo '  
        <div class="form-group" id="section-'.$sec->handle.'">
          <label for="inputSection" class="heading">Section '.($sec->name ? "- {$sec->name}" : '').'</label>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="sectionEdit['.ucfirst($sec->handle).']" value="true">
            <label class="form-check-label" for="defaultCheck1">Edit “'.$sec->name.'”</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="sectionPublishLiveChange['.ucfirst($sec->handle).']" value="true">
              <label class="form-check-label" for="defaultCheck1">Publish live changes</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="sectionEditOtherAuthors['.ucfirst($sec->handle).']" value="true">
              <label class="form-check-label" for="defaultCheck1">Edit other authors’ drafts</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sectionPublishOtherAuthors['.ucfirst($sec->handle).']" value="true">
                <label class="form-check-label" for="defaultCheck1">Publish other authors’ drafts</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sectionDelete['.ucfirst($sec->handle).']" value="true">
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
      echo '<div class="form-group">
      <label for="inputGlobal" class="heading">Volume '.($ass->name ? "- {$sec->name}" : '').'</label>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="volumeViewVolume['.ucfirst($ass->handle).']" value="true">
        <label class="form-check-label" for="defaultCheck1">View volume</label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="volumeUploadFiles['.ucfirst($ass->handle).']" value="true">
          <label class="form-check-label" for="defaultCheck1">Upload files</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="volumeCreateSubfolder['.ucfirst($ass->handle).']" value="true">
          <label class="form-check-label" for="defaultCheck1">Create subfolders</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="volumeRemoveFilesAndFolders['.ucfirst($ass->handle).']" value="true">
          <label class="form-check-label" for="defaultCheck1">Remove files and folders</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="volumeEditImages['.ucfirst($ass->handle).']" value="true">
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
  <?php echo form_close();?>
</div>