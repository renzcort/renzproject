<div class="middle-content flex-grow-1">
    <?php
      $attributes = array(
                    'class' =>  'form',
                    'id'    =>  'MyForm',
                  );
      echo form_open($action, $attributes);
    ?>
    <input type="hidden" name="<?php echo $button_name; ?>">
    <div class="form-group">
      <label class="heading" for="inputSystemName">System Name</label>
      <input type="text" name="systemname" class="form-control" placeholder="System Name" 
      value="<?php echo (!empty($getDataby_id->systemname) ? $getDataby_id->systemname : set_value('systemname') ) ?>">
    </div>
    <div class="form-group">
      <label class="heading" for="inputSystemStatus">System Status</label>
      <div class="custom-control custom-switch">
        <input type="checkbox" name="status" class="custom-control-input" id="customSwitch1" 
        value="1" <?php echo ((!empty($getDataby_id->status) && $getDataby_id->status == 1) ? 'on' : '' )?>>
        <label class="custom-control-label" for="customSwitch1">Disabled</label>
      </div>
    </div>
    <div class="form-group">
      <label class="heading" for="inputTimezone">Time Zone</label>
      <select name="TargetLocale" class="form-control costum-select">
        <option value="0">- Select Timezone -</option>
      </select>
    </div>
    <?php echo form_close(); ?>
</div>