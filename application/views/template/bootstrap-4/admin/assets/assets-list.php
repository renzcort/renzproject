<div class="content-body d-flex flex-row flex-grow-1 justify-content-start assets-list" id="assets">
  <div id="left-content">
    <?php $this->load->view('template/bootstrap-4/admin/partial/sidebar-groups'); ?>
  </div>
  <div id="right-content">
    <div class="right-content-body">
      <?php $this->load->view('template/bootstrap-4/admin/partial/right-content-filter'); ?>
      <?php if ($record_all): ?>
      <div class="right-content-table" id="content-table">
        <table class="table table-sm">
          <thead>
            <tr>
              <th style="width:5%" scope="row">#</th>
              <th scope="col">Title</th>
              <th scope="col">Post Date</th>
              <th style="width:10%" scope="col">File Size</th>
              <th style="width:20%" scope="col">File Modified Date</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php 
            foreach ($record_all as $key) {
              $handle     = $this->uri->segment(3);
              $filename   = explode('.', $key->file);
              $name       = current($filename);
              $thumb      = current($filename).'_thumb.'.end($filename);
              $file_thumb = base_url("{$key->path_thumb}/{$thumb}");
              $getSize    = get_headers($file_thumb, 1);
            ?>
            <tr>
              <th style="width:5%" scope="row"><?php echo ++$no; ?></th>
              <td><img src="<?php echo $file_thumb ?>" class="img-thumbnail" heigth="10" width="20"/>
              <?php echo ((strlen($name) <= 25) ? ucfirst($name) : substr(ucfirst($name), 0, 25)."..."); ?></a></td>
              <td><?php echo ((strlen($key->file) <= 25) ? $key->file : substr($key->file, 0, 25)."...".$key->ext) ?></td>
              <td style="width:10% "><?php echo $key->size; ?> kB</td>
              <td style="width:20% "><?php echo date("d/m/Y h:i A", strtotime($key->created_at)); ?></td>
              <td scope="row">
                <a href="<?php echo base_url("{$action}/{$handle}/delete/{$key->id}"); ?>"><i class="fas fa-minus-circle"></i></a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <p class="empty-data">Data is Empty</p>
      <?php endif ?>
    </div>
  </div>
</div>