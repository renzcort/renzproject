<div class="middle-content mx-3 py-4 pr-5">
  <form class="form">
    <div class="form-group">
      <label class="heading" for="inputGroup">Group</label>
      <small class="form-text text-muted">Which group should this field be displayed in?</small>
      <select name="group" class="form-control costum-select">
        <option value="0">- Select Group -</option>
      </select>
    </div>
    <div class="form-group">
      <label class="heading" for="inputName">Name</label>
      <small class="form-text text-muted">What this field will be called in the CP.</small>
      <input type="text" name="name" class="form-control"  placeholder="name">
    </div>
    <div class="form-group">
      <label class="heading" for="inputHandle">Handle</label>
      <small class="form-text text-muted">How you’ll refer to this field in the templates.</small>
      <input type="text" name="handle" class="form-control"  placeholder="handle">
    </div>
    <div class="form-group">
      <label class="heading" for="inputInstruction">Instruction</label>
      <small class="form-text text-muted">Helper text to guide the author.</small>
      <textarea class="form-control"></textarea>
      <div class="form-check">
        <input type="checkbox" name="translateable" class="form-check-input">
        <label class="form-check-label" for="inputTranslateable">This field is translatable</label>
      </div>
    </div>
    <div class="form-group">
      <label class="heading" for="inputType">Field Type</label>
      <small class="form-text text-muted">What type of field is this?</small>
      <select name="type" class="form-control costum-select">
        <option value="0">- Select Type -</option>
      </select>
    </div>
    <div class="d-none plain-text">
      <div class="form-group">
        <label class="heading" for="inputPlaceholder">Placeholder Text</label>
        <small class="form-text text-muted">The text that will be shown if the field doesn’t have a value.</small>
        <input type="text" name="placeholder" class="form-control">
      </div>
      <div class="form-group">
        <label class="heading" for="inputMaxlength">Max Length</label>
        <small class="form-text text-muted">The maximum length of characters the field is allowed to have.</small>
        <input type="text" name="maxlength" class="form-control form-number">
      </div>
      <div class="form-group">
        <div class="form-check">
          <input type="checkbox" name="linebreak" class="form-check-input">
          <label class="form-check-label" for="inputAllowLineBreaks">Allow line breaks</label>
        </div>
      </div>
      <div class="form-group">
        <label class="heading" for="inputInitialRows">Initial Rows</label>
        <input type="text" name="maxlength" class="form-control form-number">
      </div>
    </div>
    <div class="d-none assets">
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
          <label class="form-check-label" for="restrictAssets">Restrict uploads to a single folder?</label>
        </div>
      </div>
      <div class="form-group">
        <label class="heading" for="inputSource">Sources</label>
        <small class="form-text text-muted">Which sources do you want to select assets from?</small>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="sources">
          <label class="form-check-label" for="defaultCheck1">All</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="sources">
          <label class="form-check-label" for="defaultCheck1">Products</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="sources">
          <label class="form-check-label" for="defaultCheck1">Images</label>
        </div>
      </div>
      <div class="form-group">
        <label class="heading" for="inputUploadLocation">Default Upload Location</label>
        <small class="form-text text-muted">Where should files be uploaded when they are dragged directly onto the field, or uploaded from the front end? Note that the subfolder path can contain variables like {slug} or {author.username}.</small>
        <div class="d-flex flex-row justify-content-between">
          <select name="sources" class="form-control costum-select">
            <option value="0">- Select Sources -</option>
          </select>
          <input type="text" name="sources" class="form-control flex-grow-1 ml-2">
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
          <label class="form-check-label" for="restrictAssets">Restrict allowed file types?</label>
        </div>
      </div>
      <div class="form-group">
        <label class="heading" for="inputLocale">Target Locale</label>
        <small class="form-text text-muted">Choose how the field should look for authors.</small>
        <select name="locale" class="form-control costum-select">
          <option value="0">- Select Locale -</option>
        </select>
      </div>
      <div class="form-group">
        <label class="heading" for="inputLimit">Limit</label>
        <small class="form-text text-muted">Limit the number of selectable assets.</small>
        <input type="text" name="limit" class="form-control form-number">
      </div>
      <div class="form-group">
        <label class="heading" for="inputMode">View Mode</label>
        <small class="form-text text-muted">Choose how the field should look for authors.</small>
        <select name="type" class="form-control costum-select">
          <option value="0">- Select Mode -</option>
        </select>
      </div>
      <div class="form-group">
        <label class="heading" for="inputSelectionLabel">Selection Label</label>
        <small class="form-text text-muted">Enter the text you want to appear on the assets selection input.</small>
        <input type="text" name="selectionLabel" class="form-control">
      </div>
    </div>
    <div class="d-none rich-text">
      <div class="form-group">
        <label class="heading" for="inputConfig">Config</label>
        <small class="form-text text-muted">You can save custom Redactor configs as .json files in craft/config/redactor/. View available settings.</small>
        <select name="config" class="form-control costum-select">
          <option value="0">- Select Config -</option>
        </select>
      </div>
      <div class="form-group">
        <label class="heading" for="inputSource">Available Asset Sources</label>
        <small class="form-text text-muted">The asset sources that should be available when selecting assets (if the selected config has an Image or File button).</small>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="sources">
          <label class="form-check-label" for="defaultCheck1">All</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="sources">
          <label class="form-check-label" for="defaultCheck1">Products</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="sources">
          <label class="form-check-label" for="defaultCheck1">Images</label>
        </div>
      </div>
      <div class="form-group">
        <label class="heading" for="inputTransforms">Available Image Transforms</label>
        <small class="form-text text-muted">The image transforms that should be available when selecting images (if the selected config has an Image button).</small>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="sources">
          <label class="form-check-label" for="defaultCheck1">All</label>
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="sources">
          <label class="form-check-label" for="defaultCheck1">Clean up HTML?</label>
        </div>
        <small class="form-text text-muted">Removes <span>’s, empty tags, and most style attributes on save.</small>
        </div>
        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" name="sources">
            <label class="form-check-label" for="defaultCheck1">Purify HTML?</label>
          </div>
          <small class="form-text text-muted">Removes any potentially-malicious code on save, by running the submitted data through HTML Purifier.</small>
        </div>
        <div class="form-group">
          <label class="heading" for="inputColumnType">Column Type</label>
          <small class="form-text text-muted">The underlying database column type to use when saving content.</small>
          <select name="columnType" class="form-control costum-select">
            <option value="0">- Select Column Type -</option>
          </select>
        </div>
      </div>
      <div class="d-none categories">
        <div class="form-group">
          <label class="heading" for="inputSource">Source</label>
          <small class="form-text text-muted">Which source do you want to select categories from?</small>
          <select name="Source" class="form-control costum-select">
            <option value="0">- Select Source -</option>
          </select>
        </div>
        <div class="form-group">
          <label class="heading" for="inputTargetLocale">Target Locale</label>
          <small class="form-text text-muted">Which Target Locale do you want to select categories from?</small>
          <select name="TargetLocale" class="form-control costum-select">
            <option value="0">- Select Source -</option>
          </select>
        </div>
        <div class="form-group">
          <label class="heading" for="inputLimit">Limit</label>
          <small class="form-text text-muted">Limit the number of selectable assets.</small>
          <input type="text" name="limit" class="form-control form-number">
        </div>
        <div class="form-group">
          <label class="heading" for="inputSelectionLabel">Selection Label</label>
          <small class="form-text text-muted">Enter the text you want to appear on the assets selection input.</small>
          <input type="text" name="selectionLabel" class="form-control">
        </div>
      </div>
      <div class="d-none checkboxes">
        <div class="form-group">
          <label class="heading" for="inputCheckbox">Checkbox Options</label>
          <small class="form-text text-muted">Define the available options.</small>
          <table class="table font-weight-light m-0">
            <thead>
              <tr>
                <th scope="col">Option Label</th>
                <th scope="col">Value</th>
                <th scope="col">Default?  </th>
                <th colspan="2" ></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Mark</td>
                <td>Otto</td>
                <td class="action"><input type="checkbox" name="checkboxes"></td>
                <td class="action">Otto</td>
                <td class="action">@mdo</td>
              </tr>
            </tbody>
          </table>
          <input type="button" class="btn btn-default btn btn-light btn-block" name="" value="+ Add an option">
        </div>
      </div>
    </div>
  </form>
</div>