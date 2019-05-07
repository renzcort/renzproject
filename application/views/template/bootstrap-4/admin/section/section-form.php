<div class="middle-content flex-grow-1">
  <?php
    $attributes = array('class' => 'form',
                        'id'  =>  'MyForm'
                  ); 
    echo form_open($action.(isset($id) ? '/'.$id : ''), $attributes); 
  ?>
    <input type="hidden" name="<?php echo $button_name; ?>">
    <div class="form-group">
      <label class="heading required" for="inputName">Name</label>
      <small class="form-text text-muted">What this site will be called in the CP.</small>
      <input type="text" name="name" class="form-control" value="<?php echo (!empty($getDataby_id->name) ? $getDataby_id->name : set_value('name')); ?>">
      <div class="form-error"><?php echo form_error('name'); ?></div>
    </div>
    <div class="form-group">
      <label class="heading required" for="inputHandle">Handle</label>
      <label class="form-text text-muted">How you’ll refer to this site in the templates.</label>
      <input type="text" name="handle" class="form-control" value="<?php echo (!empty($getDataby_id->name) ? $getDataby_id->name : set_value('name')); ?>">
      <div class="form-error"><?php echo form_error('handle'); ?></div>
    </div>
    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" name="translateable" class="form-check-input">
        <label class="form-check-label" for="inputTranslateable">Enable versioning for entries in this section?</label>
      </div>
    </div>
    <div class="form-group">
      <label class="heading" for="inputSectionType">Section Type</label>
      <small class="form-text text-muted">What type of section is this?</small>
      <select name="sectionType" class="form-control costum-select">
      <option value="0">- Select Type -</option>
      <?php foreach ($section_type as $key ): ?>
        <option value="<?php echo $key->id ?>" <?php echo ((!empty($getDataby_id->type_id) && $getDataby_id->type_id == $key->id) ? 'selected' : ''); ?>><?php echo $key->name ?></option>
      <?php endforeach ?>
      </select>
    </div>
    <hr class="break-line"></hr>
    <div class="form-group">
      <label class="heading" for="inputSiteSettings">Site Settings</label>
      <label class="form-text text-muted">Choose which sites this section should be available in, and configure the site-specific settings.</label>
      <table class="table table-bordered text-center">
        <thead class="thead-dark">
          <th>Site</th>
          <th>Entry URI Format</th>
          <th>Template</th>
          <th>Default Status</th>
        </thead>
        <tbody>
          <tr class="start">
            <td class="first py-0">Craftcms</td>
            <td class="p-0"><input type="text" name="url" class="form-control" value="<?php echo (!empty($getDataby_id->url) ? $getDataby_id->url : set_value('url')); ?>"></td>
            <td class="p-0"><input type="text" name="template" class="form-control" value="<?php echo (!empty($getDataby_id->template) ? $getDataby_id->template : set_value('template')); ?>"></td>
            <td class="py-0">
              <div class="custom-control custom-switch">
                <input type="checkbox" name="activated" class="custom-control-input" id="customSwitch1">
                <label class="custom-control-label" for="customSwitch1">Disabled</label>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <?php echo form_close(); ?>
</div>