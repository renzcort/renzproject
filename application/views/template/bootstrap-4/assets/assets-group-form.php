<div class="tabs flex-grow-1 ">
  <ul class="nav nav-tabs d-flex flex-row flex-nowrap" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="true">Settings</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="layout-tab" data-toggle="tab" href="#layout" role="tab" aria-controls="layout" aria-selected="false">Field Layout</a>
    </li>
  </ul>
  <div class="middle-content">
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
          <div id="base-url" class="form-group d-none">
            <label class="heading" for="inputBaseURL">Base URL</label>
            <label class="form-text text-muted">The base URL to the assets in this volume. An absolute URL (“http://example.com/path/to/folder”) or protocol-relative URL (“//example.com/path/to/folder”) is recommended. It can begin with an alias, such as @web.</label>
            <input type="text" name="base-url" class="form-control">
          </div>
          <hr class="break-line">
          <div class="form-group">
            <label class="heading" for="inputVolumeType">Volume Type</label>
            <small class="form-text text-muted">What type of section is this?</small>
            <select name="volumeType" class="form-control costum-select">
              <option value="0">- Select Type -</option>
            </select>
          </div>
          <div class="form-group">
            <label class="heading" for="inputFileSystemPath">File System Path</label>
            <small class="form-text text-muted">The path to the volume’s directory on the file system.</small>
            <input type="text" name="handle" class="form-control" placeholder="/path/folder">
          </div>
        </form>
      </div>
      <div class="tab-pane fade" id="layout" role="tabpanel" aria-labelledby="layout-tab">
        <div class="form-tabs" id="layout">
          <h5 class="heading">Design Your Field Layout</h5>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <ul id="sortable1" class="text-center list-group connectedSortable">
                <li class="list-group-item active">Lion</li>
                <li class="list-group-item">Dog</li>
                <li class="list-group-item">Cat</li>
                <li class="list-group-item">Tiger</li>
              </ul>
            </div>
          </div>
          <div class="btn-add">
            <a href="" class="btn btn-info">+ New Tabs</a>
          </div>
          <hr class="break-line"></hr>
          <div class="my-5 d-flex flex-row flex-wrap">
            <div class="field-group">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <ul id="sortable1" class="text-center list-group connectedSortable">
                    <li class="list-group-item active">Lion</li>
                    <li class="list-group-item">Dog</li>
                    <li class="list-group-item">Cat</li>
                    <li class="list-group-item">Tiger</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="field-group">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <ul id="sortable1" class="text-center list-group connectedSortable">
                    <li class="list-group-item active">Lion</li>
                    <li class="list-group-item">Dog</li>
                    <li class="list-group-item">Cat</li>
                    <li class="list-group-item">Tiger</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="field-group">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <ul id="sortable1" class="text-center list-group connectedSortable">
                    <li class="list-group-item active">Lion</li>
                    <li class="list-group-item">Dog</li>
                    <li class="list-group-item">Cat</li>
                    <li class="list-group-item">Tiger</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="field-group">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <ul id="sortable1" class="text-center list-group connectedSortable">
                    <li class="list-group-item active">Lion</li>
                    <li class="list-group-item">Dog</li>
                    <li class="list-group-item">Cat</li>
                    <li class="list-group-item">Tiger</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="field-group">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <ul id="sortable1" class="text-center list-group connectedSortable">
                    <li class="list-group-item active">Lion</li>
                    <li class="list-group-item">Dog</li>
                    <li class="list-group-item">Cat</li>
                    <li class="list-group-item">Tiger</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>