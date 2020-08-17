$(document).ready(function () {
  console.log("Loaded");
  $('.alert').hide();
  var url_ = window.location.href;
  var base_url = url_.substring(0, url_.lastIndexOf('/') + 1);

  $('[data-toggle="tooltip"]').tooltip();
  var actions = $("table td:last-child").html();
  // Append table with add row form on add new button click
  // $(".add-new").click(function () {
  //   $(this).attr("disabled", "disabled");
  //   var index = $("table tbody tr:last-child").index();
  //   var row = '<tr>' +
  //     '<td col-name="first_name"><input type="text" class="form-control" name="name" id="name"></td>' +
  //     '<td col-name="last_name"><input type="text" class="form-control" name="department" id="department"></td>' +
  //     '<td col-name="email"><input type="text" class="form-control" name="phone" id="phone"></td>' +
  //     '<td>' + actions + '</td>' +
  //     '</tr>';
  //   $("table").append(row);
  //   $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
  //   $('[data-toggle="tooltip"]').tooltip();
  // });
  // Add row on add button click
  $(document).on("click", ".add", function () {
    var empty = false;
    var input = $(this).parents("tr").find('input[type="text"]');
    input.each(function () {
      if (!$(this).val()) {
        $(this).addClass("error");
        empty = true;
      } else {
        $(this).removeClass("error");
      }
    });

    var row = $(this).parents("tr");
    row.find(".error").first().focus();

    var data_request = {
      "id": row.attr('data-id'),
      data: {}
    };

    if (!empty) {

      input.each(function () {
        var current_entry = $(this);
        var col_name = current_entry.parent().attr("col-name");
        var value = current_entry.val();
        data_request['data'][col_name] = value;
        // current_entry.parent("td").html($(this).val());
      });

      if (data_request.id) {
        fetch_edit(data_request).then( res => {
          toggle_success("Edit record sucessfully!");

          input.each(function () {
            var current_entry = $(this);
            current_entry.parent("td").html($(this).val());
          });

          row.find(".add, .edit").toggle();
          $(".add-new").removeAttr("disabled");
        }).catch( err => {
          console.log(err);
          toggle_fail("Failed to edit record! " + err.responseJSON.err);
        });
      } else {
        fetch_add(data_request).then(res => {
          console.log(res);
          var row = $(this).parents("tr");
          row.attr("data-id", res.id);
          row.find(".add, .edit").toggle();
          input.each(function () {
            var current_entry = $(this);
            current_entry.parent("td").html($(this).val());
          });
          
          toggle_success("Add record sucessfully!");
        }).catch(err => {
          console.log(err);
          $(this).parents("tr").remove();
          toggle_fail("Failed to add record! " + err.responseJSON.err);
        });

        $(".add-new").removeAttr("disabled");
      }
    }
  });


  // Edit row on edit button click
  $(document).on("click", ".edit", function () {
    $(this).parents("tr").find("td:not(:last-child)").each(function () {
      $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
    });
    $(this).parents("tr").find(".add, .edit").toggle();
    $(".add-new").attr("disabled", "disabled");
  });
  // Delete row on delete button click
  $(document).on("click", ".delete", function () {
    var row = $(this).parents("tr");
    var data_request = {
      "id": row.attr("data-id")
    };
    fetch_delete(data_request);
    row.remove();
    $(".add-new").removeAttr("disabled");
  });

  const fetch_add = data_request => {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: base_url + "api/user",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(data_request.data),
        success: res => {
          resolve(res);
        },
        error: ex => {
          reject(ex);
        }
      });
    });
  }

  const fetch_edit = (data_request) => {
    console.log(base_url + "api/user/" + data_request.id);

    return new Promise(function(resolve, reject) {
      $.ajax({
        url: base_url + "api/user/" + data_request.id,
        type: 'PUT',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(data_request.data),
        success: res => {
          fetchLabelSearch();
          resolve(res);
        },
        error: ex => {
          reject(ex);
        }
      });
    });

    
  }

  const fetch_delete = (data_request) => {
    $.ajax({
      url: base_url + "api/user/" + data_request.id,
      type: "DELETE",
      success: res => {
        console.log("delete sucessfully!")
        console.log(res);
      },
      error: ex => {
        console.log("Failed to delete " + data_request.id);
      }
    })
  }

  const toggle_success = message => {
    $('#fail').hide('1s');
    $('#sucess').text(message).show('1s');
    setTimeout(function () {
      $('#sucess').hide('1s');
      
    }, 5000);
  }

  const toggle_fail = message => {
    $('#sucess').hide('1s');
    $('#fail').text(message).show('1s');

    setTimeout(function () {
      $('#fail').hide('1s');
    }, 5000);
  }

  const getLabelPeople = () => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: base_url + "api/search/user",
        type: "GET",
        dataType: 'json',
        contentType: 'application/json',
        success: res => {
          console.log(res);
          resolve(res);
        },
        error: ex => {
          reject(ex);
        }
      });
    })
  };

  const fetchLabelSearch = () => {
    $(".field input").remove();
    $(".field").append('<input type="text" name="nope" id="nope" placeholder="Enter person\'s name" maxlength="40" />');
    getLabelPeople().then(res => {
      $('#nope').autocompleter({
        // marker for autocomplete matches
        highlightMatches: true,
  
        // object to local or url to remote search
        source: res,
  
        // show hint
        hint: true,
  
        // abort source if empty field
        empty: false,
  
        // max results
        limit: 5
      });
    }).catch(e => {
      console.log(e);
    });
  }
  
  fetchLabelSearch();


  $("#add-button").click( () => {
    window.location.href = "add";
  })
});