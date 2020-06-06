<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link 
    rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" 
    crossorigin="anonymous">
  <link 
    rel="stylesheet" 
    href="{{ url('css/login.css') }}">
  <link 
    rel="stylesheet" 
    href="{{ url('css/style.css') }}">
  <link 
    href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;600;700;800&display=swap" 
    rel="stylesheet">
  <title>Login</title>
</head>
<body>
  <div class="container-custom">
    <div class="row">
      <div class="col-6 left-side" id="left-side">
        <div class="left-side-content w-100">
          <img 
            src="{{ url('image/login/left_side_login_content.png') }}" 
            alt="left_side_login_content">
        </div>
      </div>
      <div class="col-6 right-side" id="right-side">
        <form action="" class="form">
          <h2 class="text-center font-weight-bold">Login</h2>
          <div class="form-group">
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              class="form-control"
              required>
          </div>
          <div class="form-group">
            <label for="email">Password</label>
            <input
              type="password" 
              id="password"
              name="password"
              class="form-control"
              required>
          </div>
          <button type="submit" class="btn btn-danger">Login</button>
          <p class="mt-5">Belum punya akun? <a href="/signup">Daftar disini</a></p>
        </form>
      </div>
    </div>
  </div>
  <script 
    src="https://code.jquery.com/jquery-3.5.1.slim.min.js" 
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" 
    crossorigin="anonymous">
  </script>
  <script 
    src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
    crossorigin="anonymous">
  </script>
  <script 
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" 
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" 
    crossorigin="anonymous">
  </script>
  <script 
    type="text/javascript"
    src= "{{ url('js/view/login.js') }}">
  </script>
</body>
</html>