<div class="middle-content flex-grow-1" id="fields">
  <?php
    $attributes = array('class' => 'form',
                        'id' => 'MyForm',
                  ); 
    echo form_open($action.(isset($id) ? '/'.$id : ''), $attributes); 
  ?>
    <input type ="hidden" name="button" value="<?php echo $button_name; ?>">
    <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
    <input type ="hidden" name="table" value="<?php echo $table; ?>">
    <div class="form-group">
      <label class="heading" for="inputGroup">Group</label>
      <small class="form-text text-muted">Which group should this field be displayed in?</small>
      <!-- <input type="hidden" name="fieldsGroupId" value="3"> -->
      <select name="fieldsGroupId" class="form-control costum-select">
        <?php foreach ($group as $key): ?>
          <option value="<?php echo $key->id; ?>" data-id="<?php echo $key->id; ?>" 
            <?php echo ((!empty($getDataby_id->group_id) && $getDataby_id->group_id == $key->id) ? 'selected' : '' ) ?>>
            <?php echo ucfirst($key->name); ?>
          </option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="form-group">
      <label class="heading required" for="inputName">Name</label>
      <small class="form-text text-muted">What this field will be called in the CP.</small>
      <input type="text" name="name" class="form-control"  placeholder="Name" 
      value="<?php echo (!empty($getDataby_id->name) ? $getDataby_id->name : set_value('name')); ?>">
      <div class="form-error"><?php echo form_error('name'); ?></div>
    </div>
    <div class="form-group">
      <label class="heading required" for="inputHandle">Handle</label>
      <small class="form-text text-muted">How you’ll refer to this field in the templates.</small>
      <input type="text" name="handle" class="form-control"  placeholder="Handle" 
      value="<?php echo (!empty($getDataby_id->handle) ? $getDataby_id->handle : set_value('handle')); ?>">
      <div class="form-error"><?php echo form_error('handle'); ?></div>
    </div>
    <div class="form-group">
      <label class="heading" for="inputInstruction">Description</label>
      <small class="form-text text-muted">Helper text to guide the author.</small>
      <textarea class="form-control" name="description"><?php echo (!empty($getDataby_id->description) ? trim(strip_tags($getDataby_id->description)) : ''); ?></textarea>
      <div class="form-check">
        <input type="checkbox" name="translateable" class="form-check-input">
        <label class="form-check-label" for="inputTranslateable">This field is translatable</label>
      </div>
    </div>
    <div class="form-group">
      <label class="heading" for="inputType">Field Type</label>
      <small class="form-text text-muted">What type of field is this?</small>
      <input type="hidden" name="fieldsTypeId" value="2">
      <select name="fieldsType" class="form-control costum-select">
        <?php foreach ($fields_type as $key): ?>
          <option value ="<?php echo $key->handle; ?>" data-id="<?php echo $key->id; ?>"
            <?php echo ((!empty($getDataby_id->type_id) && $getDataby_id->type_id == $key->id) ? 'selected' : '' ) ?> >
            <?php echo $key->name; ?>
          </option>
        <?php endforeach ?>
      </select>
    </div>
    <div id="plainText" class="fields <?php echo ((!empty($getDataby_id->type_id) && $typeFields->handle == 'plainText') || empty($getDataby_id->type_id)  ? '' : 'd-none');?>">
      <div class="form-group">
        <label class="heading" for="inputPlaceholder">Placeholder Text</label>
        <small class="form-text text-muted">The text that will be shown if the field doesn’t have a value.</small>
        <input type="text" name="plainPlaceholder" class="form-control"
        value="<?php echo (!empty($getFieldType->plainPlaceholder) ? $getFieldType->plainPlaceholder : set_value('plainPlaceholder')); ?>">
      </div>
      <div class="form-group">
        <label class="heading" for="inputCharLimit">Character Limit</label>
        <small class="form-text text-muted">The maximum length of characters the field is allowed to have.</small>
        <input type="text" name="plainCharlimit" class="form-control form-number"
        value="<?php echo (!empty($getFieldType->plainCharlimit) ? $getFieldType->plainCharlimit : set_value('plainCharlimit')); ?>">
      </div>
      <div class="form-group">
        <div class="form-check">
          <input type="checkbox" name="plainMonospacedFont" class="form-check-input" value="1" <?php echo (!empty($getFieldType->plainMonospacedFont) ? 'checked' : '') ?>>
          <label class="form-check-label" for="inputAllowLineBreaks">Use a monospaced font</label>
        </div>
        <div class="form-check" style="width: ">
          <input type="checkbox" name="plainLineBreak" class="form-check-input" value="1" <?php echo (!empty($getFieldType->plainLineBreak) ? 'checked' : '') ?>>
          <label class="form-check-label" for="inputAllowLineBreaks">Allow line breaks</label>
        </div>
      </div>
      <div class="form-group plainLineBreak">
        <label class="heading" for="inputInitialRows">Initial Rows</label>
        <input type="text" name="plainInitialRows" class="form-control form-number" value ="<?php echo (!empty($getFieldType->plainInitialRows) ? $getFieldType->plainInitialRows : set_value('plainInitialRows')); ?>">
      </div>
      <div class="form-group">
        <label class="heading" for="inputColumnType">Column Type</label>
        <small class="form-text text-muted">The type of column this field should get in the database.</small>
        <select name="plainColumnType" class="form-control costum-select">
          <option value="0">- Select Type -</option>
        </select>
      </div>
    </div>
    <div id="assets" class="fields <?php echo ((!empty($getDataby_id->type_id) && $typeFields->handle == 'assets') ? '' : 'd-none');?>">
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="assetsRestrictUpload" 
          value="1" <?php echo (!empty($getFieldType->assetsRestrictUpload) ? 'checked' : '') ?>>
          <label class="form-check-label" for="restrictAssets">Restrict uploads to a single folder?</label>
        </div>
      </div>
      <div class="form-group assetsRestrictUpload">
        <label class="heading" for="inputUploadLocation">Upload Location</label>
        <small class="form-text text-muted">Where should files be uploaded when they are dragged directly onto the field, or uploaded from the front end? Note that the subfolder path can contain variables like {slug} or {author.username}.</small>
        <div class="d-flex flex-row justify-content-between">
          <select name="assetsSourcesList" class="form-control costum-select">
            <option value="0">Default</option>
            <?php if ($assets): ?>
              <?php foreach ($assets as $key): ?>
                <option value="<?php echo $key->id; ?>" <?php echo ((!empty($getFieldType->assetsSourcesList) && $getFieldType->assetsSourcesList == $key->id) ? 'selected' : '');?>>
                  <?php echo $key->name; ?>
                </option>
              <?php endforeach ?>
            <?php endif ?>
          </select>
          <input type="text" name="assetsSourcesInput" placeholder="path/to/subfolder" class="form-control flex-grow-1 ml-2" 
          value="<?php echo (!empty($getFieldType->assetsSourcesInput) ? $getFieldType->assetsSourcesInput : set_value('assetsSourcesInput')); ?>">
        </div>
      </div>
      <div class="form-group noAssetsRestrictUpload">
        <label class="heading" for="inputSource">Sources</label>
        <small class="form-text text-muted">Which sources do you want to select assets from?</small>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="all" name="assetsSources[]" checked>
          <label class="form-check-label" for="defaultCheck1"><strong>All</strong></label>
        </div>
        <?php if ($assets): ?>
          <?php foreach ($assets as $key): ?>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="<?php echo $key->id; ?>" name="assetsSources[]" checked disabled>
            <label class="form-check-label" for="defaultCheck1"><?php echo $key->name; ?></label>
          </div>
          <?php endforeach ?>
        <?php endif ?>
      </div>
      <div class="form-group noAssetsRestrictUpload">
        <label class="heading" for="inputUploadLocation">Default Upload Location</label>
        <small class="form-text text-muted">Where should files be uploaded when they are dragged directly onto the field, or uploaded from the front end? Note that the subfolder path can contain variables like {slug} or {author.username}.</small>
        <div class="d-flex flex-row justify-content-between">
          <select name="assetsSourcesList" class="form-control costum-select">
            <option value="0">Default</option>
            <?php if ($assets): ?>
              <?php foreach ($assets as $key): ?>
                <option value="<?php echo $key->id; ?>" <?php echo ((!empty($getFieldType->assetsSourcesList) && $getFieldType->assetsSourcesList == $key->id) ? 'selected' : '');?>>
                  <?php echo $key->name; ?>
                </option>
              <?php endforeach ?>
            <?php endif ?>
          </select>
          <input type="text" name="assetsSourcesInput" placeholder="path/to/subfolder" class="form-control flex-grow-1 ml-2" 
          value="<?php echo (!empty($getFieldType->assetsSourcesInput) ? $getFieldType->assetsSourcesInput : set_value('assetsSourcesInput')); ?>">
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="assetsRestrictFileType" 
          value="1" <?php echo (!empty($getFieldType->assetsRestrictFileType) ? 'checked' : '') ?>>
          <label class="form-check-label" for="restrictAssets">Restrict allowed file types?</label>
        </div>
      </div>
      <div class="form-group assetsRestrictFileType">
        <?php if ($file): ?>
          <?php foreach ($file as $key => $value): ?>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="<?php echo $value; ?>" name="assetsType[]" 
            <?php echo ((!empty($getFieldType->assetsType) && in_array($value, $getFieldType->assetsType)) ? 'checked' : '');?>>
            <label class="form-check-label" for="defaultCheck1"><?php echo $value ?></label>
          </div>
          <?php endforeach ?>
        <?php endif ?>
      </div>
      <div class="form-group">
        <label class="heading" for="inputLocale">Target Locale</label>
        <small class="form-text text-muted">Choose how the field should look for authors.</small>
        <select name="assetsTargetLocale" class="form-control costum-select">
          <option value="0">- Select Locale -</option>
        </select>
      </div>
      <div class="form-group">
        <label class="heading" for="inputLimit">Limit</label>
        <small class="form-text text-muted">Limit the number of selectable assets.</small>
        <input type="text" name="assetsLimit" class="form-control form-number" 
        value="<?php echo (!empty($getFieldType->assetsLimit) ? $getFieldType->assetsLimit : set_value('assetsLimit')); ?>"> 
      </div>
      <div class="form-group">
        <label class="heading" for="inputMode">View Mode</label>
        <small class="form-text text-muted">Choose how the field should look for authors.</small>
        <select name="assetsViewMode" class="form-control costum-select">
        <?php if ($mode): ?>
          <?php foreach ($mode as $key => $value): ?>
          <option value="<?php echo $value; ?>" 
            <?php echo ((!empty($getFieldType->assetsViewMode) && $getFieldType->assetsViewMode == $value) ? 'selected' : '');?>>
            <?php echo $value; ?>
          </option>
          <?php endforeach ?>
        <?php endif ?>
        </select>
      </div>
      <div class="form-group">
        <label class="heading" for="inputSelectionLabel">Selection Label</label>
        <small class="form-text text-muted">Enter the text you want to appear on the assets selection input.</small>
        <input type="text" name="assetsSelectionLabel" class="form-control" placeholder="Add an asset" 
        value="<?php echo (!empty($getFieldType->assetsSelectionLabel) ? $getFieldType->assetsSelectionLabel : set_value('assetsSelectionLabel')); ?>">
      </div>
    </div>
    <div id="richText" class="fields <?php echo ((!empty($getDataby_id->type_id) && $typeFields->handle == 'richText') ? '' : 'd-none');?>">
      <div class="form-group">
        <label class="heading" for="inputConfig">Config</label>
        <small class="form-text text-muted">You can save custom Redactor configs as .json files in craft/config/redactor/. View available settings.</small>
        <select name="richConfig" class="form-control costum-select">
          <option value="0">- Select Config -</option>
        </select>
      </div>
      <div class="form-group">
        <label class="heading" for="inputSource">Available Asset Sources</label>
        <small class="form-text text-muted">The asset sources that should be available when selecting assets (if the selected config has an Image or File button).</small>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="all" name="richAssetsSources[]">
          <label class="form-check-label" for="defaultCheck1">All</label>
        </div>
        <?php if ($assets): ?>
          <?php foreach ($assets as $key): ?>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="richAssetsSources[]" value="<?php echo $key->id; ?>" 
            <?php echo ((!empty($getFieldType->assetsType) && in_array($value, $getFieldType->assetsType)) ? 'checked' : '');?>
            >
            <label class="form-check-label" for="defaultCheck1"><?php echo $key->name; ?></label>
          </div>
          <?php endforeach ?>
        <?php endif ?>
      </div>
      <div class="form-group">
        <label class="heading" for="inputTransforms">Available Image Transforms</label>
        <small class="form-text text-muted">The image transforms that should be available when selecting images (if the selected config has an Image button).</small>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" \name="richSources" 
          value="1" <?php echo (!empty($getFieldType->richSources) ? 'checked' : '') ?>>
          <label class="form-check-label" for="defaultCheck1">All</label>
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="richCleanHTML"
          value="1" <?php echo (!empty($getFieldType->richCleanHTML) ? 'checked' : '');?>>
          <label class="form-check-label" for="defaultCheck1">Clean up HTML?</label>
        </div>
        <small class="form-text text-muted">Removes <span>’s, empty tags, and most style attributes on save.</small>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" name="richPurifyHTML"
          value="1" <?php echo (!empty($getFieldType->richPurifyHTML) ? 'checked' : '');?>>
          <label class="form-check-label" for="defaultCheck1">Purify HTML?</label>
        </div>
        <small class="form-text text-muted">Removes any potentially-malicious code on save, by running the submitted data through HTML Purifier.</small>
      </div>
      <div class="form-group">
        <label class="heading" for="inputColumnType">Column Type</label>
        <small class="form-text text-muted">The underlying database column type to use when saving content.</small>
        <select name="columnType" class="form-control costum-select">
          <option value="0">- Select Column Type -</option>
        </select>
      </div>
    </div>
    <div id="categories" class="fields <?php echo ((!empty($getDataby_id->type_id) && $typeFields->handle == 'categories') ? '' : 'd-none');?>">
      <div class="form-group">
        <label class="heading" for="inputSource">Source</label>
        <small class="form-text text-muted">Which source do you want to select categories from?</small>
        <select name="categoriesSource" class="form-control costum-select">
          <option value="0">- Select Categories -</option>
          <?php if ($categories): ?>
            <?php foreach ($categories as $key): ?>
            <option value="<?php echo $key->id ?>" 
              <?php echo ((!empty($getFieldType->categoriesSource) && $getFieldType->categoriesSource == $key->id) ? 'selected' : '');?>>
              <?php echo ucfirst($key->name); ?>
            </option>
            <?php endforeach ?>
          <?php endif ?>  
        </select>
      </div>
      <div class="form-group">
        <label class="heading" for="inputTargetLocale">Target Locale</label>
        <small class="form-text text-muted">Which Target Locale do you want to select categories from?</small>
        <select name="categoriesTargetLocale" class="form-control costum-select">
          <option value="0">- Select Source -</option>
        </select>
      </div>
      <div class="form-group">
        <label class="heading" for="inputLimit">Limit</label>
        <small class="form-text text-muted">Limit the number of selectable assets.</small>
        <input type="text" name="categoriesLimit" class="form-control form-number" 
        value="<?php echo (!empty($getFieldType->categoriesLimit) ? $getFieldType->categoriesLimit : set_value('categoriesLimit')); ?>">
      </div>
      <div class="form-group">
        <label class="heading" for="inputSelectionLabel">Selection Label</label>
        <small class="form-text text-muted">Enter the text you want to appear on the assets selection input.</small>
        <input type="text" name="categoriesSelectionLabel" class="form-control" placeholder="add a categories"
        value="<?php echo (!empty($getFieldType->categoriesSelectionLabel) ? $getFieldType->categoriesSelectionLabel : set_value('categoriesSelectionLabel')); ?>">
      </div>
    </div>
    <div id="checkboxes" class="fields <?php echo ((!empty($getDataby_id->type_id) && $typeFields->handle == 'checkboxes') ? '' : 'd-none');?>">
      <div class="form-group">
        <label class="heading" for="inputCheckbox">Checkbox Options</label>
        <small class="form-text text-muted">Define the available options.</small>
        <table class="table table-sm font-weight-light m-0">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Option Label</th>
              <th scope="col">Value</th>
              <th scope="col">Default?  </th>
              <th colspan="2" ></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              if (!empty($getFieldType->checkboxesLabel)):
                $val = $getFieldType->checkboxesValue; 
                $i = 0;
                foreach ($getFieldType->checkboxesLabel as $key => $value) :
                  $dataResult[] = array(
                              'label' => $value,
                              'value' => $val[$i]
                            );
                  $i++;
                endforeach;
            ?>
              <?php foreach ($dataResult as $key) : ?>
              <tr>

                <td><input type="text" name="checkboxesLabel[]" class="form-control" value="<?php echo $key['label']; ?>"></td>
                <td><input type="text" name="checkboxesValue[]" class="form-control" value="<?php echo $key['value']; ?>"></td>
                <td class="action"><input type="checkbox" name="checkboxesDefault[]"></td>
                <td scope="row" colspan="2">
                  <a href="#"><i class="fas fa-arrows-alt"></i></a>
                  <a class="remove-row"><i class="fas fa-minus-circle"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
        <button type="button" class="btn btn btn-outline-secondary btn-block">+ Add an option</button>
      </div>
    </div>
    <div id="dateTime" class="fields <?php echo ((!empty($getDataby_id->type_id) && $typeFields->handle == 'dateTime') ? '' : 'd-none');?>">
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="datetimeList" value="1" checked>
          <label class="form-check-label" for="datetimeList1">
            Show Date
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="datetimeList" value="2">
          <label class="form-check-label" for="datetimeList2">
            Show Time
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="datetimeList" value="3">
          <label class="form-check-label" for="datetimeList3">
            Show date and time 
          </label>
        </div>
      </div>
      <div class="form-group">
        <label class="heading" for="inputMunite">Munite Increment</label>
        <select class="form-control costum-select" name="datetimeIncrement">
          <option value="">30</option>
          <option value="">60</option>
        </select>
      </div>
    </div>
    <div id="dropdown" class="fields <?php echo ((!empty($getDataby_id->type_id) && $typeFields->handle == 'dropdown') ? '' : 'd-none');?>">
      <div class="form-group">
        <label class="heading" for="inputCheckbox">Checkbox Options</label>
        <small class="form-text text-muted">Define the available options.</small>
        <table class="table table-sm font-weight-light m-0">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Option Label</th>
              <th scope="col">Value</th>
              <th scope="col">Default?  </th>
              <th colspan="2" ></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              if (!empty($getFieldType->dropdownLabel)):
                $val = $getFieldType->dropdownValue; 
                $i = 0;
                foreach ($getFieldType->dropdownLabel as $key => $value) :
                  $dataResult[] = array(
                              'label' => $value,
                              'value' => $val[$i]
                            );
                  $i++;
                endforeach;
            ?>
              <?php foreach ($dataResult as $key) : ?>
              <tr>

                <td><input type="text" name="dropdownLabel[]" class="form-control" value="<?php echo $key['label']; ?>"></td>
                <td><input type="text" name="dropdownValue[]" class="form-control" value="<?php echo $key['value']; ?>"></td>
                <td class="action"><input type="checkbox" name="dropdownDefault[]"></td>
                <td scope="row" colspan="2">
                  <a href="#"><i class="fas fa-arrows-alt"></i></a>
                  <a class="remove-row"><i class="fas fa-minus-circle"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
        <button type="button" class="btn btn btn-outline-secondary btn-block">+ Add an option</button>
      </div>
    </div>
    <div id="radio" class="fields <?php echo ((!empty($getDataby_id->type_id) && $typeFields->handle == 'radio') ? '' : 'd-none');?>">
      <div class="form-group">
        <label class="heading" for="inputCheckbox">Checkbox Options</label>
        <small class="form-text text-muted">Define the available options.</small>
        <table class="table table-sm font-weight-light m-0">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Option Label</th>
              <th scope="col">Value</th>
              <th scope="col">Default?  </th>
              <th colspan="2" ></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              if (!empty($getFieldType->radioLabel)):
                $val = $getFieldType->radioValue; 
                $i = 0;
                foreach ($getFieldType->radioLabel as $key => $value) :
                  $dataResult[] = array(
                              'label' => $value,
                              'value' => $val[$i]
                            );
                  $i++;
                endforeach;
            ?>
              <?php foreach ($dataResult as $key) : ?>
              <tr>

                <td><input type="text" name="radioLabel[]" class="form-control" value="<?php echo $key['label']; ?>"></td>
                <td><input type="text" name="radioValue[]" class="form-control" value="<?php echo $key['value']; ?>"></td>
                <td class="action"><input type="checkbox" name="radioDefault[]"></td>
                <td scope="row" colspan="2">
                  <a href="#"><i class="fas fa-arrows-alt"></i></a>
                  <a class="remove-row"><i class="fas fa-minus-circle"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
        <button type="button" class="btn btn btn-outline-secondary btn-block">+ Add an option</button>
      </div>
    </div>
  <?php echo form_close(); ?>
</div>
