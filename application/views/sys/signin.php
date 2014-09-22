<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <form role="form" method="post" action="/signin">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" name="username" placeholder="Enter username">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="remember"> Remember Me
          </label>
        </div>
        <button type="submit" class="btn btn-primary">Sign In & Play</button> <a href="/signup" class="btn btn-default">Sign Up For Free</a> <a href="/forgot" class="btn btn-default">Forgot Password</a>
      </form>
    </div>
  </div>
</div>