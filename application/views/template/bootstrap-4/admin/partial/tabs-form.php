<div class="form-tabs" id="layout">
  <h5 class="heading">Design Your Field Layout</h5>
  <div class="field-tabs d-flex flex-row flex-wrap">
    <div id="dialog" title="Tab data"></div>
    
  <?php if ($element) { ?>
    <?php foreach ($tabs_elements as $elm) { ?>
    <div class="field-group my-tabs" id="<?php echo $elm['id'] ?>" data-count="<?php echo $elm['count']; ?>">
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
  <div class="">
    <button type="button" class="btn btn-info" id="add_tab">+ New Tabs</button>
  </div>
  <hr class="break-line"></hr>
  <div class="field-column d-flex flex-row flex-wrap">
    <?php if ($fields_group): ?>
      <?php $i = 0; ?>
      <?php foreach ($fields_group as $key): ?>
      <div class="field-group">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
              <?php echo ucfirst($key->name); ?>
            </a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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