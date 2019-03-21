<div class="tabs flex-grow-1 ">
  <ul class="nav nav-tabs d-flex flex-row flex-nowrap" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="true">Settings</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="layout-tab" data-toggle="tab" href="#layout" role="tab" aria-controls="layout" aria-selected="false">Field Layout</a>
    </li>
  </ul>
  <div class="middle-content mx-3 py-4 pr-5">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        <form class="form">
          <div class="form-group">
            <label class="heading required" for="inputName">Name</label>
            <small class="form-text text-muted">What this site will be called in the CP.</small>
            <input type="text" name="name" class="form-control">
          </div>
          <div class="form-group">
            <label class="heading" for="inputHandle">Handle</label>
            <label class="form-text text-muted">How you’ll refer to this site in the templates.</label>
            <input type="text" name="handle" class="form-control">
          </div>
          <div class="form-group">
            <label class="heading" for="inputAssets">Assets in this volume have public URLs</label>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitch1">
              <label class="custom-control-label" for="customSwitch1">Disabled</label>
            </div>
          </div>
          <div class="form-group">
            <label class="heading" for="inputVolumeType">Volume Type</label>
            <small class="form-text text-muted">What type of section is this?</small>
            <select name="volumeType" class="form-control costum-select">
              <option value="0">- Select Type -</option>
            </select>
          </div>
          <div class="form-group">
            <label class="heading" for="inputFileSystemPath">File System Path</label>
            <label class="form-text text-muted">The path to the volume’s directory on the file system.</label>
            <input type="text" name="handle" class="form-control" placeholder="/path/folder">
            <label class="form-text text-muted">This can be set to an environment variable, or begin with an alias. Learn more</label>
          </div>
        </form>
      </div>
      <div class="tab-pane fade" id="layout" role="tabpanel" aria-labelledby="layout-tab">...</div>
    </div>
  </div>
</div>