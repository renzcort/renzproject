<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/template/bootstrap-4/') ?>css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <title>Hello, world!</title>
    <style type="text/css">
    </style>
  </head>
  <body>
    <?php $this->load->view('template/bootstrap-4/partial/nav'); ?>
    
    <!-- Field List -->
    <!-- <div class="wraper">
      <div class="">
        <div class="body d-flex flex-row justify-content-between">
          <div class="left-bar">
            <div class="sidebar my-5 py-4">
              <div class="user-bar mx-2 d-flex flex-row justify-content-start align-content-start align-items-center">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
                <div class="info pl-2">
                  <p>Admin</p>
                  <p>online</p>
                </div>
              </div>
              <div class="menu my-5">
                <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="right-bar ml-auto mt-4 mb-3 pl-0 pt-4">
            <div class="main py-1 my-1">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Library</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
              </nav>
              <div class="px-3 py-3 my-2 d-flex flex-row justify-content-between align-content-between">
                <h4 class="font-weight-light">Header</h4>
                <button class="btn btn-danger btn-sm mx-3">+ New Field</button>
              </div>
              <div class="content d-flex flex-row justify-content-start">
                <div id="left-content" class="left-content py-2 px-2 overflow-auto">
                  <div class="sidebar-content">
                    <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
                      <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div id="right-content" class="right-content ml-auto pl-3">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">© 2017-2019 Company Name</p>
                <ul class="list-inline">
                  <li class="list-inline-item"><a href="#">Privacy</a></li>
                  <li class="list-inline-item"><a href="#">Terms</a></li>
                  <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- end Field -->
    
    <!-- Field Add -->
    <!-- <div class="wraper">
      <div class="">
        <div class="body d-flex flex-row justify-content-between">
          <div class="left-bar">
            <div class="sidebar my-5 py-4">
              <div class="user-bar mx-2 d-flex flex-row justify-content-start align-content-start align-items-center">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
                <div class="info pl-2">
                  <p>Admin</p>
                  <p>online</p>
                </div>
              </div>
              <div class="menu my-5">
                <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="right-bar ml-auto mt-4 mb-3 pl-0 pt-4">
            <div class="main container">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Library</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
              </nav>
              <div class="px-3 py-3 my-2 d-flex flex-row justify-content-between align-content-between">
                <h4 class="title">Header</h4>
                <button class="btn btn-danger btn-sm mx-3">+ New Field</button>
              </div>
              <div class="content">
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
                  </form>
                </div>
              </div>
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">© 2017-2019 Company Name</p>
                <ul class="list-inline">
                  <li class="list-inline-item"><a href="#">Privacy</a></li>
                  <li class="list-inline-item"><a href="#">Terms</a></li>
                  <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->  
    <!-- End Field -->

    <!-- Settings -->
    <!-- <div class="wraper">
      <div class="">
        <div class="body d-flex flex-row justify-content-between">
          <div class="left-bar">
            <div class="sidebar my-5 py-4">
              <div class="user-bar mx-2 d-flex flex-row justify-content-start align-content-start align-items-center">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
                <div class="info pl-2">
                  <p>Admin</p>
                  <p>online</p>
                </div>
              </div>
              <div class="menu my-5">
                <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="right-bar ml-auto mt-4 mb-3 pl-0 pt-4">
            <div class="main container">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Library</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
              </nav>
              <div class="px-3 py-2 my-2 d-flex flex-row justify-content-between align-content-center align-items-center">
                <h4 class="title">Header</h4>
                <button class="btn btn-danger btn-sm mx-3">+ New Field</button>
              </div>
              <div class="content">
                <div class="middle-content mx-3 py-4 pr-5">
                  <h5 class="heading py-2">System</h5>
                  <ul class="d-flex flex-row mb-4 pb-4 border-bottom list-unstyled text-center">
                    <li class="px-3 py-1"><i class="fas fa-sliders-h"></i>General</li>
                    <li class="px-3 py-1"><i class="far fa-route"></i>Routes</li>
                    <li class="px-3 py-1"><i class="fas fa-users-cog"></i>Users</li>
                    <li class="px-3 py-1"><i class="fas fa-envelope-open"></i>Email</li>
                    <li class="px-3 py-1"><i class="fas fa-plug"></i>Plugins</li>
                  </ul>
                  <h5 class="heading py-2">Content</h5>
                  <ul class="d-flex flex-row mb-4 pb-4 border-bottom list-unstyled">
                    <li class="px-3 py-1"><i class="far fa-file"></i>Fields</li>
                    <li class="px-3 py-1"><i class="fas fa-copy"></i>Sections</li>
                    <li class="px-3 py-1"><i class="far fa-images"></i>Assets</li>
                    <li class="px-3 py-1"><i class="fas fa-globe"></i>Globals</li>
                    <li class="px-3 py-1"><i class="fas fa-align-left"></i>Categories</li>
                    <li class="px-3 py-1"><i class="fas fa-tags"></i>Tags</li>
                    <li class="px-3 py-1"><i class="fas fa-comments"></i>Locales</li>
                  </ul>
                </div>
              </div>
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">© 2017-2019 Company Name</p>
                <ul class="list-inline">
                  <li class="list-inline-item"><a href="#">Privacy</a></li>
                  <li class="list-inline-item"><a href="#">Terms</a></li>
                  <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- end Settings -->
    
    <!-- General -->
    <!-- <div class="wraper">
      <div class="">
        <div class="body d-flex flex-row justify-content-between">
          <div class="left-bar">
            <div class="sidebar my-5 py-4">
              <div class="user-bar mx-2 d-flex flex-row justify-content-start align-content-start align-items-center">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
                <div class="info pl-2">
                  <p>Admin</p>
                  <p>online</p>
                </div>
              </div>
              <div class="menu my-5">
                <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="right-bar ml-auto mt-4 mb-3 pl-0 pt-4">
            <div class="main container">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Library</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
              </nav>
              <div class="px-3 py-2 my-2 d-flex flex-row justify-content-between align-content-center align-items-center">
                <h4 class="title">Header</h4>
                <button class="btn btn-danger btn-sm mx-3">+ New Field</button>
              </div>
              <div class="content">
                <div class="middle-content mx-3 py-4 pr-5">
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
                      <label class="heading" for="inputTimezone">Timezone</label>
                      <select name="timezone" class="form-control costum-select">
                        <option value="0">- Select Timezone -</option>
                      </select>
                    </div>
                  </form>
                </div>
              </div>
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">© 2017-2019 Company Name</p>
                <ul class="list-inline">
                  <li class="list-inline-item"><a href="#">Privacy</a></li>
                  <li class="list-inline-item"><a href="#">Terms</a></li>
                  <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- End General -->
    
    <!-- Sites -->
    <!-- <div class="wraper">
      <div class="">
        <div class="body d-flex flex-row justify-content-between">
          <div class="left-bar">
            <div class="sidebar my-5 py-4">
              <div class="user-bar mx-2 d-flex flex-row justify-content-start align-content-start align-items-center">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
                <div class="info pl-2">
                  <p>Admin</p>
                  <p>online</p>
                </div>
              </div>
              <div class="menu my-5">
                <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="right-bar ml-auto mt-4 mb-3 pl-0 pt-4">
            <div class="main container">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Library</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
              </nav>
              <div class="px-3 py-2 my-2 d-flex flex-row justify-content-between align-content-center align-items-center">
                <h4 class="title">Header</h4>
                <button class="btn btn-danger btn-sm mx-3">+ New Field</button>
              </div>
              <div class="content">
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
              </div>
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">© 2017-2019 Company Name</p>
                <ul class="list-inline">
                  <li class="list-inline-item"><a href="#">Privacy</a></li>
                  <li class="list-inline-item"><a href="#">Terms</a></li>
                  <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- ENd Sites -->
    
    <!-- Email -->
    <!-- <div class="wraper">
      <div class="">
        <div class="body d-flex flex-row justify-content-between">
          <div class="left-bar">
            <div class="sidebar my-5 py-4">
              <div class="user-bar mx-2 d-flex flex-row justify-content-start align-content-start align-items-center">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
                <div class="info pl-2">
                  <p>Admin</p>
                  <p>online</p>
                </div>
              </div>
              <div class="menu my-5">
                <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="right-bar ml-auto mt-4 mb-3 pl-0 pt-4">
            <div class="main container">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Library</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
              </nav>
              <div class="px-3 py-2 my-2 d-flex flex-row justify-content-between align-content-center align-items-center">
                <h4 class="title">Header</h4>
                <button class="btn btn-danger btn-sm mx-3">+ New Field</button>
              </div>
              <div class="content">
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
              </div>
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">© 2017-2019 Company Name</p>
                <ul class="list-inline">
                  <li class="list-inline-item"><a href="#">Privacy</a></li>
                  <li class="list-inline-item"><a href="#">Terms</a></li>
                  <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- ENd Email -->

    <!-- Section Add -->
    <!-- <div class="wraper">
      <div class="">
        <div class="body d-flex flex-row justify-content-between">
          <div class="left-bar">
            <div class="sidebar my-5 py-4">
              <div class="user-bar mx-2 d-flex flex-row justify-content-start align-content-start align-items-center">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
                <div class="info pl-2">
                  <p>Admin</p>
                  <p>online</p>
                </div>
              </div>
              <div class="menu my-5">
                <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="right-bar ml-auto mt-4 mb-3 pl-0 pt-4">
            <div class="main container">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Library</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
              </nav>
              <div class="px-3 py-2 my-2 d-flex flex-row justify-content-between align-content-center align-items-center">
                <h4 class="title">Header</h4>
                <button class="btn btn-danger btn-sm mx-3">+ New Field</button>
              </div>
              <div class="content">
                <div class="middle-content mx-3 py-4 pr-5">
                  <form class="form">
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
                      <div class="form-check">
                        <input type="checkbox" name="translateable" class="form-check-input">
                        <label class="form-check-label" for="inputTranslateable">Enable versioning for entries in this section?</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="heading" for="inputSectionType">Section Type</label>
                      <small class="form-text text-muted">What type of section is this?</small>
                      <select name="sectionType" class="form-control costum-select">
                        <option value="0">- Select Type -</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label class="heading" for="inputSiteSettings">Site Settings</label>
                      <label class="form-text text-muted">Choose which sites this section should be available in, and configure the site-specific settings.</label>
                      <table class="table table-bordered text-center">
                        <thead class="thead-dark">
                          <th>Site</th>
                          <th>Entry URI Format</th>
                          <th>Template</th>
                          <th>Default Status</th>
                        </thead>
                        <tbody>
                          <tr class="start">
                            <td class="first py-0">Craftcms</td>
                            <td class="p-0"><input type="text" name="" class="form-control"></td>
                            <td class="p-0"><input type="text" name="" class="form-control"></td>
                            <td class="py-0">
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1">Disabled</label>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </form>
                </div>
              </div>
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">© 2017-2019 Company Name</p>
                <ul class="list-inline">
                  <li class="list-inline-item"><a href="#">Privacy</a></li>
                  <li class="list-inline-item"><a href="#">Terms</a></li>
                  <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- ENd Section -->

    <!-- assets add -->
    <!-- <div class="wraper">
      <div class="">
        <div class="body d-flex flex-row justify-content-between">
          <div class="left-bar">
            <div class="sidebar my-5 py-4">
              <div class="user-bar mx-2 d-flex flex-row justify-content-start align-content-start align-items-center">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
                <div class="info pl-2">
                  <p>Admin</p>
                  <p>online</p>
                </div>
              </div>
              <div class="menu my-5">
                <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="right-bar ml-auto mt-4 mb-3 pl-0 pt-4">
            <div class="main container">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Library</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
              </nav>
              <div class="px-3 py-2 my-2 d-flex flex-row justify-content-between align-content-center align-items-center">
                <h4 class="title">Header</h4>
                <button class="btn btn-danger btn-sm mx-3">+ New Field</button>
              </div>
              <div class="content tabs">
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
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">© 2017-2019 Company Name</p>
                <ul class="list-inline">
                  <li class="list-inline-item"><a href="#">Privacy</a></li>
                  <li class="list-inline-item"><a href="#">Terms</a></li>
                  <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- end assets add -->

    <!-- Global Add -->
    <!-- <div class="wraper">
      <div class="">
        <div class="body d-flex flex-row justify-content-between">
          <div class="left-bar">
            <div class="sidebar my-5 py-4">
              <div class="user-bar mx-2 d-flex flex-row justify-content-start align-content-start align-items-center">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
                <div class="info pl-2">
                  <p>Admin</p>
                  <p>online</p>
                </div>
              </div>
              <div class="menu my-5">
                <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="right-bar ml-auto mt-4 mb-3 pl-0 pt-4">
            <div class="main container">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Library</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
              </nav>
              <div class="px-3 py-2 my-2 d-flex flex-row justify-content-between align-content-center align-items-center">
                <h4 class="title">Header</h4>
                <button class="btn btn-danger btn-sm mx-3">+ New Field</button>
              </div>
              <div class="content tabs">
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
                      </form>
                    </div>
                    <div class="tab-pane fade" id="layout" role="tabpanel" aria-labelledby="layout-tab">...</div>
                  </div>
                </div>
              </div>
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">© 2017-2019 Company Name</p>
                <ul class="list-inline">
                  <li class="list-inline-item"><a href="#">Privacy</a></li>
                  <li class="list-inline-item"><a href="#">Terms</a></li>
                  <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- end Global Add-->

    <div class="wraper">
      <div class="">
        <div class="body d-flex flex-row justify-content-between align-content-start align-items-start">
          <div class="left-bar">
            <?php $this->load->view('template/bootstrap-4/partial/sidebar'); ?>
          </div>
          <div class="right-bar ml-auto mt-4 mb-3 pl-0 pt-4">
            <div class="main container">
              <?php $this->load->view('template/bootstrap-4/partial/header'); ?>
              <div class="content">
                <div class="d-flex flex-row justify-content-start">
                  <?php $this->load->view($content); ?>
                </div>
              </div>
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <?php $this->load->view('template/bootstrap-4/partial/footer'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>




<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- end Jquery -->
<script type="text/javascript">
  $(document).ready(function(){
    $("#sortable1, #sortable2").sortable({
      connectWith: ".connectedSortable"
    });
  })

  window.onscroll = function() {myFunction()};
  var leftbar = document.getElementById('left-content');
  var leftbarTop = leftbar.offsetTop;
  var leftbarButton = leftbar.offsetHeight;
  var rightbar = document.getElementById('right-content');
  var rightbarTop = rightbar.offsetHeight;
  
  function myFunction() {
    if (window.pageYOffset >= leftbarTop && window.pageYOffset <= leftbarButton) {
      leftbar.classList.add("fixed-bar")
    } else {
      leftbar.classList.remove("fixed-bar");
    }
  }
</script>
</body>
</html>