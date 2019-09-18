<div class="content-body flex-grow-1" id="users">
  <div class="users-group-form" id="middle-content">
    <?php
      $attributes = array(
        'class' => 'form',
        'id'    => 'MyForm',
      );
      echo form_open($action.(isset($id) ? '/edit/'.$id : '/create'), $attributes);
    ?>
    <input type ="hidden" name="button" value="<?php echo $button_name; ?>">
    <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
    <input type ="hidden" name="table" value="<?php echo $table; ?>">
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
    <hr>
    <h5 class="heading">Permissions</h5>
    <?php $this->load->view('template/bootstrap-4/admin/partial/permission-users-form'); ?>
    <?php echo form_close();?>
  </div>
</div>