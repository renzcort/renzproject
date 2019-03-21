<div class="tabs flex-grow-1">
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
            <small class="form-text text-muted">How you’ll refer to this site in the templates.</small>
            <input type="text" name="handle" class="form-control">
          </div>
        </form>
      </div>
      <div class="tab-pane fade" id="layout" role="tabpanel" aria-labelledby="layout-tab">...</div>
    </div>
  </div>
</div>