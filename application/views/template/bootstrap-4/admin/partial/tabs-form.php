<div class="fields-layout" id="tabs-forms">
  <h5 class="heading">Design Your Field Layout</h5>
  <?php if (!in_array($table, array('assets'))) { ?>
    <div class="d-flex flex-row flex-wrap" id="fields-tabs-group">
      <div id="dialog" title="Tab data"></div>
      <?php if ($element) { ?>
        <?php foreach ($tabs_elements as $elm) { ?>
        <div class="fields-group my-tabs" id="<?php echo $elm['id'] ?>" data-count="<?php echo $elm['count']; ?>">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" data-tabs-title= "<?php echo $elm['title']; ?>">
              <a class="nav-link active <?php echo $elm['id']; ?>" data-toggle="tab" href="#<?php echo $elm['id'] ?>" role="tab" 
                aria-controls="<?php echo $elm['id']; ?>" aria-selected="true"><?php echo $elm['title']; ?>
              <span class="ui-icon ui-icon-close" role="presentation">Remove Tab</span>
              <span class="ui-icon ui-icon-pencil" role="presentation">Edit Tab</span></a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="tabs-1">
              <ul id="sortable-in" class="sortable text-center list-group connectedSortable">
                <?php 
                  foreach ($elm['fields'] as $val) {
                    foreach ($fields as $key) {
                      if ($val == $key->id) {
                        echo '<li class="list-group-item fields-list" data-fieldsId="'.$key->id.'">'.$key->name.'</li>';
                      }
                    }
                  }
                ?> 
              </ul>
            </div>
          </div>
        </div>
        <?php } ?>
      <?php } ?>        
    </div>
    <div class="tabs-add-group text-left">
      <button type="button" class="btn btn-info" id="add_tab">+ New Tabs</button>
    </div>
  <?php } else { ?>
  <div class="fields-group my-tabs" id="tabs-1" data-count="1">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item" data-tabs-title="tab-title">
        <a href="#tabs-1" class="nav-link active tabs-1" data-toggle="tab" role="tab"
          aria-controls="tabs-1" aria-selected="true">Settings
          <span class="ui-icon ui-icon-close" role="presentation">Remove Tab</span>
          <span class="ui-icon ui-icon-pencil" role="presentation">Edit Tab</span>
        </a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
        <ul id="sortable-in" class="sortable text-center list-group connectedSortable ui-sortable">
          <?php 
            if ($element) {
              foreach ($tabs_elements as $elm) {
                foreach ($elm['fields'] as $val) {
                  foreach ($fields as $key) {
                    if ($val == $key->id) {
                      echo '<li class="list-group-item fields-list" data-fieldsId="'.$key->id.'">'.$key->name.'</li>';
                    }
                  }
                }
              }
            } 
          ?>
        </ul>
      </div>
    </div>
  </div
  <?php } ?>
  <hr class="break-line"></hr>
  <div class="d-flex flex-row flex-wrap" id="fields-tabs-exist">
    <?php if ($fields_group): ?>
      <?php $i = 0; ?>
      <?php foreach ($fields_group as $key): ?>
      <div class="fields-group">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="tabs-<?php echo $key->id ?>-tab" data-toggle="tab" href="#tabs-<?php echo $key->id ?>" role="tab" aria-controls="tabs-<?php echo $key->id ?>" aria-selected="true">
              <?php echo ucfirst($key->name); ?>
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tabs-<?php echo $key->id ?>" role="tabpanel" aria-labelledby="tabs-<?php echo $key->id ?>-tab">
            <ul class="sortable text-center list-group connectedSortable">
            <?php if ($fields): ?>
              <?php foreach ($fields as $value): ?>
                <?php if ($value->group_id == $key->id): ?>
                  <?php if (!in_array($value->id, $elementFields)): ?>
                    <li class="list-group-item fields-list" data-fieldsId='<?php echo $value->id; ?>'><?php echo $value->name; ?></li>
                  <?php endif ?>
                <?php endif ?>
              <?php endforeach ?>
            <?php endif ?>
            </ul>
          </div>
        </div>
      </div>
      <?php endforeach ?>
    <?php endif ?>
  </div>
</div>
