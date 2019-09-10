<div class="content-body tabs flex-grow-1" id="globals">
  <div class="globals-group-form" id="middle-content">
    <?php
      $attributes = array(
        'class' => 'form',
        'id' => 'MyForm',
      );
      echo form_open($action.(isset($id) ? '/'.$id : ''), $attributes);
    ?>
    <div class="heading" id="tabs-heading">
      <ul class="nav d-flex flex-row flex-nowrap" role="tablist" id="tabs-heading">
        <li class="nav-item">
          <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#settings" role="tab" 
          aria-controls="settings" aria-selected="true">Settings</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="layout-tab" data-toggle="tab" href="#layout" role="tab" 
          aria-controls="layout" aria-selected="false">Field Layout</a>
        </li>
      </ul>
    </div>
    <div class="tab-content" id="tabs-content-main">
      <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        <input type ="hidden" id="button_name" name="button" value="<?php echo $button_name; ?>">
        <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
        <input type ="hidden" name="table" value="<?php echo $table; ?>">
        <input type ="hidden" name="fields_element" value="<?php echo $fields_element; ?>">
        <input type ="hidden" name="header" value="<?php echo $title; ?>">
        <input type ="hidden" name="subtitle" value="<?php echo $subtitle; ?>">
        <input type ="hidden" name="content" value="<?php echo $content; ?>">
        <input type ="hidden" name="action" value="<?php echo $action; ?>">
        <input type ="hidden" name="order" value="<?php echo (!empty($getDataby_id->order) ? $getDataby_id->order : $order ); ?>">
        <div class="form-group">
          <label class="heading required" for="inputName">Name</label>
          <small class="form-text text-muted">What this site will be called in the CP.</small>
          <input type="text" name="name" class="form-control"  placeholder="Name"
          value="<?php echo (!empty($getDataby_id->name) ? $getDataby_id->name : set_value('name')); ?>">
          <div class="form-error"><?php echo form_error('name'); ?></div>
        </div>
        <div class="form-group">
          <label class="heading required" for="inputHandle">Handle</label>
          <small class="form-text text-muted">How you’ll refer to this site in the templates.</small>
          <input type="text" name="handle" class="form-control"  placeholder="Handle"
          value="<?php echo (!empty($getDataby_id->handle) ? $getDataby_id->handle : set_value('handle')); ?>">
          <div class="form-error"><?php echo form_error('handle'); ?></div>
        </div>
      </div>
      <div class="tab-pane fade" id="layout" role="tabpanel" aria-labelledby="layout-tab">
        <?php $this->load->view('template/bootstrap-4/admin/partial/tabs-form'); ?>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>