
<!-- Modal -->
<div class="modal fade" id="groupsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Group <?php echo (isset($title) ? ucfirst($title) : ''); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open('admin/groups', ''); ?>
      <div class="modal-body">
          <input type="hidden" name="group_name" value="<?php echo (isset($group_name) ? $group_name : ''); ?>">
          <input type="hidden" name="table" value="<?php echo (isset($table) ? $table : ''); ?>">
          <div class="form-group">
            <label class="heading" for="inputNameGroup">What do you want to name the group?</label>
            <input type="text" name="name" class="form-control form-control-sm">
          </div>
          <div class="form-group">
            <label class="heading" for="inputDescGroup">Desctription</label>
            <textarea class="form-control form-control-sm" name="description"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="create">Save</button>
      </div>
    <? echo form_close(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="assetsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Assets</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <input type="file" name="assets" id="assets-modal-file" class="btn btn-primary mr-auto p-2 ">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="assets-modal-select" data-dismiss="modal">Select</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="categoriesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Categories</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="categories-modal-select" data-dismiss="modal">Select</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="entriesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Entries</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="entries-modal-select" data-dismiss="modal">Select</button>
      </div>
    </div>
  </div>
</div>