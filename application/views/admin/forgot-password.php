<?php if ($this->session->flashdata('message')) { ?>
<div class="message">
  <h5 class="alert alert-danger"><?php echo $this->session->flashdata('message');?></h5>
</div>
<?php } ?>

<div class="forgot-password text-center">
  <p>
    <?php echo validation_errors(); ?>
  </p>
  <?php echo form_open('admin/forgot-password', ''); ?>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="email" name="email" class="form-control" placeholder="Enter Your Email">
        </div>
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </div>
  </div>
  <?php echo form_close(); ?>
</div>