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
  <input type="hidden" name="button" value="<?php echo $button_name; ?>">
  <div class="left-content-entries">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        <div class="form-group">
          <label for="inputTitle" class="heading">Title</label>
          <input type="text" name="title" placeholder="Title" class="form-control">
        </div>
        <?php if ($fields_element) {
          foreach ($fields as $key) {
            if (in_array($key->id, $fields_id)) {
              $settings = json_decode($key->settings);
              echo '<div class="form-group">
                <label class="heading" for="input{$key->handle}">'.ucfirst($key->name).'</label>';
                if ($key->type_name == 'plainText') {
                  if ($settings->plainLineBreak == 1) {
                    echo '<textarea class="form-control" 
                            name="fields_{$key->handle}"
                            id="exampleFormControlTextarea1"
                            rows="{$setting->plainInitialRows}">
                          </textarea>';

                  } else {
                    echo '<input type="text"  class="form-control form-control-sm" 
                            name="fields_{key->handle}" 
                            placeholder="{$setttings->plainPlaceholder}"
                            maxlength="{$settings->plainCharlimit}">';                    
                  }
                } elseif ($key->type_name == 'assets') {
                  foreach ($assets as $key) {
                    if ($key->id == $settings->assetsSourcesList) {
                      $data['name'] = $key->name;
                    }
                  }
                  echo '<div id="selected"></div>';
                  echo '<div>
                          <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#assetsModal"
                          data-assets-id = "'.$settings->assetsSourcesList.'" 
                          data-assets-name="'.$data['name'].'">
                        + New Assets</button></div>';
                } elseif ($key->type_name == 'richText') {
                } elseif ($key->type_name == 'categories') {
                } elseif ($key->type_name == 'checkboxes') {
                  $val = $settings->checkboxesValue; 
                  $i = 0;
                  foreach ($settings->checkboxesLabel as $key2 => $value) {
                    $dataResult[] = array(
                                'label' => $value,
                                'value' => $val[$i]
                              );
                    $i++;
                  }
                  foreach ($dataResult as $key3) {
                    echo '<div class="form-check">
                            <input class="form-check-input" type="checkbox" value="'.$key3['value'].'">
                            <label class="form-check-label" for="defaultCheck1">'.$key3['label'].'</label>
                          </div>';
                  }
                } elseif ($key->type_name == 'dateTime') {
                } elseif ($key->type_name == 'dropdown') {
                  $val = $settings->dropdownValue; 
                  $i = 0;
                  foreach ($settings->dropdownLabel as $key2 => $value) {
                    $dataResult[] = array(
                                'label' => $value,
                                'value' => $val[$i]
                              );
                    $i++;
                  }
                  echo '<select class="form-control costum-select" name="fields_{$key->handle}">';
                  foreach ($dataResult as $key3) {
                    echo '<option value="'.$key3['value'].'">'.$key3['label'].'</option>';
                  }
                  echo '</select>';
                } elseif ($key->type_name == 'radio') {
                  $val = $settings->radioValue; 
                  $i = 0;
                  foreach ($settings->radioLabel as $key2 => $value) {
                    $dataResult[] = array(
                                'label' => $value,
                                'value' => $val[$i]
                              );
                    $i++;
                  }
                  foreach ($dataResult as $key3) {
                    echo '<div class="form-check">
                            <input class="form-check-input" type="radio" value="'.$key3['value'].'">
                            <label class="form-check-label" for="defaultCheck1">'.$key3['label'].'</label>
                          </div>';
                  }
                }
              echo '</div>';
            }
          }
        } ?>
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