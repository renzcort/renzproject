<div class="middle-content flex-grow-1">
  <?php
    $attributes = array(
      'class' => 'form',
      'id'    => 'MyForm'
    ); 
    echo form_open($action.(isset($id) ? '/'.$id : ''), $attributes);
  ?>
  <input type="hidden" id="button_name" name="<?php echo $button_name; ?>" value="<?php echo $button_name; ?>">
  <input type="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
  <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
  <input type="hidden" name="table" value="<?php echo $table; ?>">
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
  </form>
</div>