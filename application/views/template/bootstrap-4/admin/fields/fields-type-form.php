<div class="middle-content flex-grow-1" id="fields-type">
  <?php
    $attributes = array(
      'class' =>  'form',
      'id'    =>  'MyForm',
    );
    echo form_open($action.(isset($id) ? '/edit/'.$id : '/create'), $attributes); 
  ?>
  <input type ="hidden" name="button" value="<?php echo $button_name; ?>">
  <div class="form-group">
    <label class="heading" for="inputName">Name</label>
    <input type="text" name="name" class="form-control" placeholder="System Name"
    value="<?php echo (!empty($getDataby_id->name) ? $getDataby_id->name : set_value('name')) ?>">
  </div>
  <div class="form-group">
    <label class="heading" for="inputTypeData">Type Data</label>
    <small class="form-text text-muted">The type of column this field should get in the database.</small>
    <select name="type" class="form-control costum-select">
      <option value="0">- Select Type -</option>
      <?php foreach ($type as $key => $value) { ?>
        <option value="<?php echo $value; ?>" 
        <?php echo ((!empty($getDataby_id->type) && $getDataby_id->type == $value) ? 'selected' : '');?>>
        <?php echo $value; ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <label class="heading" for="inputInstruction">Description</label>
    <small class="form-text text-muted">Helper text to guide the author.</small>
    <textarea class="form-control" name="description"><?php echo (!empty($getDataby_id->description) ? trim(strip_tags($getDataby_id->description)) : ''); ?></textarea>
  </div>
  <?php echo form_close(); ?>
</div>