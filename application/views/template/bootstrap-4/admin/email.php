 <div class="middle-content flex-grow-1">
  <form class="form">
    <div class="form-group">
      <label class="heading required" for="inputEmail">System Email Address</label>
      <small class="form-text text-muted">The email address Craft CMS will use when sending email.</small>
      <input type="email" name="email" class="form-control">
      <small class="form-text text-muted">This can be set to an environment variable. Learn more</small>
    </div>
    <div class="form-group">
      <label class="heading required" for="inputSenderName">Sender Name</label>
      <small class="form-text text-muted">The “From” name Craft CMS will use when sending email.</small>
      <input type="text" name="senderName" class="form-control">
      <small class="form-text text-muted">This can be set to an environment variable. Learn more</small>
    </div>
    <hr class="break-line"></hr>
    <div class="form-group">
      <label class="heading" for="inputTransportType">Transport Type</label>
      <small class="form-text text-muted">How should Craft CMS send the emails?</small>
      <select name="emailType" class="form-control costum-select">
        <option value="0">- Select Group -</option>
      </select>
    </div>
    <hr class="break-line"></hr>
    <div class="form-group">
      <button type="button" class="btn btn-outline-secondary btn-sm px-4">Test</button>
    </div>
  </form>
</div>