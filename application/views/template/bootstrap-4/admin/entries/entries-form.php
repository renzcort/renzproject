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
    echo form_open($action.(isset($id) ? '/edit/'.$id : '/create'), $attributes); 
  ?>
  <input type ="hidden" name="button" value="<?php echo $button_name; ?>">
  <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
  <input type ="hidden" name="table" value="<?php echo $table; ?>">
  <input type ="hidden" name="action" value="<?php echo $action; ?>">
  <input type ="hidden" name="section_id" value="<?php echo $section_id; ?>">
  <input type ="hidden" name="parent_table" value="<?php echo $parent_table; ?>">

  <div class="left-content-entries" id="entries-template">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        <div class="form-group">
          <label for="inputTitle" class="heading">Title</label>
          <input type="text" name="title" placeholder="Title" class="form-control" 
          value="<?php echo (!empty($getDataby_id->title) ? $getDataby_id->title : set_value('title')); ?>">
          <div class="form-error"><?php echo form_error('name'); ?></div>
        </div>
        <div id="entries-fields">
        <?php if ($element) {
          foreach ($fields_id as $id) {
            foreach ($fields as $key) {
              if ($id == $key->id) {
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
                    foreach ($assets as $ast) {
                      if ($ast->id == $settings->assetsSourcesList) {
                        $data['name'] = $ast->name;
                      }
                    }

                    echo '<div id="fields-assets-entries">
                            <ul class="list-unstyled selected">';
                              if (!empty($getDataby_id->$fieldsName)) {
                                $assetsList = explode(', ', $getDataby_id->$fieldsName);
                                foreach ($assets_content as $astcont) {
                                  $filename   = explode('.', $astcont->file);
                                  $name       = current($filename);
                                  $thumb      = current($filename).'_thumb.'.end($filename);
                                  $file_thumb = base_url("{$astcont->path}/{$thumb}");
                                  $getSize    = get_headers($file_thumb, 1);
                                  if (in_array($astcont->id, $assetsList)) {
                                    echo '
                                        <li><input type="hidden" name="'.$fieldsName.'[]" value="'.$astcont->id.'">
                                          <img src="'.$file_thumb.'" class="img-thumbnail assets-list" 
                                          data-id="'.$astcont->id.'" heigth="20" width="30"/>
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
                            data-assets-fields="fields_'.$key->handle.'"
                            data-assets-source="'.$settings->assetsSourcesInput.'">
                          + New Assets</button></div>';
                    echo '</div>';
                  } elseif ($key->type_name == 'richText') {
                  } elseif ($key->type_name == 'categories') {
                  } elseif ($key->type_name == 'checkboxes') {
                    $val = $settings->checkboxesValue; 
                    $i = 0;
                    foreach ($settings->checkboxesLabel as $chk => $value) {
                      $checkResult[] = array(
                        'label' => $value,
                        'value' => $val[$i]
                      );
                      $i++;
                    }

                    if (!empty($getDataby_id->$fieldsName)) {
                      $checkList = explode(', ', $getDataby_id->$fieldsName);
                    }

                    foreach ($checkResult as $chkResult) {
                      echo '<div class="form-check">
                              <input class="form-check-input" 
                                type="checkbox" 
                                name="fields_'.$key->handle.'[]" 
                                value="'.$chkResult['value'].'"
                                '.((!empty($getDataby_id->$fieldsName) && in_array($chkResult['value'], $checkList)) ? 'checked' : '').'>
                              <label class="form-check-label" 
                                for="defaultCheck1">'.$chkResult['label'].'
                              </label>
                            </div>';
                    }
                  } elseif ($key->type_name == 'dateTime') {
                  } elseif ($key->type_name == 'dropdown') {
                    $val = $settings->dropdownValue; 
                    $i = 0;
                    foreach ($settings->dropdownLabel as $drp => $value) {
                      $dropResult[] = array(
                        'label' => $value,
                        'value' => $val[$i]
                      );
                      $i++;
                    }
                    if (!empty($getDataby_id->$fieldsName)) {
                      $checkList = explode(', ', $getDataby_id->$fieldsName);
                    }
                    echo '<select class="form-control costum-select" name="fields_'.$key->handle.'">';
                    foreach ($dropResult as $drpResult) {
                      echo '<option value="'.$drpResult['value'].'"
                      '.((!empty($getDataby_id->$fieldsName) && in_array($drpResult['value'], $checkList)) ? 'selected' : '').'>
                      '.$drpResult['label'].'</option>';
                    }
                    echo '</select>';
                  } elseif ($key->type_name == 'radio') {
                    $val = $settings->radioValue; 
                    $i = 0;
                    foreach ($settings->radioLabel as $rad => $value) {
                      $radioResult[] = array(
                        'label' => $value,
                        'value' => $val[$i]
                      );
                      $i++;
                    }
                    if (!empty($getDataby_id->$fieldsName)) {
                      $checkList = explode(', ', $getDataby_id->$fieldsName);
                    }
                    foreach ($radioResult as $radResult) {
                      echo '<div class="form-check">
                              <input class="form-check-input" type="radio" name="fields_'.$key->handle.'[]"  value="'.$radResult['value'].'"
                              '.((!empty($getDataby_id->$fieldsName) && in_array($radResult['value'], $checkList)) ? 'checked' : '').'>
                              <label class="form-check-label" for="defaultCheck1">'.$radResult['label'].'</label>
                            </div>';
                    }
                  }
                echo '</div>';
              }
            }
          }
        } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="right-content-entries">
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">Entry Type</label>
    <div class="col-sm-9">
      <select class="form-control-plaintext costum-select" name="entriestype" id="entries">
        <?php 
          foreach ($section_entries as $key) {
            echo '<option value="'.$key->id.'" data-id="'.$key->id.'" 
            '.((!empty($getDataby_id->entries_id) && $getDataby_id->entries_id == $key->id) ? 'selected' : '').'>'.$key->name;
          }
        ?>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">Slug</label>
    <div class="col-sm-9">
      <input type="text" class="form-control-plaintext px-2" name="slug" placeholder="Enter Slug"
      value="<?php echo (!empty($getDataby_id->slug) ? $getDataby_id->slug : set_value('slug')); ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">Post Date</label>
    <div class="col-sm-9">
      <input type="date" class="form-control-plaintext px-2" name="postdate"
      value="<?php echo (!empty($getDataby_id->postdate) ? $getDataby_id->postdate : set_value('postdate')); ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">Expiry Date</label>
    <div class="col-sm-9">
      <input type="date" class="form-control-plaintext px-2" name="slug" placeholder="Enter Slug"
      value="<?php echo (!empty($getDataby_id->slug) ? $getDataby_id->slug : set_value('slug')); ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-3 col-form-label">Parent</label>
    <div class="col-sm-9">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-3">
      <div class="custom-control custom-switch">
        <input type="checkbox" name="activated" class="custom-control-input customSwitch" id="customSwitch1"
        <?php echo ((!empty($getDataby_id->activated) && $getDataby_id->activated == 1) ? 'checked' : '') ?>>
        <label class="custom-control-label" for="customSwitch1">
        <?php echo ((!empty($getDataby_id->activated) && $getDataby_id->activated == 1) ? 'Enabled' : 'Disabled') ?>
        </label>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>