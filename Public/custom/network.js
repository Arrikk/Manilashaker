$(document).ready(function () {
  let dataPlan;
  let network;

  $('.airtime-admin-head').text("Telecom Networks")
  $('.btn-payment-hide').hide()

  const networkListItem = (e) => {
    $('#quickRecharge').append(`
      <div class="col-4 col-sm-3 col-xxl-2">
          <div class="profile-tile profile-tile-inlined">
              <a class="profile-tile-box quickRechargeData" href="#" data-name="${e.network}">
                  <div class="pt-avatar-w">
                  <img alt="" src="${e.image}">
                  </div>
                  <div class="pt-user-name">
                    ${e.network}
                  </div>
              </a>
          </div>
      </div>
    `)
  }

  const getNetworks = () => {
    fetch("/admin/network/network")
      .then((res) => res.json())
      .then((data) => {
        network = data
        network.forEach(networkListItem)
      });
  };
  getNetworks();

  const dataPlanItem = (e, i) => {
    $("#data-plan-items").append(`
            <tr>
                <td class="nowrap">
                <span class="status-pill smaller red"></span><span>${
                  i + 1
                }</span>
                </td>
                <td class="cell-with-media">
                    <img alt="" src="${e.image}" style="height: 25px;"><span>${
      e.network
    } </span>
                </td>
            <td class="nowrap">
                <span class="status-pill smaller green"></span><span>${
                  e.data_id
                }</span>
            </td>
            <td>
                <span>N${e.amount} ${e.size} ${e.plan_type} </span>
            </td>
            <td class="text-center">
                <a class="badge badge-warning" href="">${e.validity}</a>
            </td>
            <td class="text-right bolder nowrap">
                <span class="text-danger">${e.amount} NGN</span>
            </td>
            <td class="text-right bolder nowrap">
                <a href="#!" class="badge badge-primary edit-plan text-white" data-plan-edit="${
                  e.plan_id
                }"><i class="os-icon os-icon-edit-1"></i></a>
                    &nbsp;&nbsp;&nbsp;
                <a href="#!" class="badge badge-danger delete-plan text-white" data-plan-trash="${
                  e.plan_id
                }"><i class="os-icon os-icon-cancel-circle"></i></a>
            </td>
            </tr>
        `);
  };

  const networkItem = (e) => {
    $("#data_plan_data_network").append(`
        <option value="${e.network_id}">${e.network}</option>
    `);
  };

  const fetchDataPlan = async () => {
    let res = await fetch("/admin/network/data-list");
    let data = await res.json();
    dataPlan = data;
    $("#data-plan-items").html("");
    dataPlan.forEach(dataPlanItem);
  };

  fetchDataPlan();

  // ==================================
  // Delete Data plan
  // ==================================
  $(document).on("click", ".delete-plan", function () {
    let id = $(this).data("plan-trash");
    if (window.confirm("Do you want to proceed")) {
      fetch(`/admin/network/${id}/trash-plan`)
        .then((res) => res.json())
        .then((res) => {
          dataPlan = dataPlan.filter((i) => i.plan_id != id);
          $("#data-plan-items").html("");
          dataPlan.forEach(dataPlanItem);
          notification("Action Completed", "fff", "2196f3");
        });
    }
  });
  // ==================================
  // Open Data plan Create Modal
  // ==================================
  $(document).on("click", ".add-data-plan-modal", function () {
    $(".data-plan-modal-button")
      .addClass("data-plan-modal-add")
      .removeClass("data-plan-modal-update");
    $("#data-plan-modal-title").text("Add Data Plan");
    $("#data-plan-modal-form").html(`
            <div class="form-group">
                <select name="data_plan_data_network" id="data_plan_data_network" class="form-control">
                    <option value="">Select</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Data Id</label>
                <input type="number" placeholder="Data Id" name="data_plan_data_id" id="data-plan-id" class="form-control data-plan-id">
            </div>
            <div class="form-group">
                <label for="">Validity</label>
                <input type="text" placeholder="Validity" name="data_plan_data_validity" id="data-plan-validity" class="form-control data-plan-validity">
            </div>
            <div class="form-group">
                <label for="">Type</label>
                <input type="text" placeholder="Type" name="data_plan_data_type" id="data-plan-type" class="form-control data-plan-type">
            </div>
            <div class="form-group">
                <label for="">Size</label>
                <input type="text" placeholder="Size" name="data_plan_data_size" id="data-plan-size" class="form-control data-plan-size">
            </div>
            <div class="form-group">
                <label for="">Price</label>
                <input type="number" placeholder="Price" name="data_plan_data_price" id="data-plan-amount" class="form-control data-plan-amount">
            </div>
        `);
    network.forEach(networkItem);
    $(".data-pan-modal").modal("show");
  });

  $(document).on("click", ".data-plan-modal-add", function () {
    let data_network = $("#data_plan_data_network").val();
    let data_validity = $('[name="data_plan_data_validity"]').val();
    let data_type = $('[name="data_plan_data_type"]').val();
    let data_size = $('[name="data_plan_data_size"]').val();
    let data_price = $('[name="data_plan_data_price"]').val();

    let data = $("#data-plan-modal-form").serialize();

    let btn = $(this);

    if (
      data_network == "" ||
      data_price == "" ||
      data_type == "" ||
      data_size == ""
    ) {
      notification("Please fill out empty fields");
    } else {
      btn.prop("disabled", true);
      $.ajax({
        url: "/admin/network/add-plan",
        method: "POST",
        data: data,
        dataType: "json",
        success: function (e) {
          btn.prop("disabled", false);
          notification("Success", "fff", "8dbf42");
          $("#data-plan-modal-form")[0].reset();
          $(".data-pan-modal").modal("hide");
          fetchDataPlan()
        },
        error: function () {
          notification("Something went wrong");
          btn.prop("disabled", fakse);
        },
      });
    }
  });

  // ==================================
  // Open Data plan Edit Modal
  // ==================================
  $(document).on("click", ".edit-plan", function () {
    let id = $(this).data("plan-edit");
    let data = dataPlan.find((i) => i.plan_id == id);
    $("#data-plan-modal-title").text("Update Data Plan #~" + id);
    $("#data-plan-modal-form").html(`
            <div class="form-group">
                <input type="text" disabled value="${data.network}" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Data Id</label>
                <input type="number" value="${data.data_id}" placeholder="Data Id" name="data-plan-data-id" id="data-plan-id" class="form-control data-plan-id">
            </div>
            <div class="form-group">
                <label for="">Validity</label>
                <input type="text" value="${data.validity}" placeholder="Validity" name="data-plan-validity" id="data-plan-validity" class="form-control data-plan-validity">
            </div>
            <div class="form-group">
                <label for="">Price</label>
                <input type="number" value="${data.amount}" placeholder="Price" name="data-plan-amount" id="data-plan-amount" class="form-control data-plan-amount">
            </div>
            <input type="hidden" value="${data.plan_id}" name="data-plan-id"/>
        `);
    $(".data-plan-modal-button")
      .addClass("data-plan-modal-update")
      .removeClass("data-plan-modal-add");
    $(".data-pan-modal").modal("show");
  });

  // ==================================
  // Edit Data Plan
  // ==================================
  $(document).on("click", ".data-plan-modal-update", function () {
    let btn = $(this);
    let data = $("#data-plan-modal-form").serialize();
    btn.prop("disabled", true);
    $.ajax({
      url: "/admin/network/update-plan",
      method: "POST",
      data: data,
      dataType: "json",
      success: function () {
        notification("Action Completed", "fff", "8dbf42");
        btn.prop("disabled", false);
        btn.removeClass("data-plan-modal-update");
        fetchDataPlan();
        $(".data-pan-modal").modal("hide");
      },
      error: function (e) {
        btn.prop("disabled", false);
        let msg = e.responseJSON ? e.responseJSON : "Update Failed";
        notification(msg);
      },
    });
  });

  function notification(text, color = "fff", bg = "3b3f5c") {
    Snackbar.show({
      pos: "top-right",
      text: text,
      actionTextColor: "#" + color,
      backgroundColor: "#" + bg,
    });
  }
  // Primary #1b55e2
  // Info #2196f3
  // Success #8dbf42
  // Danger #e7515a
});
