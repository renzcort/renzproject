<div class="middle-content mx-3 py-4 pr-5">
  <form class="form">
    <div class="form-group">
      <label class="heading" for="inputGroup">Group</label>
      <small class="font-text text-muted">Which group should this site belong to?</small>
      <select name="group" class="form-control form-select">
        <option value="0">- Select Group -</option>
      </select>
    </div>
    <div class="form-group">
      <label class="heading" for="inputName">Name</label>
      <small class="form-text text-muted">What this site will be called in the CP.</small>
      <input type="text" name="name" class="form-control">
    </div>
    <div class="form-group">
      <label class="heading" for="inputHandle">Handle</label>
      <label class="form-text text-muted">How you’ll refer to this site in the templates.</label>
      <input type="text" name="handle" class="form-control">
    </div>
    <div class="form-group">
      <label class="heading" for="inputLanguange">Languange</label>
      <small class="form-text text-muted">The language content in this site will use.</small>
      <select name="languange" class="form-control form-select">
        <option value="0">- Select Languange -</option>
      </select>
      <small class="form-test text-muted">Enable the Intl extension or install additional locale data files for more language options.</small>
    </div>
    <div class="form-group">
      <label class="heading" for="inputPrimary">Make this the primary site?</label>
      <small class="form-text text-muted">The primary site will be loaded by default on the front end.</small>
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitch1">
        <label class="custom-control-label" for="customSwitch1">Disabled</label>
      </div>
    </div>
    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" name="translateable" class="form-check-input">
        <label class="form-check-label" for="inputTranslateable">This site has its own base URL</label>
      </div>
    </div>
    <div class="form-group">
      <label class="heading" for="inputBaseurl">Base URL</label>
      <small class="form-text text-muted">The base URL for the site.</small>
      <input type="text" name="baseURL" class="form-control" placeholder="@web/">
      <small class="form-text text-muted">The @web alias is not recommended if it is determined automatically.</small>
    </div>
  </form>
</div>