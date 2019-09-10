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
        echo form_open_multipart(base_url("{$action}/create/?handle={$handle}&entries_id={$entries_id}"), $attrb); 
      ?>
      <div class="box-body">
        <div class="form-group">
          <label for="InputName">Title</label>
          <input type="text" class="form-control" name="title" value="<?php echo set_value('title'); ?>" >
        </div>
        <?php echo form_error('title'); ?>
        <?php foreach ($fields as $key) { ?>
        <div class="form-group">
          <label for="Input<?php echo $key->name; ?>"><?php echo $key->name; ?></label>
          <?php if ($key->handle_type == 'planText') { ?>
            <input type="text" class="form-control" name="<?php echo "field_{$key->handle}"; ?>" value="<?php echo set_value("field_{$key->handle}"); ?>" placeholder="<?php echo ($key->placeholder ? $key->placeholder : ''); ?>" max_length="<?php echo ($key->maxlength ? $key->maxlength : '' ); ?>" min_length="<?php echo ($key->minlength ? $key->minlength : '') ?>">
          <?php } elseif ($key->handle_type == 'richText') { ?>
            <textarea class="form-control" name="<?php echo "field_{$key->name}"; ?>"></textarea>
          <?php } ?>
        </div>
        <?php echo (($key->action == 'required') ? form_error("field_{$key->name}") : ''); ?>
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