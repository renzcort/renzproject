<div class="middle-content flex-grow-1" id="sites">

    <?php
      $attributes = array('class' => 'form',
                          'id' => 'MyForm',
                    ); 
      echo form_open($action.(isset($id) ? '/'.$id : ''), $attributes); 
    ?>
    <input type="hidden" name="button" value="<?php echo $button_name; ?>">
    <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
    <input type ="hidden" name="table" value="<?php echo $table; ?>">
    <div class="form-group">
      <label class="heading" for="inputGroup">Group</label>
      <small class="form-text text-muted">Which group should this site belong to?</small>
      <select name="group" name="group_id" class="form-control costum-select">
      <option value="0">Default</option>
      <?php foreach ($group as $key): ?>
        <option value="<?php echo $key->id; ?>" data-id="<?php echo $key->id; ?>" 
          <?php echo ((!empty($getDataby_id->group_id) && $getDataby_id->group_id == $key->id) ? 'selected' : '' ) ?>>
          <?php echo ucfirst($key->name); ?>
        </option>
      <?php endforeach ?>
      </select>
    </div>
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
    <div class="form-group">
      <label class="heading" for="inputLanguage">Language</label>
      <small class="form-text text-muted">The Language content in this site will use.</small>
      <select name="language" class="form-control costum-select">
        <option value="0">- Select Language -</option>
      </select>
      <small class="form-test text-muted">Enable the Intl extension or install additional locale data files for more Language options.</small>
    </div>
    <div class="form-group">
      <label class="heading" for="inputPrimary">Is this the primary site?</label>
      <small class="form-text text-muted">The primary site will be loaded by default on the front end.</small>
      <div class="custom-control custom-switch">
        <input type="checkbox" name="primary" class="custom-control-input customSwitch" id="customSwitch1" 
      <?php echo ((!empty($getDataby_id->primary) && $getDataby_id->primary == 1) ? 'checked' : '') ?>>
      <label class="custom-control-label" for="customSwitch1">
        <?php echo ((!empty($getDataby_id->primary) && $getDataby_id->primary == 1) ? 'Enabled' : 'Disabled') ?>
      </label>
      </div>
    </div>
    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" name="url" class="form-check-input" 
        value="<?php echo (!empty($getDataby_id->url) ? 1 : 0) ?>"
        <?php echo (!empty($getDataby_id->url) ? 'checked' : '')?>>
        <label class="form-check-label" for="inputurl">This site has its own base URL</label>
      </div>
    </div>
    <div class="form-group" id="baseUrl">
      <label class="heading" for="inputBaseurl">Base URL</label>
      <small class="form-text text-muted">The base URL for the site.</small>
      <input type="text" name="baseurl" class="form-control" placeholder="@web/" 
      value="<?php echo (!empty($getDataby_id->baseurl) ? $getDataby_id->baseurl : set_value('baseurl')); ?>">
      <small class="form-text text-muted">The @web alias is not recommended if it is determined automatically.</small>
    </div>
  <?php echo form_close();?>
</div>