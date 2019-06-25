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
        $hidden = array('id' => $getDataby_id->id ); 
        echo form_open(base_url($action.'/type_update/'.$getDataby_id->id), $attrb, $hidden); 
      ?>
      <input type="hidden" name="button" value="update">
      <div class="box-body">
        <div class="form-group">
          <label for="InputName">Name</label>
          <input type="text" class="form-control" name="name" value="<?php echo (isset($getDataby_id) ? $getDataby_id->name : set_value('name')); ?>" placeholder="Enter Name Role">
        </div>
        <?php echo form_error('name'); ?>
        <div class="form-group">
          <label for="InputType">Type Data</label>
          <select name="type" class="form-control">
            <option value="0">- select Type-</option>
            <?php foreach ($type as $key => $value) { ?>
              <option value="<?php echo $value; ?>" <?php echo (($getDataby_id->type == $value) ? 'selected' : ''); ?>><?php echo $value; ?></option>
            <?php } ?>
          </select>
        </div>
        <?php echo form_error('type'); ?>
        <div class="form-group">
          <label for="InputDescription">Description</label>
          <textarea name="description" class="form-control"><?php echo (isset($getDataby_id) ? $getDataby_id->description : set_value('description')); ?></textarea>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary" name="update">Update</button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>