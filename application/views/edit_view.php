<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v3.8.5">
  <title>Dashboard Template · Bootstrap</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="<?= base_url() ?>vendor/dist/css/dashboard.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?= base_url() ?>main/index"><?= $this->session->userdata('username') ?></a>
    <input name="search_text" id="search_text" class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="<?= base_url() ?>main/logout">Sign out</a>
      </li>
    </ul>
  </nav>
  <div class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-5">
    <div id="result"></div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url() ?>main/index">
                <span data-feather="user"></span>
                Danh Sách User
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url() ?>main/register">
                <span data-feather="user"></span>
                Thêm User
              </a>
            </li>
          </ul>

          
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">User: <?= $user[0]->username ?></h1>
        </div>

        <h2><?= $title ?></h2>
        <div class="row">
          <div class="col-sm-6 offset-3"> 
              <form action="<?= base_url() ?>main/update_validation" method="POST">
                <?php foreach ($user as $row): ?>
              <div class="form-group">
                    <label>Username: </label>
                    <input type="text" name="username" id="username" value="<?= $row->username ?>" class="form-control">
                    <span class="text-danger"><?= form_error("username") ?></span>
                  </div>
                  <div class="form-group">
                    <label>Password: </label>
                    <input type="password" name="password" id="password" value="<?= $row->password ?>" class="form-control">
                    <span class="text-danger"><?= form_error("password") ?></span>
                  </div>
                  <div class="form-group">
                    <input type="hidden" name="hidden_id" value="<?= $row->id ?>">
                    <input type="submit" name="update" value="Cập Nhật" class="btn btn-primary">
                    <a href="<?= base_url() ?>main/userDetails/<?= $row->id ?>" class="float-right">Thông tin cá nhân</a>
                  </div>
                  <?php endforeach ?>
                </div>
              </form>
          </div>
      </main>
    </div>
  </div>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>vendor/dist/js/myscript.js"></script>
</body>
</html>
