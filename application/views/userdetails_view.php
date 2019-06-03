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
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="<?= base_url() ?>main/logout">Sign out</a>
      </li>
    </ul>
  </nav>

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
        	  <div class="col-sm-12">
              <form action="<?= base_url() ?>main/userDetails_validation" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="hidden_idUser" value="<?= $id_user ?>" multiple="multiple">
              <div class="row">
                <div class="col-sm-3">
                  <?php if (isset($userDetails) && count($userDetails) != 0 && $userDetails[0]->image!=''): ?>
                    <img src="<?= base_url() ?>uploads/files/<?= $userDetails[0]->image ?>" style="width: 200px; height: 200px;">
                    <input type="hidden" name="old_file_name" value="<?= $userDetails[0]->image ?>">
                    <input type="file" name="upload_data" class="form-control">
                  <?php else: ?>
                    <img src="<?= base_url() ?>vendor/images/noimage.png" style="width: 200px; height: 200px;">
                    <input type="file" name="upload_data" class="form-control">
                  <?php endif ?>
                  <span class="text-danger"><?php echo $error ?></span>
                </div>
                <div class="col-sm-6 offset-2">
                  <?= $this->session->flashdata('success_userDetails'); ?>
                  <?php if (isset($userDetails) && count($userDetails) != 0): ?>
                    <?php foreach ($userDetails as $row_ud): ?>
                        <div class="form-group">
                          <label>Level: </label>
                          <select class="form-control" id="level" name="level">
                            <option value="0">--Vui lòng chọn level--</option>
                            <?php foreach ($level as $lv): ?>
                              <?php if ($lv->id == $row_ud->id_level): ?>
                                <option value="<?= $lv->id ?>" selected><?= $lv->name ?></option>
                                <?php else: ?>
                                  <option value="<?= $lv->id ?>"><?= $lv->name ?></option>
                                <?php endif ?>
                              <?php endforeach ?>
                            </select>
                            <span class="text-danger"><?= form_error('level') ?></span>
                        </div>
                        <div class="form-group">
                          <label>First name: </label>
                          <input type="text" name="fname" class="form-control" value="<?= set_value('fname',$row_ud->first_name) ?>">
                          <span class="text-danger"><?= form_error('fname') ?></span>
                        </div>
                        <div class="form-group">
                          <label>Last name: </label>
                          <input type="text" name="lname" class="form-control" value="<?= set_value('lname',$row_ud->last_name) ?>">
                          <span class="text-danger"><?= form_error('lname') ?></span>
                        </div>
                        <div class="form-group">
                          <label>Email: </label>
                          <input type="text" name="email" class="form-control" value="<?= set_value('email',$row_ud->email) ?>">
                          <span class="text-danger"><?= form_error('email') ?></span>
                        </div>
                        <div class="form-group">
                          <label>Address: </label>
                          <input type="text" name="address" class="form-control" value="<?= set_value('address',$row_ud->address) ?>">
                          <span class="text-danger"><?= form_error('address') ?></span>
                        </div>
                        <div class="form-group">
                          <label>Phone: </label>
                          <input type="number" name="phone" class="form-control" value="<?= set_value('phone',$row_ud->phone) ?>">
                          <span class="text-danger"><?= form_error('phone') ?></span>
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="hidden_id" value="<?= $row_ud->id ?>">
                          <input type="submit" name="update" value="Cập nhật" class="form-control btn btn-primary">
                        </div>
                      <?php endforeach ?>
                  <?php endif ?>
                </div>
              </div>
        			
              </form> 
        		</div> 
         
        </div> <!-- end row -->
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
