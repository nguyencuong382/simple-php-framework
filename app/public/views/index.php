<?php
    use App\Model\PersonModel;
    use Cu\Db\Migration;

    $ps = new PersonModel();

    $result =$ps->all();
    $people = null;

    if(!isset($result['err'])) {
      $people = $result['data'];
    } else {
      if (!Migration::migrate()) {
          echo "Failed to initialize database";
      } else {
          $result =$ps->all();
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
  <link rel="stylesheet" href="./style-search.css">
 
</head>

<body>
  <div class="container">
    
    <div class="table-wrapper">
      
    <div class="alert alert-success" role="alert" id="sucess">
      Successfully!
    </div>

    <div class="alert alert-danger" role="alert" id="fail">
      Error occured!
    </div>

      <?php
          if($people == null) { ?>
            <form action="migrate" method='POST'>
              <div class="form-group " style="text-align:center">
                <label for="searchKey">Data is empty, you must initialize it</label><div></div>
                <button type="submit" class="btn btn-primary" name='init_data'>Initialize data</button>
              </div>
            </form>
      <?php
          } else { ?>
              <form action="migrate" method='POST'>
                <div class="form-group " >
                  <button type="submit" class="btn btn-primary" name='init_data'>Reset Data</button>
                </div>
              </form>

              <div class="search">
                <div class="field search">
                  <div class="icon"></div>
                  <input type="text" name="nope" id="nope" placeholder="Enter person's name" maxlength="40" />
                </div>
                <button class="btn btn-primary" id="search-people">Search</button>
              </div>
              

              <div class="table-title">
                <div class="row">
                  <div class="col-sm-8">
                    <h2>Employee <b>Details</b></h2>
                  </div>
                  <div class="col-sm-4">
                    <button type="button" class="btn btn-info add-new" id="add-button"><i class="fa fa-plus"></i> Add New</button>
                    <button type="button" class="btn btn-info add-new" id="show-all" style="visibility:hidden; margin-right: 10px">Show all</button>
                  </div>
                </div>
              </div>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="table-people">
                  <?php
                    foreach ($people as $key => $person) { 
                      if ($person['is_active'] != 0) {
                          ?>
                      <tr data-id="<?php echo $person['id']?>">
                        <td col-name="first_name"><?php echo $person['first_name']?></td>
                        <td col-name="last_name"><?php echo $person['last_name']?></td>
                        <td col-name="email"><?php echo $person['email']?></td>
                        <td>
                          <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                          <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                          <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                        </td>
                      </tr>
                  <?php
                      }}
                  ?>
                </tbody>
              </table>
      <?php }
      ?>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="main.js"></script>
  <script src="jquery.autocompleter.js"></script>
  <script src="search.js"></script>
</body>

</html>                     