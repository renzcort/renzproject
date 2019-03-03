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
        echo form_open_multipart(base_url($action.'/edit/'.$getdataby_id->id), $attrb, $hidden); 
      ?>
      <div class="box-body">
        <div class="form-group">
          <label for="InputName">Name</label>
          <input type="text" class="form-control" name="name" value="<?php echo ($getdataby_id ? $getdataby_id->name : set_value('name')); ?>" >
        </div>
        <?php echo form_error('name'); ?>
        <div class="form-group">
          <label for="InputHandle">Handle</label>
          <input type="text" name="handle" class="form-control" value="<?php echo ($getdataby_id ? $getdataby_id->handle : set_value('handle')); ?>" >
        </div>
        <?php echo form_error('handle') ?>
        <div class="form-group">
          <label for="InputFieldType">Field Type</label>
          <select name="type" class="form-control">
            <option value="0">- Select Type -</option>
            <?php foreach ($type as $key) { ?>
              <option value="<?php echo $key->id ?>" <?php echo (($getdataby_id->type_id == $key->id) ? "selected" : '' ); ?>><?php echo $key->name; ?></option>
            <<?php } ?>
          </select>
        </div> 
        <div class="box-footer">
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm" name="update">Create</button>
          </div>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>