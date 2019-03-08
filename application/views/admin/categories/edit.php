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
        $hidden = array('id' => $getdataby_id->id);
        echo form_open(base_url("{$action}/update/{$getdataby_id->id}"), $attrb, $hidden); 
      ?>
      <div class="box-body">
        <div class="form-group">
          <label for="InputName">Name</label>
          <input type="text" class="form-control" name="name" value="<?php echo ($getdataby_id ? $getdataby_id->name : set_value('name')); ?>" placeholder="Enter Name">
        </div>
        <?php echo form_error('name'); ?>
        <div class="form-group">
          <label for="inputURL">Category Template</label>
          <input type="text" name="url" class="form-control" value="<?php echo ($getdataby_id ? $getdataby_id->url : set_value('url')); ?>" placeholder="http://renzproject.localhost">
        </div>
        <div class="form-group">
          <label for="inputURL">Max Levels</label>
          <input type="text" name="maxlevel" class="form-control" value="<?php echo ($getdataby_id ? $getdataby_id->maxlevel : set_value('maxlevel')); ?>" placeholder="http://renzproject.localhost">
        </div>
        <div class="form-group">
          <label for="InputDescription">Description</label>
          <textarea name="description" class="form-control"><?php echo ($getdataby_id ? $getdataby_id->description : set_value('description')); ?></textarea>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary" name="update">Create</button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>