$(function () {
  var url_ = window.location.href;
  var base_url = url_.substring(0, url_.lastIndexOf('/') + 1);
  

  const getAllPeople = () => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: base_url + "api/user",
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

  const getPeopleByName = name => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: base_url + "api/search/people?name=" + name,
        type: "GET",
        dataType: 'json',
        contentType: 'application/json',
        success: res => {
          console.log(res);
          resolve(res);
        },
        error: ex => {
          console.log(ex);
          reject(ex);
        }
      });
    })
  }

  

  const getViewRowTable = dataRow => {
    var view =
      '<tr data-id="${id}">' +
      '                        <td col-name="first_name">${firstName}</td>' +
      '                        <td col-name="last_name">${lastName}</td>' +
      '                        <td col-name="email">${email}</td>' +
      '                        <td>' +
      '                          <a class="add" title="" data-toggle="tooltip" data-original-title="Add"><i class="material-icons"></i></a>' +
      '                          <a class="edit" title="" data-toggle="tooltip" data-original-title="Edit"><i class="material-icons"></i></a>' +
      '                          <a class="delete" title="" data-toggle="tooltip" data-original-title="Delete"><i class="material-icons"></i></a>' +
      '                        </td>' +
      '                      </tr>';

    view = view.replace('${id}', dataRow.id);
    view = view.replace('${firstName}', dataRow.first_name);
    view = view.replace('${lastName}', dataRow.last_name);
    view = view.replace('${email}', dataRow.email);

    return view;
  }

  const generateBodyTable = data => {


    var view = '';

    data.forEach(element => {
      view += getViewRowTable(element);
    });
    return view;
  }


  $("#search-people").click(() => {
    var searchName = $('#nope').val();
    getPeopleByName(searchName).then(res => {

      var view = generateBodyTable(res);
      $("#table-people").empty();
      $("#table-people").append(view);
      $("#show-all").css("visibility", "visible");
      $('#fail').hide('1s');
    }).catch(err => {
      $('#sucess').hide('1s');
      $('#fail').text("Can't not find any people named " + searchName).show('1s');
    });

  });

  $("#show-all").click(() => {
    getAllPeople().then(res => {
      var view = generateBodyTable(res);
      $('#fail').hide('1s');
      $("#table-people").empty();
      $("#table-people").append(view);
      $("#show-all").css("visibility", "hidden");
    }).catch(e => {
      console.log(e);
    });
  });

});