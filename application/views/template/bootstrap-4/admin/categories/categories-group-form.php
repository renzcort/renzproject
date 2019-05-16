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
  <div class="middle-content">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        <input type="hidden" id="button_name" name="button" value="<?php echo $button_name; ?>">
        <input type="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
        <input type="hidden" name="table" value="<?php echo $table; ?>">
        <input type="hidden" name="fields_table" value="<?php echo $fields_table; ?>">
        <input type="hidden" name="header" value="<?php echo $title; ?>">
        <input type="hidden" name="subtitle" value="<?php echo $subtitle; ?>">
        <input type="hidden" name="content" value="<?php echo $content; ?>">
        <input type="hidden" name="action" value="<?php echo $action; ?>">
        <input type="hidden" name="order" value="<?php echo (!empty($getDataby_id->order) ? $getDataby_id->order : $order ); ?>">
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
        <div class="form-group">
          <div class="form-check">
            <input type="checkbox" name="url" class="form-check-input" value="1" <?php echo (!empty($getFieldType->url) ? 'checked' : '') ?>>
            <label class="form-check-label" for="inputTranslateable">Categories in this group have their own URLs</label>
          </div>
        </div>
        <div class="form-group">
          <label class="heading" for="inputCategories">Category URL Formats</label>
          <small class="form-text text-muted">What the category URLs should look like. {slug} is required, but it can also include any category properties.</small>
          <table class="table">
            <thead>
              <th colspan="2">Top-Level Categories</th>
              <th>Nested Categories</th>
            </thead>
            <tbody>
              <tr>
                <td>id_id</td>
                <td><input type="text" name="locale-id" class="form-control" 
                  value="<?php echo (!empty($getDataby_id->locale) ? $getDataby_id->locale : set_value('locale')); ?>">
                </td>
                <td><input type="text" name="parent-id" class="form-control" placeholder="{parent.uri}/{slug}" 
                  value="<?php echo (!empty($getDataby_id->parent) ? $getDataby_id->parent : set_value('parent')); ?>">
                </td>
              </tr>
              <tr>
                <td>es_us</td>
                <td><input type="text" name="locale-es" class="form-control" 
                  value="<?php echo (!empty($getDataby_id->locale) ? $getDataby_id->locale : set_value('locale')); ?>">
                </td>
                <td><input type="text" name="parent-es" class="form-control" placeholder="{parent.uri}/{slug}" 
                  value="<?php echo (!empty($getDataby_id->parent) ? $getDataby_id->parent : set_value('parent')); ?>">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="form-group">
          <label class="heading" for="inputCategoryTemplate">Category Template</label>
          <small class="form-text text-muted">The template to use when a category’s URL is requested.</small>
          <input type="text" name="template" class="form-control" 
          value="<?php echo (!empty($getDataby_id->template) ? $getDataby_id->template : set_value('template')); ?>">
        </div>
        <div class="form-group">
          <label class="heading" for="inputMaxlevel">Max Levels</label>
          <small class="form-text text-muted">The maximum number of levels this category group can have. Leave blank if you don’t care.</small>
          <input type="text" name="maxlevel" class="form-control form-number" 
          value="<?php echo (!empty($getDataby_id->maxlevel) ? $getDataby_id->maxlevel : set_value('maxlevel')); ?>">
        </div>
      </div>
      <div class="tab-pane fade" id="layout" role="tabpanel" aria-labelledby="layout-tab">
        <div class="form-tabs" id="layout">
          <h5 class="heading">Design Your Field Layout</h5>
          <div class="field-tabs d-flex flex-row flex-wrap">
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
          <div class="field-column d-flex flex-row flex-wrap">
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
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php echo form_close(); ?>
</div>