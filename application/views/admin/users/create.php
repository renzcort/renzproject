<div class="row">
  <div class="col-sm-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo (isset($title) ? ucfirst($title).'&nbsp;'.$subheader : ucfirst($header).'&nbsp;'.$subheader); ?></h3>
      </div>
      <?php
        $attrb = array(
          'class' => 'form', 
        ); 
        echo form_open_multipart(base_url($action.'/create'), $attrb); 
      ?>
      <form method="post" action="admin/users/create" enctype="multipart/data"> 
      <div class="box-body">
        <div class="form-group">
          <label for="Inputusername">Username</label>
          <input type="text" class="form-control" name="username" value="<?php echo set_value('username'); ?>" placeholder="Enter Username">
        </div>
        <?php echo form_error('username'); ?>
        <div class="form-group">
          <label for="InputEmail">Email</label>
          <input type="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="Enter Email">
        </div>
        <?php echo form_error('email'); ?>
        <div class="form-group">
          <label for="InputPassword">Password</label>
          <input type="password" class="form-control" name="password" value="" placeholder="Enter Password">
        </div>
        <?php echo form_error('password'); ?>
        <div class="form-group">
          <label for="InputPassconf">Password Confirm</label>
          <input type="password" class="form-control" name="passconf" value="" placeholder="Enter Password Confrimation">
        </div>
        <?php echo form_error('passconf'); ?>
        <div class="form-group">
          <label for="InputFirstname">Firstname</label>
          <input type="text" class="form-control" name="firstname" value="<?php echo set_value('firstname'); ?>" placeholder="Enter Firstname">
        </div>
        <?php echo form_error('firstname'); ?>
        <div class="form-group">
          <label for="InputLastname">Lastname</label>
          <input type="text" class="form-control" name="lastname" value="<?php echo set_value('lastname'); ?>" placeholder="Enter Lastname">
        </div>
        <?php echo form_error('lastname'); ?>
        <div class="form-group">
          <label for="InputRole">Role</label>
          <select class="form-control" name="role">
            <option value="0">- Select Role -</option>
            <?php foreach ($role as $key) { ?>
              <option value="<?php echo $key->id; ?>"><?php echo $key->name; ?></option>
            <?php } ?>
          </select>
        </div>
        <?php echo form_error('role'); ?>
        <div class="form-group">
          <label for="inputGroup">Group</label>
          <ul>
          <?php foreach ($group as $key) { ?>
            <li><input type="checkbox" name="usergroups[]" value="<?php echo $key->id; ?>"> <?php echo $key->name; ?></li>
          <?php } ?>
          </ul>
        
        </div>
        <div class="form-group">
          <label for="InputPhoto">Photo</label>
          <input type="file" name="photo" class="form-control">
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="accept_terms"> I agree to the <a href="#">terms</a>
          </label>
        </div>
        <?php echo form_error('accept_terms'); ?>
        <div class="box-footer">
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm" name="create">Create</button>
          </div>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>