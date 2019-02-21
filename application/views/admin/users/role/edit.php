<div class="row">
  <div class="col-sm-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo (isset($header) ? ucfirst($header).'&nbsp;'.$subheader : ''); ?></h3>
      </div>
      <?php
        $attrb = array(
          'class' => 'form', 
        );
        $hidden = array('role_id' => $getdataby_id->id ); 
        echo form_open(base_url('admin/users/role/edit/'.$getdataby_id->id), $attrb, $hidden); 
      ?>
      <div class="box-body">
        <div class="form-group">
          <label for="InputName">Name</label>
          <input type="text" class="form-control" name="name" value="<?php echo (isset($getdataby_id) ? $getdataby_id->name : set_value('name')); ?>" placeholder="Enter Name Role">
        </div>
        <?php echo form_error('name'); ?>
        <div class="form-group">
          <label for="InputDescription">Description</label>
          <textarea name="description" class="form-control"><?php echo (isset($getdataby_id) ? $getdataby_id->description : set_value('description')); ?></textarea>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary" name="edit">Create</button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>