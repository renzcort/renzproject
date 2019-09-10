<div class="content-body d-flex flex-row flex-grow-1 justify-content-start categories-list" id="categories">
  <div id="left-content">
    <?php $this->load->view('template/bootstrap-4/admin/partial/sidebar-groups'); ?>
  </div>
  <div id="right-content">
    <div class="right-content-body">
      <?php $this->load->view('template/bootstrap-4/admin/partial/right-content-filter'); ?>
      <?php if ($record_all): ?>
      <div class="right-content-table table-responsive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl" 
        id="content-table">
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
              $handle = $this->uri->segment(3);
              foreach ($record_all as $key): 
            ?>
            <tr>
              <td scope="row" style="width: 5%;"><?php echo ++$no; ?></td>
              <td><a href="<?php echo base_url("{$action}/edit/$handle/{$key->id}"); ?>"><?php echo ucwords($key->title); ?></a></td>
              <td scope="row">
                <a href="<?php echo base_url("{$action}/delete/$handle/{$key->id}"); ?>"><i class="fas fa-minus-circle"></i></a>
              </td>
            </tr>
          <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <p class="empty-data">Data is Empty</p>
      <?php endif ?>
    </div>
  </div>
</div>