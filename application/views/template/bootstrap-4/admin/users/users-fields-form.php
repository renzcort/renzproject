<?php
  $attributes = array(
    'class' => 'form',
    'id' => 'MyForm',
  );
  echo form_open($action.(isset($id) ? '/edit/'.$id : '/create'), $attributes); 
?>
<div class="right-content-body">
  <input type ="hidden" name="header" value="<?php echo $title; ?>">
  <input type ="hidden" name="subtitle" value="<?php echo $subtitle; ?>">
  <input type ="hidden" name="button" value="<?php echo $button_name; ?>">
  <input type ="hidden" name="table" value="<?php echo $table; ?>">
  <input type ="hidden" name="right_content" value="<?php echo $right_content; ?>">
  <input type ="hidden" name="content" value="<?php echo $content; ?>">
  <input type ="hidden" name="fields_element" value="<?php echo $fields_element; ?>">
  <input type ="hidden" name="action" value="<?php echo $action; ?>">
  <input type ="hidden" name="handle" value="<?php echo $handle; ?>">
  <input type ="hidden" name="name" value="<?php echo ucfirst($handle); ?>">
  <input type ="hidden" name="id" value="<?php echo (empty($id) ? '' : $id); ?>">
  <?php $this->load->view('template/bootstrap-4/admin/partial/tabs-form'); ?>
</div>
<?php echo form_close(); ?>