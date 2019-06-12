  <div id="left-content" class="left-content overflow-auto">
    <div class="sidebar-content">
      <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start" id="sidebarGroups">
        <li class="nav-item">
          <a class="nav-link active" href="#" data-id="all">All Fields</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-id="default">Default</a>
        </li>
        <?php foreach ($assets as $key): ?>
          <li class="nav-item">
            <a class="nav-link" href="#" data-id="<?php echo $key->id; ?>"><?php echo ucfirst($key->name); ?></a>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
  </div>
  <div id="right-content" class="right-content ml-auto">
    <div class="d-flex flex-row justify-content-center align-content-center align-items-start mb-5">
      <input type="checkbox" name="checkall" class="align-self-center mr-2">
      <div class="input-group mr-2">
        <input type="text" class="form-control form-control-sm" aria-label="Text input with dropdown button">
      </div>
      <div class="dropdown">
        <a class="btn btn-outline-secondary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown link
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </div>
      <div class="btn-group ml-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
      </div>
    </div>
        <span id="uploaded_image"></span>
    <?php if ($record_all): ?>
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="row">#</th>
          <th scope="col">Title</th>
          <th scope="col">Post Date</th>
          <th scope="col">Expiry Date</th>
          <th scope="row"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
          <td>
            <a href=""><i class="fas fa-minus-circle"></i></a>
          </td>
        </tr>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
          <td>
            <a href=""><i class="fas fa-minus-circle"></i></a>
          </td>
        </tr>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
          <td>
            <a href=""><i class="fas fa-minus-circle"></i></a>
          </td>
        </tr>
      </tbody>
    </table>
    <?php else: ?>
    <p class="empty-data">Data is Empty</p>
    <?php endif ?>

  </div>