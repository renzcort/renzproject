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
        echo form_open(base_url($action.'/create'), $attrb); 
      ?>
      <div class="box-body">
        <div class="form-group">
          <label for="InputName">Name</label>
          <input type="text" class="form-control" name="name" value="<?php echo set_value('name'); ?>" placeholder="Enter Name">
        </div>
        <div class="form-group">
          <label for="InputDescription">Description</label>
          <textarea name="description" class="form-control"><?php echo set_value('description'); ?></textarea>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary" name="create">Create</button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>