<div class="content-body flex-grow-1" id="section">
  <div class="section-entries-list" id="middle-content"
    data-table="<?php echo ($table ? $table : ''); ?>"
    data-action="<?php echo ($action ? $action : '');?>"
    data-section="<?php echo ($section_id ? $section_id : '');?>">
    <?php if ($record_all) {?>
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Handle</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
      <?php
        $i = 0;
        foreach ($record_all as $key) {
          ++$i;
          echo '
          <tr id="'.$i.'" data-id="'.$key->id.'" >
            <input type="hidden" name="id" value="'.$key->id.'">
            <td><a href="'.base_url($action.'/edit/'.$key->id).'">'.$key->name.'</a></td>
            <td>'.$key->handle.'</td>';
            if (($section->handle != $key->handle) && $total_rows > 1) {
              echo '
                <td scope="row" colspan="2">
                  <a href=""><i class="fas fa-arrows-alt"></i></a>
                  <a href="'.base_url($action.'/delete/'.$key->id).'"><i class="fas fa-minus-circle"></i></a>
                </td>';
            }
          echo '</tr>';
        } 
      ?>
      </tbody>
    </table>
    <h3><span id="sortable-9"></span></h3>
    <?php } else { ?>
    <p class="empty-data">Data is Empty</p>
    <?php } ?>
  </div>
</div>