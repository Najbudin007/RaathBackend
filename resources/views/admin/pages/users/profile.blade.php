<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
</head>
<body>
  <div id="profile" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-md-12 text-center">
                <img id="profile" src="{{ asset('') }}" alt="{{ $user->name }}" height="200" width="200">
                <p>{{ $user->name }}</p>
                <form action="{{ url("/users/{$user->id}/password") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PATCH")
                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New Password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Re-enter password" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group">
                      <button type="submit">Update Password</button>
                    </div>
                </form>

                <form action="{{ url("/users/{$user->id}/profiles") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PATCH")
                    <div class="form-group">
                         <div class="custom-file">
                           <input id="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" name="image" placeholder="Upload Image" autocomplete="image">
                           <label class="custom-file-label" for="image">Choose Image</label>
                         </div>
                         @error('image')
                         <span class="err-form" role="alert">
                           <strong>{{ $message }}</strong>
                         </span>
                         @enderror
                     </div>
                    <div class="form-group">
                      <button type="submit">Update Profile Image</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
  <script>
    $(function() {
      $('#profile').on('show.bs.modal', function(event) {
      });

      $(".custom-file-input").on("change", function() {
        let validImageType = ['jpeg', 'jpg','png', 'bmp', 'gif', 'svg', 'webp'];
        let ext = $(this).val().split('.').pop();
        if(!validImageType.includes(ext)) {
          alert('Invalid Image');
          return;
        }
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);

        let image = new FileReader();
        image.onload = function(e) {
          $('#profile img').attr('src',e.target.result)
        }
        image.readAsDataURL(this.files[0]);
      });
    });
  </script>
</body>
</html>