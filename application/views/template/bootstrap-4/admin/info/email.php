<div class="content-body flex-grow-1" id="info">
  <div class="email-form" id="middle-content">
    <?php
      $attributes = array(
        'class' =>  'form',
        'id'    =>  'MyForm',
      );
      echo form_open($action, $attributes);
    ?>
    <input type ="hidden" name="button" value="<?php echo $button_name; ?>">
    <div class="form-group">
      <label class="heading required" for="inputEmail">System Email Address</label>
      <small class="form-text text-muted">The email address Craft CMS will use when sending email.</small>
      <input type="email" name="email" class="form-control"
      value="<?php echo (!empty($getDataby_id->email) ? $getDataby_id->email : set_value('email') ) ?>">
      <small class="form-text text-muted">This can be set to an environment variable. Learn more</small>
    </div>
    <div class="form-group">
      <label class="heading required" for="inputSenderName">Sender Name</label>
      <small class="form-text text-muted">The “From” name Craft CMS will use when sending email.</small>
      <input type="text" name="email_sendername" class="form-control"
      value="<?php echo (!empty($getDataby_id->email_sendername) ? $getDataby_id->email_sendername : set_value('email_sendername') ) ?>">
      <small class="form-text text-muted">This can be set to an environment variable. Learn more</small>
    </div>
    <div class="form-group">
      <label class="heading required" for="inputSenderName">HTML Email Template</label>
      <small class="form-text text-muted">The template Craft CMS will use for HTML emails</small>
      <input type="text" name="email_template" class="form-control"
      value="<?php echo (!empty($getDataby_id->email_template) ? $getDataby_id->email_template : set_value('email_template') ) ?>">
      <small class="form-text text-muted">This can be set to an environment variable. Learn more</small>
    </div>
    <hr class="break-line"></hr>
    <div class="form-group">
      <label class="heading" for="inputTransportType">Transport Type</label>
      <small class="form-text text-muted">How should Craft CMS send the emails?</small>
      <select name="email_type" class="form-control costum-select">
        <option value="0">- Select Type -</option>
        <option value="gmail">Gmail</option>
        <option value="smtp">SMTP</option>
        <option value="sendmail">Sendmail</option>
      </select>
    </div>
    <hr class="break-line"></hr>
    <div class="form-group">
      <button type="button" class="btn btn-outline-secondary btn-sm px-4">Test</button>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>