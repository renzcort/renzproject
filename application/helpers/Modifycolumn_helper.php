<?php

    // if ($fields['type'] == 'VARCHAR') {
    //   $column = arraY(
    //     "fields_{$fields['handle']}" => array(
    //                                 'type' => 'VARCHAR',
    //                                 'constraint' => '255',
    //                                 'null'  =>  TRUE,
    //                                 'after' =>  'title',
    //                               ),
    //   );
    // } elseif ($fields['type'] == 'INT') {
    //   $column = arraY(
    //     "fields_{$fields['handle']}" => array(
    //                                 'type' => 'INT',
    //                                 'constraint' => '11',
    //                                 'null'  =>  TRUE,
    //                                 'after' =>  'title',
    //                               ),
    //   );
    // } elseif ($fields['type'] == 'TEXT') {
    //   $column = arraY(
    //     "fields_{$fields['handle']}" => array(
    //                                 'type' => 'TEXT',
    //                                 'null'  =>  TRUE,
    //                                 'after' =>  'title',
    //                               ),
    //   );
    // } elseif ($fields['type'] == 'DATE') {
    //   $column = arraY(
    //     "fields_{$fields['handle']}" => array(
    //                                 'type' => 'DATE',
    //                                 'after' =>  'title',
    //                               ),
    //   );
    // } elseif ($fields['type'] == 'DATETIME') {
    //   $column = arraY( 
    //     "fields_{$fields['handle']}" => array(
    //                                 'type' => 'DATETIME',
    //                                 'after' =>  'title',
    //                               ),
    //   );
    // }


  function modifyColumn($fields= '', $action= '', $table= '') {
    $CI =& get_instance();

    if ($fields['type'] == 'VARCHAR') {
      $constraint = '255';
      $null       =  TRUE;
    } elseif ($fields['type'] == 'INT') {
      $constraint = '11';
      $null       =  TRUE;
    } else {
      $constraint = '';
      $null = '';
    }

    $column = arraY( 
        "fields_{$fields['handle']}" => array(
                                    'type'       => $fields['type'],
                                    'constraint' => $constraint,
                                    'null'       => $null,
                                    'after'      => 'title',
                                  ),

    );

    $CI->load->model('admin/Content_m', 'content_m');
    if ($action == 'add') {
      $CI->content_m->add_column($column);
    
    } elseif ($action == 'modify') {
      $column = arraY( 
          "fields_{$fields['old_name']}" => array(
                                    'name'       => "fields_{$fields['handle']}",
                                    'type'       => $fields['type'],
                                    'constraint' => $constraint,
                                    'null'       => $null,
                                    'after'      => 'title',
                                  ),

      );
      $CI->content_m->modify_column($column);
    
    } elseif ($action == 'drop') {
      $column = "fields_{$fields['handle']}"; 
      $CI->content_m->drop_column($column);

    } elseif ($action == 'add-table') {
      $CI->content_m->add_column_table($table, $column);
    } elseif ($action == 'modify-table') {
      $column = arraY( 
          "fields_{$fields['old_name']}" => array(
                                    'name'       => "fields_{$fields['handle']}",
                                    'type'       => $fields['type'],
                                    'constraint' => $constraint,
                                    'null'       => $null,
                                    'after'      => 'title',
                                  ),

      );
      $CI->content_m->modify_column_table($table, $column);
    } elseif ($action == 'drop-table') {
      $column = "fields_{$fields['handle']}"; 
      $CI->content_m->drop_column_table($table, $column);
    }



  }

?>