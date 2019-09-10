<div class="row">
  <div class="col-sm-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo (isset($title) ? ucfirst($title).'&nbsp;'.$subheader : ucfirst($header).'&nbsp;'.$subheader); ?></h3>
      </div>
      <?php
        $attrb = array(
          'class' => 'form', 
        ); 
        
        $hidden = array('id' => (isset($getdataby_id) ? $getdataby_id->id : '' ));
        echo form_open_multipart(base_url($action), $attrb, $hidden); 
      ?>
      <div class="box-body">
        <div class="form-group">
          <label for="InputSitename">site Name</label>
          <input type="text" class="form-control" name="sitename" value="<?php echo (isset($getdataby_id) ? $getdataby_id->sitename : set_value('sitename')); ?>" placeholder="Enter Site Name">
        </div>
        <?php echo form_error('sitename'); ?>
        <div class="form-group">
          <label for="inputSiteurl">Site URL</label>
          <input type="text" name="siteurl" class="form-control" value="<?php echo (isset($getdataby_id) ? $getdataby_id->siteurl : set_value('siteurl'));?>" placeholder="Enter Site URL">
        </div>
        <?php echo form_error('siteurl'); ?>
        <div class="form-group">
          <label for="InputTimezone">Timezone</label>
          <select name="timezone" class="form-control">
            <option value="0">- Select Timezone -</option>
          </select>
        </div>
        <div class="form-group">
          <label>Set Icon</label>
          <div class="photo" id="users">
            <img src="<?php echo base_url($upload_path.'/'.$getdataby_id->siteicon); ?>" alt="placeholder+image" width="100" height="150">
            <input type="hidden" name="old-siteicon" value="<?php echo $getdataby_id->siteicon; ?>">       
          </div>
          <input type="file" name="siteicon" class="form-control">
        </div>
        <div class="form-group">
          <label>Set Logo</label>
          <div class="photo" id="users">
            <img src="<?php echo base_url($upload_path.'/'.$getdataby_id->sitelogo); ?>" alt="placeholder+image" width="100" height="150">
            <input type="hidden" name="old-sitelogo" value="<?php echo $getdataby_id->sitelogo; ?>">       
          </div>
          <input type="file" name="sitelogo" class="form-control">
        </div>
        <div class="box-footer">
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm" name="update">Update</button>
          </div>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>