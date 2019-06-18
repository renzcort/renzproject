  <div class="tabs flex-grow-1"> 
  <ul class="nav nav-tabs d-flex flex-row flex-nowrap" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="true">Settings</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="layout-tab" data-toggle="tab" href="#layout" role="tab" aria-controls="layout" aria-selected="false">Field Layout</a>
    </li>
  </ul>

  <?php
    $attributes = array('class' => 'form',
                        'id' => 'MyForm',
                  ); 
    echo form_open($action.(isset($id) ? '/'.$id : ''), $attributes); 
  ?>
  <div class="left-content-entries">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        <div class="form-group">
          <label for="inputTitle" class="heading">Title</label>
          <input type="text" name="title" placeholder="Title" class="form-control">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="right-content-entries">
  <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Slug</label>
    <div class="col-sm-10 pl-5">
      <input type="text" class="form-control-plaintext" id="staticEmail" name="slug" value="">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Parent</label>
    <div class="col-sm-10 pl-5">
      <input type="password" class="form-control-plaintext" id="inputPassword" name="parent" placeholder="Password">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="url" value="1">
        <label class="custom-control-label" for="customSwitch1">Disabled</label>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>