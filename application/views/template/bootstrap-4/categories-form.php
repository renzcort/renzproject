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
    <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
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
        <div class="form-group">
          <div class="form-check">
            <input type="checkbox" name="categories" class="form-check-input">
            <label class="form-check-label" for="inputTranslateable">Categories in this group have their own URLs</label>
          </div>
        </div>
        <div class="form-group">
          <label class="heading" for="inputCategories">Category URL Formats</label>
          <small class="form-text text-muted">What the category URLs should look like. {slug} is required, but it can also include any category properties.</small>
          <table class="table">
            <thead>
              <th colspan="2">Top-Level Categories</th>
              <th>Nested Categories</th>
            </thead>
            <tbody>
              <tr>
                <td>id_id</td>
                <td><input type="text" name="" class="form-control"></td>
                <td><input type="text" name="" class="form-control" placeholder="{parent.uri}/{slug}"></td>
              </tr>
              <tr>
                <td>es_us</td>
                <td><input type="text" name="" class="form-control"></td>
                <td><input type="text" name="" class="form-control" placeholder="{parent.uri}/{slug}"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="form-group">
          <label class="heading" for="inputCategoryTemplate">Category Template</label>
          <small class="form-text text-muted">The template to use when a category’s URL is requested.</small>
          <input type="text" name="categoryTemplate" class="form-control">
        </div>
        <div class="form-group">
          <label class="heading" for="inputMaxlevel">Max Levels</label>
          <small class="form-text text-muted">The maximum number of levels this category group can have. Leave blank if you don’t care.</small>
          <input type="text" name="maxlevel" class="form-control form-number">
        </div>
      </form>
    </div>
    <div class="tab-pane fade show active" id="layout" role="tabpanel" aria-labelledby="layout-tab">
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