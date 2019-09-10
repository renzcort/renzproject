<div class="content-body flex-grow-1" id="assets">
  <div class="assets-transform-form" id="middle-content">
    <?php
      $attributes = array(
        'class' => 'form',
        'id'    => 'MyForm',
      );
      echo form_open($action.(!empty($getDataby_id) ? '/edit' : '/create').(isset($id) ? '/'.$id : ''), $attributes);
    ?>
    <input type="hidden" name="button" value="<?php echo $button_name; ?>">
    <input type ="hidden" name="id" value="<?php echo (!empty($getDataby_id->id) ? $getDataby_id->id : ''); ?>">
    <input type ="hidden" name="table" value="<?php echo $table; ?>">
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
      <label for="inputMode" class="heading required">Mode</label>
      <div class="d-flex flex-row justify-content-start">
        <?php foreach ($transforms_mode as $key => $value): ?>
        <div class="d-flex flex-column justify-content-center px-2">
          <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" width="100" height="100">
          <div class="my-1 text-center">
            <input type="radio" name="mode" value="<?php echo $value; ?>" <?php echo ((!empty($getDataby_id->mode) && $getDataby_id->mode == $value) ? 'checked' : '' );?>>
            <label class="px-1"><?php echo ucfirst($value); ?></label>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </div>
    <div class="form-group">
      <label for="inputPoint" class="heading">Default Focal Point</label>
      <select name="point" id="" class="form-control costum-select">
        <option value="0">- Select Point -</option>
        <?php foreach ($transforms_point as $key => $value): ?>
        <option value="<?php echo $value; ?>" <?php echo ((!empty($getDataby_id->point) && $getDataby_id->point == $value) ? 'selected' : '' ); ?>><?php echo ucfirst($value); ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="form-group">
      <label for="inputWidth" class="heading">Width</label>
      <input type="text" name="width" class="form-control form-number" value="<?php echo (!empty($getDataby_id->width) ? $getDataby_id->width : set_value('width')); ?>">
    </div>
    <div class="form-group">
      <label for="inputHeight" class="heading">Height</label>
      <input type="text" name="height" class="form-control form-number" value="<?php echo (!empty($getDataby_id->height) ? $getDataby_id->height : set_value('height')); ?>">
    </div>
    <div class="form-group">
      <label for="inputQuality" class="heading">Quality</label>
      <select name="quality" id="" class="form-control costum-select">
        <option value="0">- Select Quality -</option>
        <?php foreach ($transforms_quality as $key => $value): ?>
        <option value="<?php echo $value; ?>" <?php echo ((!empty($getDataby_id->quality) && $getDataby_id->quality == $value) ? 'selected' : '' ); ?>><?php echo ucfirst($value); ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="form-group">
      <label for="inputInterlacing" class="heading">Interlacing</label>
      <select name="interlacing" id="" class="form-control costum-select">
        <option value="0">- Select Interlacing -</option>
        <?php foreach ($transforms_interlacing as $key => $value): ?>
        <option value="<?php echo $value; ?>" <?php echo ((!empty($getDataby_id->interlacing) && $getDataby_id->interlacing == $value) ? 'selected' : '' ); ?>><?php echo ucfirst($value); ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="form-group">
      <label for="inputFormat" class="heading">Image Format</label>
      <small class="form-text text-muted">The image format that transformed images should use.</small>
      <select name="format" id="" class="form-control costum-select">
        <option value="0">- Select Format -</option>
        <?php foreach ($transforms_format as $key => $value): ?>
        <option value="<?php echo $value; ?>" <?php echo ((!empty($getDataby_id->format) && $getDataby_id->format == $value) ? 'selected' : '' ); ?>><?php echo ucfirst($value); ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>