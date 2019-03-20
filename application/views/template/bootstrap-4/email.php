<div class="middle-content mx-3 py-4 pr-5">
  <form class="form">
    <div class="form-group">
      <label class="heading" for="inputEmail">System Email Address</label>
      <small class="form-text text-muted">The email address Craft CMS will use when sending email.</small>
      <input type="email" name="email" class="form-control">
      <small class="form-text text-muted">This can be set to an environment variable. Learn more</small>
    </div>
    <div class="form-group">
      <label class="heading" for="inputSenderName">Sender Name</label>
      <small class="form-text text-muted">The “From” name Craft CMS will use when sending email.</small>
      <input type="text" name="senderName" class="form-control">
      <small class="form-text text-muted">This can be set to an environment variable. Learn more</small>
    </div>
    <div class="form-group">
      <label class="heading" for="inputTransportType">Transport Type</label>
      <small class="form-text text-muted">How should Craft CMS send the emails?</small>
      <select name="emailType" class="form-control costum-select">
        <option value="0">- Select Group -</option>
      </select>
    </div>
  </form>
</div>