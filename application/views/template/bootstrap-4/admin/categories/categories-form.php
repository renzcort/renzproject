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
  <input type="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
  <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>">
  <input type="hidden" name="parent_table" value="<?php echo $parent_table; ?>">
  <input type="hidden" name="button" value="<?php echo $button_name; ?>">
  <input type="hidden" name="table" value="<?php echo $table; ?>">
  <input type="hidden" name="action" value="<?php echo $action; ?>">

  <div class="left-content-entries" id="entries-template">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        <div class="form-group">
          <label for="inputTitle" class="heading">Title</label>
          <input type="text" name="title" placeholder="Title" class="form-control" 
          value="<?php echo (!empty($getDataby_id->title) ? $getDataby_id->title : set_value('title')); ?>">
          <div class="form-error"><?php echo form_error('name'); ?></div>
        </div>
        <?php if ($fields_element) {
          foreach ($fields as $key) {
            if (in_array($key->id, $fields_id)) {
              $settings   = json_decode($key->settings);
              $fieldsName = "fields_{$key->handle}";
              echo '<div class="form-group">
                <label class="heading" for="input'.$key->handle.'">'.ucfirst($key->name).'</label>';
                if ($key->type_name == 'plainText') {
                  if ($settings->plainLineBreak == 1) {
                    echo '<textarea class="form-control"
                          name="fields_'.$key->handle.'" 
                          id="textarea"
                          rows="'.$settings->plainInitialRows.'"
                          placeholder="'.$settings->plainPlaceholder.'">'.(!empty($getDataby_id->$fieldsName) ? trim(strip_tags($getDataby_id->$fieldsName)) : '').'</textarea>';        
                  } else {
                    echo '<input type="text" class="form-control" 
                            name="fields_'.$key->handle.'" 
                            placeholder="'.(!empty($setttings->plainPlaceholder) ? $setttings->plainPlaceholder : '').'"
                            maxlength="'.(!empty($settings->plainCharlimit) ? $settings->plainCharlimit : '').'"
                            value="'.(!empty($getDataby_id->$fieldsName) ? $getDataby_id->$fieldsName : set_value($fieldsName)).'">';                    
                  }
                } elseif ($key->type_name == 'assets') {
                  foreach ($assets as $key2) {
                    if ($key2->id == $settings->assetsSourcesList) {
                      $data['name'] = $key2->name;
                    }
                  }

                  echo '<div id="fields-assets-entries">
                          <ul class="list-unstyled selected">';
                            if (!empty($getDataby_id->$fieldsName)) {
                              $assetsList = explode(', ', $getDataby_id->$fieldsName);
                              foreach ($assets_content as $ast) {
                                $filename   = explode('.', $ast->file);
                                $name       = current($filename);
                                $thumb      = current($filename).'_thumb.'.end($filename);
                                $file_thumb = base_url("{$ast->path}/{$thumb}");
                                $getSize    = get_headers($file_thumb, 1);
                                if (in_array($ast->id, $assetsList)) {
                                  echo '
                                      <li><input type="hidden" name="'.$fieldsName.'[]" value="'.$ast->id.'">
                                        <img src="'.$file_thumb.'" class="img-thumbnail assets-list" data-id="'.$ast->id.'" heigth="20" width="30"/>
                                        <label for="input'.$name.'">'.$name.'</label>
                                        <a><i class="fa fa-times" aria-hidden="true"></i></a
                                      </li>';
                                }
                              }
                            }
                  echo '</ul>';
                  echo '<div>
                          <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#assetsModal"
                          data-assets-id = "'.$settings->assetsSourcesList.'" 
                          data-assets-fields="fields_'.$key->handle.'">
                        + New Assets</button></div>';
                  echo '</div>';
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

                  if (!empty($getDataby_id->$fieldsName)) {
                    $checkList = explode(', ', $getDataby_id->$fieldsName);
                  }

                  foreach ($dataResult as $key3) {
                    echo '<div class="form-check">
                            <input class="form-check-input" 
                              type="checkbox" 
                              name="fields_'.$key->handle.'[]" 
                              value="'.$key3['value'].'"
                              '.((!empty($getDataby_id->$fieldsName) && in_array($key3['value'], $checkList)) ? 'checked' : '').'>
                            <label class="form-check-label" 
                              for="defaultCheck1">'.$key3['label'].'
                            </label>
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
                            <input class="form-check-input" type="radio" name="fields_'.$key->handle.'[]" value="'.$key3['value'].'">
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
    <div class="col-sm-10">
      <input type="text" class="form-control-plaintext px-2" id="staticEmail" name="slug" placeholder="Enter Slug"
      value="<?php echo (!empty($getDataby_id->slug) ? $getDataby_id->slug : set_value('slug')); ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Parent</label>
    <div class="col-sm-10">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="activated" value="1">
        <label class="custom-control-label" for="customSwitch1">Disabled</label>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>