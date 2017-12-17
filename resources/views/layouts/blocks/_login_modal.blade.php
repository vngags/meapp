<!-- Modal -->
<div class="modal no-shadow" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content no-shadow">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div>
        
            <form id="modal-login" action="" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" required placeholder="Email">
                </div>

                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" required placeholder="Password">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">Login</button>
                </div>
            </form>
        </div>
      </div>      
    </div>
  </div>
</div>