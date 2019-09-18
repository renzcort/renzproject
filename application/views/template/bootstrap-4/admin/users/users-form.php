<div class="content-body tabs flex-grow-1" id="users">
  <div class="users-form" id="middle-content">
  <?php
    $attributes = array(
      'class' => 'form',
      'id'    => 'MyForm',
    ); 
    echo form_open($action.(isset($id) ? '/edit/'.$id : '/create'), $attributes); 
  ?>
  <div class="heading" id="tabs-heading">
    <ul class="nav nav-tabs d-flex flex-row flex-nowrap" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#account" role="tab" aria-controls="settings" aria-selected="true">Account</a>
      </li>
      <?php
        if ($tabs_elements) {
          echo '
          <li class="nav-item">
            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
          </li>'; 
        } 
      ?>
      <li class="nav-item">
        <a class="nav-link" id="layout-tab" data-toggle="tab" href="#permissions" role="tab" aria-controls="layout" aria-selected="false">Permissions</a>
      </li>
    </ul>
  </div>

  <div class="tab-content">
    <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="settings-tab">
      <input type ="hidden" id="button_name" name="button" value="<?php echo $button_name; ?>">
      <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
      <div class="form-group">
        <label class="heading required" for="inputUsername">Username</label>
        <input type="text" name="username" class="form-control"  placeholder="Username" 
        value="<?php echo (!empty($getDataby_id->username) ? $getDataby_id->username : set_value('username')); ?>">
        <div class="form-error"><?php echo form_error('username'); ?></div>
      </div>
      <div class="d-flex flex-row flex-nowrap justify-content-between">
        <div class="form-group w-50 pr-3">
          <label class="heading required" for="inputFirstname">Firstname</label>
          <input type="text" name="firstname" class="form-control"  placeholder="Firstname" 
          value="<?php echo (!empty($getDataby_id->firstname) ? $getDataby_id->firstname : set_value('firstname')); ?>">
          <div class="form-error"><?php echo form_error('firstname'); ?></div>
        </div>
        <div class="form-group w-50 pl-3">
          <label class="heading required" for="inputLastname">Lastname</label>
          <input type="text" name="lastname" class="form-control"  placeholder="Lastname" 
          value="<?php echo (!empty($getDataby_id->lastname) ? $getDataby_id->lastname : set_value('lastname')); ?>">
          <div class="form-error"><?php echo form_error('lastname'); ?></div>
        </div>
      </div>
      <div class="form-group">
        <label class="heading required" for="inputEmail">Email</label>
        <input type="email" name="email" class="form-control"  placeholder="Email" 
        value="<?php echo (!empty($getDataby_id->email) ? $getDataby_id->email : set_value('username')); ?>">
        <div class="form-error"><?php echo form_error('email'); ?></div>
      </div>
    </div>
    <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="layout-tab">
      <div class="form-group">
        <label class="heading required" for="inputUsersgroup">Users group</label>
        <?php 
          if ($usersgroup) {
            echo '
              <select class="form-control costum-select" name="group">';
              foreach ($usersgroup as $key) {
                echo '<option value="'.$key->id.'" 
                '.((!empty($getDataby_id->group_id) && $getDataby_id->group_id == $key->id) ? 'selected' : '' ).'>
                '.$key->name.'
                </option>';  
              }
             echo '</select>';
          } else {
            echo '<small class="form-text text-muted">What this field will be called in the CP.</small>';
          }
        ?>
      </div>
      <div class="form-group">
        <label class="heading required" for="inputPermissions">Permissions</label>
        <?php 
          if ($permissions) {
            echo '
              <select class="form-control costum-select" name="role">';
              foreach ($permissions as $key) {
                echo '<option value="'.$key->id.'" 
                '.((!empty($getDataby_id->role_id) && $getDataby_id->role_id == $key->id) ? 'selected' : '' ).'>
                '.$key->name.'
                </option>';  
              }
             echo '</select>';
          } else {
            echo '<small class="form-text text-muted">What this field will be called in the CP.</small>';
          }
        ?>
      </div>
      <?php $this->load->view('template/bootstrap-4/admin/partial/permission-users-form'); ?>
    </div>
    <?php
      if ($tabs_elements) {
        echo '<div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="layout-tab">';
        if ($element) { ?>
          <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
          <input type ="hidden" name="table_content" value="<?php echo $table; ?>">
          <input type ="hidden" name="parent_table" value="<?php echo (empty($parent_table) ? $table : $parent_table); ?>">
          <input type ="hidden" name="button" value="<?php echo $button_name; ?>">
          <input type ="hidden" name="action" value="<?php echo $action; ?>">
          <?php echo (empty($element_table) ? '' : '<input type ="hidden" name="element_table" value="'.$element_table.'">') ;?>
          <div class="entries-main" id="tabs-entries-main">
            <div class="heading" id="tabs-heading">
              <ul class="nav nav-tabs d-flex flex-row flex-nowrap" id="myTab" role="tablist">
                <?php
                  $i = 0; 
                  foreach ($tabs_elements as $elm) {
                  ++$i; 
                ?>
                <li class="nav-item">
                  <a class="nav-link <?php echo (($i == 1) ? 'active' : ''); ?>" id="pills-<?php echo $elm['id']; ?>-tab" 
                  data-toggle="pill" href="#<?php echo $elm['id']; ?>" role="tab" aria-controls="<?php echo $elm['title']; ?>" 
                  aria-selected="true"><?php echo ucwords($elm['title']); ?></a>
                </li>
              <?php } ?>
              </ul>  
            </div>

            <div class="entries-content" id="tabs-entries-content">
              <div class="tab-content" id="myTabContent">
                <?php 
                  $i = 0; 
                  foreach ($tabs_elements as $elm) {
                  ++$i; 
                ?>
                <div class="tab-pane fade <?php echo (($i == 1) ? 'show active' : ''); ?>" id="<?php echo $elm['id']; ?>" 
                  role="tabpanel" aria-labelledby="pills-<?php echo $elm['id']; ?>-tab">
                  <?php 
                    foreach ($elm['fields'] as $val) {
                      foreach ($fields as $key) {
                        if ($val == $key->id) {
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
                                      placeholder="'.$settings->plainPlaceholder.'">'.(!empty($getContentby_Id->$fieldsName) ? trim(strip_tags($getContentby_Id->$fieldsName)) : '').'</textarea>';        
                              } else {
                                echo '<input type="text" class="form-control" 
                                        name="fields_'.$key->handle.'" 
                                        placeholder="'.(!empty($setttings->plainPlaceholder) ? $setttings->plainPlaceholder : '').'"
                                        maxlength="'.(!empty($settings->plainCharlimit) ? $settings->plainCharlimit : '').'"
                                        value="'.(!empty($getContentby_Id->$fieldsName) ? $getContentby_Id->$fieldsName : set_value($fieldsName)).'">';                    
                              }
                            } elseif ($key->type_name == 'assets') {
                              foreach ($assets as $ast) {
                                if ($ast->id == $settings->assetsSourcesList) {
                                  $data['name'] = $ast->name;
                                }
                              }

                              echo '<div id="assetscontent-list-selected">
                                      <ul class="list-unstyled selected">';
                                        if (!empty($getContentby_Id->$fieldsName)) {
                                          $assetsList = explode(', ', $getContentby_Id->$fieldsName);
                                          if ($assets_content) {
                                            foreach ($assets_content as $astcont) {
                                              $filename   = explode('.', $astcont->file);
                                              $name       = current($filename);
                                              $thumb      = current($filename).'_thumb.'.end($filename);
                                              $file_thumb = base_url("{$astcont->path_thumb}/{$thumb}");
                                              $getSize    = get_headers($file_thumb, 1);
                                              if (in_array($astcont->id, $assetsList)) {
                                                echo '
                                                    <li><input type="hidden" name="'.$fieldsName.'[]" value="'.$astcont->id.'" class="assets-list">
                                                      <img src="'.$file_thumb.'" class="img-thumbnail list" 
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
                                      data-assets-limit ="'.$settings->assetsLimit.'" 
                                      data-assets-fields="fields_'.$key->handle.'"
                                      data-assets-source="'.$settings->assetsSourcesInput.'">
                                      + '.($settings->assetsSelectionLabel ? ucwords($settings->assetsSelectionLabel) : 'New Assets').'</button></div>';
                              echo '</div>';
                            } elseif ($key->type_name == 'richText') {
                            } elseif ($key->type_name == 'categories') {
                              foreach ($categories as $cat) {
                                if ($cat->id == $settings->categoriesSource) {
                                  $data['name'] = $cat->name;
                                }
                              }

                              echo '<div id="categoriescontent-list-selected">
                                      <ul class="list-unstyled selected">';
                                        if (!empty($getContentby_Id->$fieldsName)) {
                                          $catList = explode(', ', $getContentby_Id->$fieldsName);
                                          if ($categories_content) {
                                            foreach ($categories_content as $catCont) {
                                              if (in_array($catCont->id, $catList)) {
                                                echo '
                                                    <li><input type="hidden" name="'.$fieldsName.'[]" value="'.$catCont->id.'" class="categories-list">
                                                      <label for="input'.$catCont->title.'">'.$catCont->title.'</label>
                                                      <a><i class="fa fa-times" aria-hidden="true"></i></a
                                                    </li>';
                                              }
                                            }
                                          }
                                        }
                              echo '</ul>';
                              echo '<div>
                                      <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#categoriesModal"
                                      data-categories-id = "'.$settings->categoriesSource.'" 
                                      data-categories-limit ="'.$settings->categoriesLimit.'" 
                                      data-categories-fields="fields_'.$key->handle.'">
                                      + '.($settings->categoriesSelectionLabel ? ucwords($settings->categoriesSelectionLabel) : 'New Categories').'</button></div>';
                              echo '</div>';
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

                              if (!empty($getContentby_Id->$fieldsName)) {
                                $checkList = explode(', ', $getContentby_Id->$fieldsName);
                              }

                              foreach ($checkResult as $chkResult) {
                                echo '<div class="form-check">
                                        <input class="form-check-input" 
                                          type="checkbox" 
                                          name="fields_'.$key->handle.'[]" 
                                          value="'.$chkResult['value'].'"
                                          '.((!empty($getContentby_Id->$fieldsName) && in_array($chkResult['value'], $checkList)) ? 'checked' : '').'>
                                        <label class="form-check-label" 
                                          for="defaultCheck1">'.ucfirst($chkResult['label']).'
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
                              if (!empty($getContentby_Id->$fieldsName)) {
                                $checkList = explode(', ', $getContentby_Id->$fieldsName);
                              }
                              echo '<select class="form-control costum-select" name="fields_'.$key->handle.'">';
                              foreach ($dropResult as $drpResult) {
                                echo '<option value="'.$drpResult['value'].'"
                                '.((!empty($getContentby_Id->$fieldsName) && in_array($drpResult['value'], $checkList)) ? 'selected' : '').'>
                                '.ucfirst($drpResult['label']).'</option>';
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
                              if (!empty($getContentby_Id->$fieldsName)) {
                                $checkList = explode(', ', $getContentby_Id->$fieldsName);
                              }
                              foreach ($radioResult as $radResult) {
                                echo '<div class="form-check">
                                        <input class="form-check-input" type="radio" name="fields_'.$key->handle.'[]"  value="'.$radResult['value'].'"
                                        '.((!empty($getContentby_Id->$fieldsName) && in_array($radResult['value'], $checkList)) ? 'checked' : '').'>
                                        <label class="form-check-label" for="defaultCheck1">'.ucfirst($radResult['label']).'</label>
                                      </div>';
                              }
                            } elseif ($key->type_name == 'entries') {
                              echo '<div id="entriescontent-list-selected">
                                      <ul class="list-unstyled selected">';
                                        if (!empty($getContentby_Id->$fieldsName)) {
                                          $entList = explode(', ', $getContentby_Id->$fieldsName);
                                          if ($entries_content) {
                                            foreach ($entries_content as $entCont) {
                                              if (in_array($entCont->id, $entList)) {
                                                echo '
                                                    <li><input type="hidden" name="'.$fieldsName.'[]" value="'.$entCont->id.'" class="entries-list">
                                                      <label for="input'.$entCont->title.'">'.$entCont->title.'</label>
                                                      <a><i class="fa fa-times" aria-hidden="true"></i></a
                                                    </li>';
                                              }
                                            }
                                          }
                                        }
                              echo '</ul>';
                              echo '<div>
                                      <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#entriesModal"
                                      data-section-id = "'.$settings->entriesSource.'"
                                      data-entries-limit ="'.$settings->entriesLimit.'" 
                                      data-entries-fields="fields_'.$key->handle.'">
                                      + '.($settings->entriesSelectionLabel ? ucwords($settings->entriesSelectionLabel) : 'New Categories').'</button></div>';
                              echo '</div>';
                            }
                          echo '</div>';
                        }
                      }
                    }
                  ?>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php }        
        echo '</div>';
      } 
    ?>
  </div>
  <?php echo form_close(); ?>
</div>
</div>