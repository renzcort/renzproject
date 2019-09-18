<div class="content-body d-flex flex-row flex-grow-1 justify-content-start entries-template categories-form" id="categories">
  <div id="left-content-entries"> 
    <?php $this->load->view('template/bootstrap-4/admin/partial/tabs-entries'); ?>
  </div>
  <div id="right-content-entries">
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
        <input type="text" class="form-control-plaintext px-2 datepicker" name="postdate"
        value="<?php echo (!empty($getDataby_id->postdate_at) ? date('d/m/Y', strtotime($getDataby_id->postdate_at)) : set_value('postdate')); ?>">
        <div class="form-error"><?php echo form_error('postdate'); ?></div>
      </div>
    </div>
    <div class="form-group row">
      <label for="staticEmail" class="col-sm-3 col-form-label">Expiry Date</label>
      <div class="col-sm-9">
        <input type="text" class="form-control-plaintext px-2 datepicker" name="expirydate"
        value="<?php echo (!empty($getDataby_id->expirydate_at) ? date('d/m/Y', strtotime($getDataby_id->expirydate_at)) : set_value('expirydate')); ?>">
        <div class="form-error"><?php echo form_error('expirydate'); ?></div>
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
</div>
<?php echo form_close(); ?>