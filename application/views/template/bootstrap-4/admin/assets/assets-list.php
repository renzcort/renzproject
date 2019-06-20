  <div id="left-content" class="left-content overflow-auto">
    <div class="sidebar-content">
      <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start" id="sidebarGroups" 
        data-groups-name="<?php echo ($group_name ? $group_name : ''); ?>" 
        data-table="<?php echo ($table ? $table : ''); ?>" 
        data-action-name="<?php echo ($action ? $action : '');?>"
        data-element="<?php echo ($fields_element ? $fields_element : ''); ?>">
       <li class="nav-item">
          <a class="nav-link active" data-id="all" href="default">All Fields</a>
       </li>
        <?php 
          $i = 1; 
          foreach ($group as $key): 
        ?>
          <li class="nav-item">
            <a class="nav-link <?php echo (($i == 1) ? '' : ''); ?>" href="<?php echo $key->handle ?>" data-id="<?php echo $key->id; ?>"><?php echo ucfirst($key->name); ?></a>
          </li>
        <?php
          $i = ++$i; 
          endforeach 
        ?>
      </ul>
    </div>
  </div>
  <div id="right-content" class="right-content ml-auto">
    <div class="d-flex flex-row justify-content-center align-content-center align-items-start mb-3">
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
    <?php if ($record_all): ?>
    <div id="table-content">
      <table class="table table-sm">
        <thead>
          <tr>
            <th scope="row">#</th>
            <th scope="col">Title</th>
            <th scope="col">Post Date</th>
            <th scope="col">File Size</th>
            <th scope="col">File Modified Date</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($record_all as $key): 
          $filename   = explode('.', $key->file);
          $name       = current($filename);
          $thumb      = current($filename).'_thumb.'.end($filename);
          $file_thumb = base_url("{$key->path}/{$thumb}");
          $getSize    = get_headers($file_thumb, 1); 
        ?>
        <tr>
          <th scope="row"><?php echo ++$no; ?></th>
          <td><img src="<?php echo $file_thumb ?>" class="img-thumbnail" heigth="10" width="20"/><?php echo $name; ?></a></td>
          <td><?php echo ($key->file ? $key->file : ''); ?></td>
          <td><?php echo $key->size; ?> kB</td>
          <td><?php echo ($key->created_at ? $key->created_at : ''); ?></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    </div>
    <?php else: ?>
    <p class="empty-data">Data is Empty</p>
    <?php endif ?>

  </div>