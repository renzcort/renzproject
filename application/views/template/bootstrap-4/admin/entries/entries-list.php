<div id="left-content" class="left-content overflow-hidden">
  <div class="sidebar-content">
    <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start" id="sidebarGroups" 
      data-table="<?php echo ($table ? $table : ''); ?>" 
      data-action-name="<?php echo ($action ? $action : '');?>">
     <li class="nav-item">
        <a class="nav-link <?php echo (($this->uri->segment(3) == 'all') ? 'active' : '') ?>" data-id="all" href="all">All Fields</a>
     </li>

      <?php 
        if ($section) {
          echo '
            <li class="nav-item disabled">SITE PAGES</li>
           <li class="nav-item">
              <a class="nav-link '.(($this->uri->segment(3) == 'singles') ? 'active' : '').'" data-id="singles" href="singles">Singles</a>
           </li>';
          echo '<li class="nav-item disabled">CHANNEL</li>';
          foreach ($section as $key) {
            if ($key->type_id == 6) {
              echo '<li class="nav-item">
                      <a class="nav-link '.(($this->uri->segment(3) == $key->handle) ? 'active' : '').'" 
                      href="'.$key->handle.'" 
                      data-id="'.$key->id.'">
                      '.ucfirst($key->name).'</a>
                    </li>';
            }
          } 
        } 
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
          <th scope="row" style="width: 5%;">#</th>
          <th scope="col">Title</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php 
          foreach ($record_all as $key):
            $handle = (($this->uri->segment(3) != 'singles') ? $this->uri->segment(3) : $key->handle ); 
        ?>
        <tr>
          <td scope="row" style="width: 5%;"><?php echo ++$no; ?></td>
          <td><a href="<?php echo base_url("{$action}/{$handle}/edit/{$key->id}"); ?>"><?php echo $key->title; ?></a></td>
          <?php 
            if ($this->uri->segment(3) != 'singles') { 
              echo '
              <td scope="row">
                <a href="'.base_url("{$action}/{$handle}/delete/{$key->id}").'"><i class="fas fa-minus-circle"></i></a>
              </td>';
            } 
          ?>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <p class="empty-data">Data is Empty</p>
  <?php endif ?>
</div>