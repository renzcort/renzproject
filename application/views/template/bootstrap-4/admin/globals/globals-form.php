<div id="left-content" class="left-content overflow-auto">
  <div class="sidebar-content">
    <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start" id="sidebarGroups"
      data-groups-name="<?php echo ($group_name ? $group_name : ''); ?>"
      data-table="<?php echo ($table ? $table : ''); ?>"
      data-action-name="<?php echo ($action ? $action : '');?>"
      data-element="<?php echo ($fields_element ? $fields_element : ''); ?>">
      <?php
        $i = 1;
        foreach ($group as $key) {
          echo '
            <li class="nav-item">
              <a class="nav-link '.(($this->uri->segment(3) == $key->handle) ? 'active' : '').'"
              href="'.$key->handle.'" data-id="'.$key->id.'">'.ucfirst($key->name).'</a>
            </li>';

          $i = ++$i;
        }
      ?>
    </ul>
  </div>
</div>
<div id="right-content" class="right-content ml-auto">
  <?php
    $attributes = array('class' => 'form',
      'id' => 'MyForm',
    );
    echo form_open($action.(isset($id) ? '/'.$id : ''), $attributes);
  ?>
  <div class="tab-content" id="myTabContent">
    <input type="hidden" id="entries-template">
    <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
    <input type ="hidden" name="parent_id" value="<?php echo $parent_id; ?>">
    <input type ="hidden" name="parent_table" value="<?php echo $parent_table; ?>">
    <input type ="hidden" name="button" value="<?php echo $button_name; ?>">
    <input type ="hidden" name="table" value="<?php echo $table; ?>">
    <input type ="hidden" name="action" value="<?php echo $action; ?>">
    <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
      <div class="form-group">
        <label for="inputTitle" class="heading">Title</label>
        <input type="text" name="title" placeholder="Title" class="form-control" 
        value="<?php echo (!empty($getDataby_id->title) ? $getDataby_id->title : set_value('title')); ?>">
        <div class="form-error"><?php echo form_error('name'); ?></div>
      </div>
      <?php 
        if ($element) {
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
                                if ($assets_content) {
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
        } 
      ?>
    </div>
  </div>
</div>