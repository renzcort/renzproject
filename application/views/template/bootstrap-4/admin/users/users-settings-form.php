<?php
  $attributes = array(
    'class' =>  'form',
    'id'    =>  'MyForm',
  );
  echo form_open($action, $attributes);
?>
<div class="middle-content flex-grow-1" id="users-settings">
  <input type ="hidden" name="button" value="<?php echo $button_name; ?>">
  <input type="hidden" id="button_name" name="button" value="<?php echo $button_name; ?>">
  <input type="hidden" name="id" value="<?php echo (!empty($getDataby_id->handle) ? $getDataby_id->handle : ''); ?>">
  <input type="hidden" name="table" value="<?php echo $table; ?>">
  <input type="hidden" name="header" value="<?php echo $title; ?>">
  <input type="hidden" name="subtitle" value="<?php echo $subtitle; ?>">
  <input type="hidden" name="content" value="<?php echo $content; ?>">
  <input type="hidden" name="right_content" value="<?php echo $right_content; ?>">
  <input type="hidden" name="handle" value="<?php echo $handle; ?>">
  <input type="hidden" name="fields_element" value="<?php echo $fields_element; ?>">
  <input type="hidden" name="action" value="<?php echo $action; ?>">
  <div class="form-group assetsRestrictUpload">
    <label class="heading" for="inputUploadLocation">User Photo Location</label>
    <small class="form-text text-muted">Where do you want to store user photos? Note that the subfolder path can contain variables like {username}.</small>
    <div class="d-flex flex-row justify-content-between">
      <select name="assetsSourcesList" class="form-control costum-select">
        <option value="0">Default</option>
        <?php 
          if ($assets) { 
            foreach ($assets as $key) {
              echo '
              <option value="'.$key->id.'" 
              '.((!empty($getDataby_id->assetsSourcesList) && $getDataby_id->assetsSourcesList == $key->id) ? 'selected' : '').'>
              '.$key->name.'
              </option>';
            }
          }
        ?>
      </select>
      <input type="text" name="path" placeholder="path/to/subfolder" class="form-control flex-grow-1 ml-2"
      value="<?php echo (!empty($getDataby_id->path) ? $getDataby_id->path : set_value('path')); ?>">
    </div>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" value="1" name="email_verification" checked>
    <label class="form-check-label" for="defaultCheck1">Verify email addresses?</label>
    <small class="form-text text-muted">Should new email addresses be verified before getting saved to user accounts? (This also affects new user registration.)</small>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" value="1" name="allowRegistration">
    <label class="form-check-label" for="defaultCheck1">Allow public registration?</label>
  </div>
  <div class="form-group default-group d-none">
    <label class="heading" for="inputType">Default User Group</label>
    <small class="form-text text-muted">Choose a user group that publicly-registered members will be added to by default.</small>
    <select name="default_group" class="form-control costum-select">
    <?php 
      foreach ($usersgroup as $key) {
      echo '
      <option value ="'.$key->id.'"
        '.((!empty($getDataby_id->id) && $getDataby_id->id == $key->id) ? 'selected' : '' ).'>
        '.$key->name.'
      </option>';
      }
    ?>
    </select>
  </div>
  <?php echo form_close(); ?>
</div>