<div class="middle-content flex-grow-1 mx-3 py-4 pr-5">
  <form class="form">
    <div class="form-group">
      <label class="heading" for="inputSystemName">System Name</label>
      <input type="text" name="systemName" class="form-control" placeholder="System Name">
      <small class="form-text text-muted">This can be set to an environment variable. Learn more</small>
    </div>
    <div class="form-group">
      <label class="heading" for="inputSystemStatus">System Status</label>
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitch1">
        <label class="custom-control-label" for="customSwitch1">Disabled</label>
      </div>
    </div>
    <div class="form-group">
      <label class="heading" for="inputTargetLocale">Target Locale</label>
      <small class="form-text text-muted">Which Target Locale do you want to select categories from?</small>
      <select name="TargetLocale" class="form-control costum-select">
        <option value="0">- Select Source -</option>
      </select>
    </div>
  </form>
</div>