<div class="row">
  <div class="col-sm-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo (isset($title) ? ucfirst($title).'&nbsp;'.$subheader : ucfirst($header).'&nbsp;'.$subheader); ?></h3>
      </div>
      <?php
        $attrb = array(
          'class' => 'form', 
        ); 
        $hidden = array('id' => $getdataby_id->id);
        echo form_open_multipart(base_url("{$action}/edit/{$getdataby_id->id}/?entries_id={$getdataby_id->entries_id}"), $attrb, $hidden); 
      ?>
      <div class="box-body">
        <div class="form-group">
          <label for="InputName">Title</label>
          <input type="text" class="form-control" name="title" value="<?php echo ($getdataby_id ? $getdataby_id->title : set_value('title')); ?>" >
        </div>
        <?php echo form_error('title'); ?>
        <?php 
          foreach ($fields as $key) { 
            $field = "field_{$key->handle}";
        ?>
        <div class="form-group">
          <label for="Input<?php echo $key->handle; ?>"><?php echo $key->name; ?></label>
          <?php if ($key->handle_type == 'planText') { ?>
            <input type="text" class="form-control" 
            name="<?php echo "$field"; ?>" 
            value="<?php  echo ($getdataby_id ?  $getdataby_id->$field : set_value($field)); ?>" 
            placeholder="<?php echo ($key->placeholder ? $key->placeholder : ''); ?>" 
            max_length="<?php echo ($key->max_length ? $key->max_length : '' ); ?>" 
            min_length="<?php echo ($key->min_length ? $key->min_length : '') ?>">
          <?php } elseif ($key->handle_type == 'richText') { ?>
            <textarea class="form-control" name="<?php echo "field_{$key->name}"; ?>"><?php  echo ($getdataby_id ?  $getdataby_id->$field : set_value($field)); ?></textarea>
          <?php } ?>
        </div>
        <?php echo ($key->required ? form_error("field_{$key->handle}") : ''); ?>
        <?php } ?>
        <div class="box-footer">
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm" name="create">Create</button>
          </div>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>