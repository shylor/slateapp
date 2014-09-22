<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <form role="form" method="post" action="/reset/<?php echo $code ?>">
        <div class="form-group">
          <label for="password1">New Password</label>
          <input type="password" class="form-control" name="password1" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="password2">Retype New Password</label>
          <input type="password" class="form-control" name="password2" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
      </form>
    </div>
  </div>
</div>