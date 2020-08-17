$().ready(function () {

  var err = true;

  $("#peope-form").validate({
    rules: {
      first_name: {
        required: true,
      },
      last_name: {
        required: true,
      },
      email: {
        required: true,
        email: true
      }
    },
    showErrors: function (errorMap, errorList) {
      this.defaultShowErrors();
      if (errorList.length === 0) {
        err = false;
      } else {
        err = true;
      }

      // console.log(err)
      // console.log(errorList.length)
    },
    success: function () {
      err = false;
    }
  });

  var url_ = window.location.href;
  var base_url = url_.substring(0, url_.lastIndexOf('/') + 1);
  const checkValidEmail = (email) => {
    var data_request = {
      "email": email
    };

    return new Promise((resolve, reject) => {
      $.ajax({
        url: base_url + "api/user/check",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(data_request),
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

  $("#submit-info").click((e) => {
    $('#fail').css("visibility", "hidden");
    e.preventDefault();
    var email = $(".email").val();
    console.log(email);
    checkValidEmail(email).then(res => {
      toggle_fail("Email exist!")
    }).catch(res => {
      $("#peope-form").submit();
    });
  })

  $("#peope-form").submit(function (event) {
    event.preventDefault();
    if (err === false) {
      var data_form = $("#peope-form").serializeArray();
      var data_request = {};
      $.each(data_form, function (i, item) {
        data_request[item.name] = item.value;
      });

      console.log(data_request);
      fetch_add(data_request).then(res => {
        window.location.href = "index.php";
        console.log(res);
      }).catch(err => {
        toggle_fail("Can't save data! Try again!")
      });
    }

  });

  const fetch_add = data_request => {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: base_url + "api/user",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(data_request),
        success: res => {
          resolve(res);
        },
        error: ex => {
          reject(ex);
        }
      });
    });
  }

  const toggle_fail = message => {
    $('#fail').text(message).css("visibility", "visible");
  }
});