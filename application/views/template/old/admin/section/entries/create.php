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
        echo form_open_multipart(base_url("{$action}/create?section_id={$section_id}"), $attrb); 
      ?>
      <div class="box-body">
        <div class="form-group">
          <label for="InputName">Name</label>
          <input type="text" class="form-control" name="name" value="<?php echo set_value('name'); ?>" >
        </div>
        <?php echo form_error('name'); ?>
        <div class="form-group">
          <label for="InputHandle">Handle</label>
          <input type="text" name="handle" class="form-control" value="<?php set_value('handle') ?>" >
        </div>
        <?php echo form_error('handle') ?>
        <div class="form-group">
          <label for="Inputtitle">Title Field Label</label>
          <input type="text" name="title" class="form-control" value="<?php echo set_value('title'); ?>" >
        </div>
        <?php echo form_error('title') ?>
        <div class="form-group">
          <label for="InputFieldType">Field Layout</label>
          <ul>
            <?php foreach ($field as $key) { ?>
            <li>
              <input type="checkbox" name="field[]" value="<?php echo $key->id; ?>"> <?php echo $key->name; ?> 
            </li>
            <?php } ?>
          </ul>
        </div> 
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