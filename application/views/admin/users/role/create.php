<div class="row">
  <div class="col-sm-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo (isset($header) ? ucfirst($header).' Create' : ''); ?></h3>
      </div>
      <?php
        $attrb = array(
          'class' => 'form', 
        ); 
        echo form_open('admin/users/role/create', $attrb); 
      ?>
      <div class="box-body">
        <div class="form-group">
          <label for="InputName">Name</label>
          <input type="text" class="form-control" placeholder="Enter Name Role">
        </div>
        <div class="form-group">
          <label for="InputDescription">Description</label>
          <textarea name="description"></textarea>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary" name="create">Create</button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>