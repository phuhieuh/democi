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
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="display-4 text-center"><?= $title ?></h1>
      </div> <!-- end col-sm-12 -->
    </div> <!-- end row -->
    <div class="row">
      <?php foreach ($data_user as $row): ?>
        <div class="col-sm-4">
          <div class="card">
            <img src="<?= base_url() ?>uploads/files/<?= $row->image ?>" class="img-fluid">
            <div class="card-body">
              <h4 class="card-title">Username: <span class="text-success"><?= $row->username ?></span></h4>
              <p class="card-text"><b>Level: <span class="text-primary"><?= $row->name ?></span></b></p>
            </div>
          </div>
        </div> <!-- end col-sm-4 -->
        <div class="col-sm-6 offset-2">
          <div class="row">
            <div class="col-sm-4">
              <div><b>First Name: </b></div>
              <div><b>Last Name: </b></div>
              <div><b>Email: </b></div>
              <div><b>Address: </b></div>
              <div><b>Phone: </b></div>
              <div><b>Created at: </b></div>
            </div>
            <div class="col-sm-8">
              <div><?= $row->first_name ?></div>
              <div><?= $row->last_name ?></div>
              <div><?= $row->email ?></div>
              <div><?= $row->address ?></div>
              <div><?= $row->phone ?></div>
              <div><?= date('d-m-Y', strtotime($row->created_at)); ?></div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <button class="btn btn-primary">Print to PDF</button>
              <button class="btn btn-primary">Print</button>
            </div> <!-- end col-sm-6 -->
          </div> <!-- end row -->
        </div> <!-- end col-sm-6 offset-2 -->
      <?php endforeach ?>
    </div> <!-- end row -->
      
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
