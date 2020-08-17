<?php
use App\Model\PersonModel;
use Cu\Db\Migration;

$ps = new PersonModel();

$result = $ps->all();
$people = null;

if (!isset($result['err'])) {
    $people = $result['data'];
} else {
    if (!Migration::migrate()) {
        echo "Failed to initialize database";
    } else {
        $result = $ps->all();
        $people = $result['data'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Document</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <style>
    .container {
      max-width: 500px;
    }

    .error {
      color: red;
    }
  </style>
</head>

<body>

  <div class="container">


      <div class="row">
          <div class="col-xl-8 offset-xl-2 py-5">

              <div class="alert alert-success" role="alert" id="sucess" style="visibility: hidden">
                Successfully!
              </div>

              <div class="alert alert-danger" role="alert" id="fail" style="visibility: hidden">
                Error occured!
              </div>
              <form id="peope-form" method="post" action="">

                <div class="controls">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_name">Firstname *</label>
                                <input id="form_name" type="text" name="first_name" class="form-control" placeholder="Please enter your firstname *">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_lastname">Lastname *</label>
                                <input id="form_lastname" type="text" name="last_name" class="form-control" placeholder="Please enter your lastname *">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_email">Email *</label>
                                <input id="form_email" type="email" name="email" class="form-control email" placeholder="Please enter your email *">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-success btn-send" value="Submit" id="submit-info">
                        </div>
                    </div>

                </div>

              </form>

          </div>

      </div>

  </div>


  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="validator.js"></script>

</body>

</html>
