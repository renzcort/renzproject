<?php
  $attributes = array(
    'class' => 'form',
    'id' => 'MyForm',
  );
  echo form_open($action.(isset($id) ? '/edit/'.$id : '/create'), $attributes); 
?>
<div class="middle-content" id="users-settings">
  <div class="tab-content" id="myTabContent">
    <input type="hidden" id="button_name" name="button" value="<?php echo $button_name; ?>">
    <input type="hidden" name="id" value="<?php echo (!empty($getDataby_id->handle) ? $getDataby_id->handle : ''); ?>">
    <input type="hidden" name="table" value="<?php echo $table; ?>">
    <input type="hidden" name="header" value="<?php echo $title; ?>">
    <input type="hidden" name="subtitle" value="<?php echo $subtitle; ?>">
    <input type="hidden" name="content" value="<?php echo $content; ?>">
    <input type="hidden" name="right_content" value="<?php echo $right_content; ?>">
    <input type="hidden" name="handle" value="<?php echo $handle; ?>">
    <input type="hidden" name="fields_element" value="<?php echo $fields_element; ?>">
    <input type="hidden" name="action" value="<?php echo $action; ?>">
    <div class="tab-pane fade active show" id="layout" role="tabpanel" aria-labelledby="layout-tab">
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
                  <?php
                  if ($element) {
                    foreach ($element as $elm => $value) {
                      foreach ($fields as $key) {
                        if ($value == $key->id) {
                          echo '<li class="list-group-item fields-list" data-fieldsId="'.$key->id.'">'.$key->name.'</li>';
                        }
                      }
                    }
                  }
                  ?>
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
          <?php 
            if ($fields_group) { 
              $i = 0; 
              foreach ($fields_group as $key) { 
          echo '
          <div class="field-group">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                  '.ucfirst($key->name).'
                </a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <ul id="sortable2" class="text-center list-group connectedSortable">';
                  if ($fields) {
                    foreach ($fields as $value) {
                      if ($value->group_id == $key->id) {
                        if (!in_array($value->id, $elementFields)) {
                          echo '<li class="list-group-item fields-list" data-fieldsId="'.$value->id.'">'.$value->name.'</li>';
                        } 
                      }
                    }
                  } 
          echo '
                </ul>
              </div>
            </div>
          </div>';
          }
         }         
         ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>