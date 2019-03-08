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
          <label for="InputType">Type Data</label>
          <select name="type" class="form-control">
            <option value="0">- select Type-</option>
            <?php $i = 0; foreach ($type as $key => $value) { ?>
              <option value="<?php echo ++$i; ?>" <?php echo (($getdataby_id->type == $i) ? "selected" : '' )?>><?php echo $value; ?></option>
            <?php } ?>
          </select>
        </div>
        <?php echo form_error('type'); ?>
        <div class="form-group">
          <label for="inputPath">File System Path</label>
          <input type="text" name="path" class="form-control" value="<?php echo ($getdataby_id ? $getdataby_id->path : set_value('path')); ?>" placeholder="/path/to/folder">
        </div>
        <div class="form-group">
          <label for="inputURL">URL</label>
          <input type="text" name="url" class="form-control" value="<?php echo ($getdataby_id ? $getdataby_id->url : set_value('url')); ?>" placeholder="http://renzproject.localhost">
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