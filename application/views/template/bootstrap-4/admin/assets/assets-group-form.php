<div class="tabs flex-grow-1 ">
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
  <div class="middle-content">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        
          <input type="hidden" name="<?php echo $button_name; ?>">
          <div class="form-group">
            <label class="heading required" for="inputName">Name</label>
            <small class="form-text text-muted">What this site will be called in the CP.</small>
            <input type="text" name="name" class="form-control"  placeholder="Name" 
            value="<?php echo (!empty($getDataby_id->name) ? $getDataby_id->name : set_value('name')); ?>">
            <div class="form-error"><?php echo form_error('name'); ?></div>
          </div>
          <div class="form-group">
            <label class="heading required" for="inputHandle">Handle</label>
            <label class="form-text text-muted">How you’ll refer to this site in the templates.</label>
            <input type="text" name="handle" class="form-control"  placeholder="Handle" 
            value="<?php echo (!empty($getDataby_id->handle) ? $getDataby_id->handle : set_value('handle')); ?>">
            <div class="form-error"><?php echo form_error('handle'); ?></div>
          </div>
          <div class="form-group">
            <label class="heading" for="inputAssets">Assets in this volume have public URLs</label>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitch1" name="url" value="1" <?php echo (!empty($getFieldType->url) ? 'checked' : '') ?>>
              <label class="custom-control-label" for="customSwitch1">Disabled</label>
            </div>
          </div>
          <div id="base-url" class="form-group d-none">
            <label class="heading" for="inputBaseURL">Base URL</label>
            <label class="form-text text-muted">The base URL to the assets in this volume. An absolute URL (“http://example.com/path/to/folder”) or protocol-relative URL (“//example.com/path/to/folder”) is recommended. It can begin with an alias, such as @web.</label>
            <input type="text" name="url" class="form-control"  placeholder="url" 
            value="<?php echo (!empty($getDataby_id->url) ? $getDataby_id->url : set_value('url')); ?>">
          </div>
          <hr class="break-line">
          <div class="form-group">
            <label class="heading" for="inputVolumeType">Volume Type</label>
            <small class="form-text text-muted">What type of section is this?</small>
            <select name="volumeType" class="form-control costum-select">
              <option value="0">- Select Type -</option>
              <?php foreach ($assets_type as $key => $value): ?>
                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label class="heading" for="inputFileSystemPath">File System Path</label>
            <small class="form-text text-muted">The path to the volume’s directory on the file system.</small>
             <input type="text" name="path" class="form-control"  placeholder="/path/folder" 
            value="<?php echo (!empty($getDataby_id->path) ? $getDataby_id->path : set_value('path')); ?>">
          </div>
      </div>
      <div class="tab-pane fade" id="layout" role="tabpanel" aria-labelledby="layout-tab">
        <div class="form-tabs" id="layout">
          <h5 class="heading">Design Your Field Layout</h5>
          <div class="field-tabs my-5 d-flex flex-row flex-wrap">
            <div class="field-group">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <ul id="sortable1" class="text-center list-group connectedSortable">
                      <?php foreach ($fields as $key): ?>
                        <?php if (in_array($key->id, $elementFields)): ?>
                        <li class="list-group-item fields-list" data-fieldsId='<?php echo $key->id; ?>'><?php echo $key->name; ?></li>
                        <?php endif ?>
                      <?php endforeach ?>  
                  </ul>
                </div>
              </div>
            </div>        
          </div>
          <div class="btn-add new-tabs">
            <button type="button" class="btn btn-info">+ New Tabs</button>
          </div>
          <hr class="break-line"></hr>
          <div class="my-5 d-flex flex-row flex-wrap">
            <?php if ($fields_group): ?>
              <?php $i = 0; ?>
              <?php foreach ($fields_group as $key): ?>
              <div class="field-group">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                      <?php echo ucfirst($key->name); ?>
                    </a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <ul id="sortable2" class="text-center list-group connectedSortable">
                    <?php if ($fields): ?>
                      <?php foreach ($fields as $value): ?>
                        <?php if ($value->group_id == $key->id): ?>
                          <?php if (!in_array($value->id, $elementFields)): ?>
                            <li class="list-group-item fields-list" data-fieldsId='<?php echo $value->id; ?>'><?php echo $value->name; ?></li>
                          <?php endif ?>
                        <?php endif ?>
                      <?php endforeach ?>
                    <?php endif ?>
                    </ul>
                  </div>
                </div>
              </div>
              <?php endforeach ?>
            <?php endif ?>
            <div class="field-group">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <ul id="sortable1" class="text-center list-group connectedSortable">
                    <li class="list-group-item active">Lion</li>
                    <li class="list-group-item">Dog</li>
                    <li class="list-group-item">Cat</li>
                    <li class="list-group-item">Tiger</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php echo form_close(); ?>
</div>