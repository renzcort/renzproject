<div class="content-body flex-grow-1" id="section">
  <div class="section-entries-form" id="middle-content">
    <?php
      $attributes = array(
      'class' => 'form',
      'id'    => 'MyForm'
      );
      echo form_open($action.(isset($id) ? '/'.$id : ''), $attributes);
    ?>
    <input type="hidden" id="button_name" name="button" value="<?php echo $button_name; ?>">
    <input type="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
    <input type="hidden" name="section_id" value="<?php echo (isset($section_id) ? $section_id : ''); ?>">
    <input type="hidden" name="table" value="<?php echo $table; ?>">
    <input type="hidden" name="header" value="<?php echo $title; ?>">
    <input type="hidden" name="subtitle" value="<?php echo $subtitle; ?>">
    <input type="hidden" name="content" value="<?php echo $content; ?>">
    <input type="hidden" name="action" value="<?php echo $action; ?>">
    <input type="hidden" name="fields_element" value="<?php echo $fields_element; ?>">
    <input type="hidden" name="order" value="<?php echo (!empty($getDataby_id->order) ? $getDataby_id->order : $order ); ?>">
    <div class="form-group">
      <label class="heading required" for="inputName">Name</label>
      <small class="form-text text-muted">What this entry type will be called in the CP.</small>
      <input type="text" name="name" class="form-control" placeholder="Name"
      value="<?php echo (!empty($getDataby_id->name) ? $getDataby_id->name : set_value('name')); ?>">
      <div class="form-error"><?php echo form_error('name'); ?></div>
    </div>
    <div class="form-group">
      <label class="heading required" for="inputHandle">Handle</label>
      <small class="form-text text-muted">How you’ll refer to this entry type in the templates.</small>
      <input type="text" name="handle" class="form-control" placeholder="Handle"
      value="<?php echo (!empty($getDataby_id->handle) ? $getDataby_id->handle : set_value('handle')); ?>">
      <div class="form-error"><?php echo form_error('handle'); ?></div>
    </div>
    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" name="checkTitle" class="form-check-input">
        <label class="form-check-label" for="inputTranslateable">Show the Title field</label>
      </div>
    </div>
    <div class="form-group">
      <label class="heading required" for="inputTitle">Title Field Label</label>
      <small class="form-text text-muted">What do you want the Title field to be called?</small>
      <input type="text" name="title" class="form-control" placeholder="Title"
      value="<?php echo (!empty($getDataby_id->title) ? $getDataby_id->title : set_value('title')); ?>">
      <div class="form-error"><?php echo form_error('title'); ?></div>
    </div>
    <hr class="break-line"></hr>
    <?php $this->load->view('template/bootstrap-4/admin/partial/tabs-form'); ?>
    <?php echo form_close(); ?>
  </div>
</div>