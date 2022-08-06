$(document).ready(function () {
  myPortforlio();

  let portfolio;
  let transactions;
  let limit = 4;

  // let lists = [{
  //     code: [0803, 0913, 0816, 0903, 0810, 0806, 0703, 0706, 0813, 0814, 0906],
  //     network: "MTN",
  //     value: 1,
  //     image: "/Public/img/network/1.png",
  //     data: [],
  //   },
  //   {
  //     code: [0907, (0701), 0802, 0902, 0812, 0808, ],
  //     network: "AIRTEL",
  //     value: 2,
  //     image: "/Public/img/network/2.png",
  //     data: [],
  //   },
  //   {
  //     code: [0909, 0908, 0818, 0809, 0817],
  //     network: "9MOBILE",
  //     value: 3,
  //     image: "/Public/img/network/4.webp",
  //     data: [],
  //   },
  //   {
  //     code: [0805, 0905, 0807, 0811, 0705, 0815],
  //     network: "GLO",
  //     value: 4,
  //     image: "/Public/img/network/3.jpg",
  //     data: [],
  //   },
  // ];
  let lists;

  let latestAirtime = [{
      phone: "234806",
    },
    {
      phone: "234909",
    },
    {
      phone: "234805",
    },
    {
      phone: "234907",
    },
  ];

  function networkList(){
    fetch('/purchase/network-list')
    .then(res => res.json())
    .then(data => {
      lists = data
      lists.forEach(networkItem);
      recentContacts()
      lists.forEach(quickRechargeData)
      dataPlan();
    })
  }
  networkList()

  function latestAirtimeAction() {
    let airtimeResult = latestAirtime.map((f) => {
      let code = `234${f.phone.toString().slice(1, 4)}`;
      let res = lists.find((i) => i.code.includes(code));
      if (res) {
        code = code;
        return res.code.includes(code) ?
          {
            ...f,
            ...res,
          } :
          f;
      }
    });
    airtimeResult.forEach(quickRecharge);
    // console.log(airtimeResult);
  }

  function format(number) {
    return parseInt(number)
      .toFixed(2)
      .replace(/\d(?=(\d{3})+\.)/g, "$&,");
  }

  // function selectNetwork(param) {
  //   let res = lists.find((i) => i.code.includes(parseInt(param)));
  //   // console.log(res)
  //   if (res) {
  //     $("#" + res.network.toLocaleLowerCase())
  //       .prop("checked", true)
  //       .parent()
  //       .find("label")
  //       .addClass("active");
  //     $("input.pur_network_check")
  //       .not("#" + res.network.toLocaleLowerCase())
  //       .prop("checked", false)
  //       .parent()
  //       .find("label")
  //       .removeClass("active");
  //     return res;
  //   } else {
  //     $("input.pur_network_check")
  //       .prop("checked", false)
  //       .parent()
  //       .find("label")
  //       .removeClass("active");
  //   }
  // }
  function selectNetwork(param) {
    let res = lists.find((i) => i.code.includes(param));
    // console.log(res)
    if (res) {
      $("#" + res.network.toLocaleLowerCase())
        .prop("checked", true)
        .parent()
        .find("label")
        .addClass("active");
      $("input.pur_network_check")
        .not("#" + res.network.toLocaleLowerCase())
        .prop("checked", false)
        .parent()
        .find("label")
        .removeClass("active");
      return res;
    } else {
      $("input.pur_network_check")
        .prop("checked", false)
        .parent()
        .find("label")
        .removeClass("active");
    }
  }

  function networkItem(e) {
    $(".networkItem").append(`
      <div class="col-3">
        <div class="form-group">
          <label for="${e.network.toLocaleLowerCase()}" class="pur_network_label">
            <img src="${e.image}" alt="" class="pur_network">
          </label>
          <input type="checkbox" name="network" value="${
            e.value
          }" id="${e.network.toLocaleLowerCase()}" class="pur_network_check">
        </div>
     </div>
    `);
  }

  function LatestTransactions(e, i) {
    $("#dashTansactions").append(`
            <tr>
                <td>
                    <div class="value">
                    ${e.description}
                    </div>
                    <span class="sub-value">${e.phone} ${e.ref}</span>
                </td>
                <td class="text-right">
                    <div class="value ${
                      e.status == 1 ? "text-danger" : "text-success"
                    }">
                    ${e.status == 1 ? "-" : "+"}&#8358;${format(e.amount)}
                    </div>
                    <span class="sub-value">12 Feb 2018</span>
                </td>
            </tr>
      `);
    // if(i > 3){
    //   break;
    // }
  }

  function dataPlanItems(e) {
    $(".data-plans").append(`
        <option value="${e.hash}" data-network=${e.network_id} data-id="${e.data_id}" >${e.desc} &#8358;${format(e.amount)}</option>
    `);
  }
  function quickRechargeData(e){
    $("#quickRechargeData").append(`
        
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
    `);
  }

  function quickRecharge(e) {
    $("#quickRecharge").append(`
        
    <div class="col-4 col-sm-3 col-xxl-2">
        <div class="profile-tile profile-tile-inlined">
            <a class="profile-tile-box quickRecharge" href="#" data-name="${e.network}" data-phone="${e.phone}">
                <div class="pt-avatar-w">
                <img alt="" src="${e.image}">
                </div>
                <div class="pt-user-name">
                    <span style="display:block;font-size:x-small">${e.phone} </span>
                   ${e.network}
                </div>
            </a>
        </div>
    </div>
    `);
  }
  $(".airtimeRecharge").on("click", function () {
    let ct = $("html").find(".all-wrapper.with-side-panel");
    ct.addClass("content-panel-active");
  });

  $(document).on("click", ".quickRecharge", function () {
    $(".switch-row").html(`
        <div class="col-12">
            <div class="form-group">
                <label for="">Amount</label>
                <div class="input-group">
                <input type="hidden" name="transaction__type" value="0" id="transaction-type"/>
                <input class="form-control" name="amount" id="purchasePrice" placeholder="Amount..." type="number" value="">
                <div class="input-group-append">
                    <div class="input-group-text">
                    NAIRA
                    </div>
                </div>
                </div>
            </div>
        </div>
      `);
    $("html")
      .find(".all-wrapper.with-side-panel")
      .addClass("content-panel-active");
    let phone = $("#recharge_phone").val($(this).data("phone"));
    let network = $(this).data("name");

    $("#" + network.toLocaleLowerCase())
      .prop("checked", true)
      .parent()
      .find("label")
      .addClass("active");
    $("input.pur_network_check")
      .not("#" + network.toLocaleLowerCase())
      .prop("checked", false)
      .parent()
      .find("label")
      .removeClass("active");
  });
  $(document).on("click", ".quickRechargeData", function () {
    $(".switch-row").html(`
        <div class="col-12">
            <div class="form-group">
            <label for="">Plan</label>
            <div class="input-group">
            <input type="hidden" name="transaction__type" value="1" id="transaction-type"/>
                <select name="plan" id="data__plans" class="data-plans form-control">
                <option value="">Select</option>
                </select>
                <div class="input-group-append">
                <div class="input-group-text">
                    Plan
                </div>
                </div>
                <input type="hidden" name="network_id" id="data-network-id" >
                <input type="hidden" name="data_id" id="data-data-id" >
            </div>
            </div>
        </div>
    `);
      $("html")
      .find(".all-wrapper.with-side-panel")
      .addClass("content-panel-active");
    let network = $(this).data("name");

    $("#" + network.toLocaleLowerCase())
      .prop("checked", true)
      .parent()
      .find("label")
      .addClass("active");
    $("input.pur_network_check")
      .not("#" + network.toLocaleLowerCase())
      .prop("checked", false)
      .parent()
      .find("label")
      .removeClass("active");
  });
  $(document).on('change', '#data__plans', function () {
    // let val =
    $('#data-network-id').val($(this).find(':selected').data('network'))
    $('#data-data-id').val($(this).find(':selected').data('id'))
  })
  $(document).on("click", ".quickDataPlan", function () {
    $(".switch-row").html(`
        <div class="col-12">
            <div class="form-group">
            <label for="">Plan</label>
            <div class="input-group">
            <input type="hidden" name="transaction__type" value="1" id="transaction-type"/>
                <select name="plan" id="data__plans" class="data-plans form-control">
                <option value="">Select</option>
                </select>
                <div class="input-group-append">
                <div class="input-group-text">
                    Plan
                </div>
                </div>
                <input type="hidden" name="network_id" id="data-network-id" >
                <input type="hidden" name="data_id" id="data-data-id" >
            </div>
            </div>
        </div>
    `);
    $("html")
      .find(".all-wrapper.with-side-panel")
      .addClass("content-panel-active");
  });
  $("#recharge_phone").keyup(function (e) {
    let t = e.target.value.slice(0, 4);
    if (t.length > 3) {
      let res = selectNetwork('234'+t.slice(1,4));
      if ($("#transaction-type").val() == 1) {
        $(".data-plans").html('<option value="">Select</option>');
        res.data.forEach(dataPlanItems);
      }
    } else {
      $("input.pur_network_check")
        .prop("checked", false)
        .parent()
        .find("label")
        .removeClass("active");
    }
    if (e.target.value.length == 11) {
      let len = $("html").find("input.pur_network_check:checked").length;
      console.log(len);
      if (len == 1) {
        $(".purchase-button").prop("disabled", false);
      }
    } else {
      $(".purchase-button").prop("disabled", true);
    }
  });

  // Airtime recharge
  $("#airtime-recharge").on("submit", function (e) {
    e.preventDefault();
    let ths = $(this);
    let btn = $(".purchase-button");

    if ($("#purchasePrice").val() == "" || $("#recharge_phone").val() == "") {
      notification("Invalid Recharge Input");
    } else if (+portfolio.wallet < parseInt($("#purchasePrice").val())) {
      notification("Insufficient Balance");
    } else {
      $.ajax({
        url: "/purchase/validate",
        method: "POST",
        data: ths.serialize(),
        dataType: "json",
        timeout: 20000,
        dataType: 'json',
        beforeSend: function () {
          btn.attr("disabled", "disabled").find("span").slideUp();
          btn.find("i").addClass("active-roll");
          console.log(navigator.onLine)
        },
        success: function (e) {
          notification('Transaction Successful', 'fff', '8dbf42')
          console.log(e);
          btn.attr("disabled", false).find("span").slideDown();
          btn.find("i").removeClass("active-roll");
          $("#purchasePrice").val("")
          $("#recharge_phone").val("")
          $('#data__plans').val("")
          myPortforlio()
          $("html")
            .find(".all-wrapper.with-side-panel")
            .removeClass("content-panel-active");
        },
        error: function (e, t, d) {
          btn.attr("disabled", false).find("span").slideDown();
          btn.find("i").removeClass("active-roll");
          if (t == 'timeout') {
            notification('Response timeout', 'fff', 'e7515a');
          }else if(e.status == 401){
            notification('Looks like you are offline')
          }else if (e.status == 400) {
            let msg = e.responseJSON.error ? e.responseJSON.error : e.responseJSON.msg || e.responseJSON.detail;
            msg.map(i => i.includes("due to insufficient balance") ? notification("Currently Unavailabe", 'fff', 'e7515a') : notification(i, 'fff', 'e7515a'))
            // notification(msg, 'fff', 'e7515a')
          }else{
            notification('Unable to connect', 'fff', 'e7515a')

          }
          console.log(e)
        }
      });
    }
  });

  $(document).on("click", ".load-more", function () {
    transaction(limit);
    limit = limit + 4;
  });

  $(document).on("click", "#deposit", function () {
    $("#fundWalletModal").modal("show");
  });

  $(".fund-wallet-btn").on("click", function () {
    let amount = $("#fundingAmount").val();
    if (amount == "") {
      notification("How much do you want to pay ?");
    } else {
      $.ajax({
        url: "/purchase/fund-wallet",
        method: "POST",
        data: {
          amount
        },
        success: function (e) {
          payWithPaystack(e)
        },
      });
    }
  });

  function payWithPaystack(data) {
    var handler = PaystackPop.setup({
      key: data.key, // Replace with your public key
      email: data.email,
      amount: parseInt(data.amount * 100), // the amount value is multiplied by 100 to convert to the lowest currency unit
      currency: "NGN", // Use GHS for Ghana Cedis or USD for US Dollars
      firstname: data.phone,
      // lastname: form_number,
      reference: data.ref, // Replace with a reference you generated
      callback: function (response) {
        //this happens after the payment is completed successfully
        data.ref = response.reference;
        $.ajax({
          url: '/purchase/verify-payment',
          method: "POST",
          data: data,
          success: function (data) {
            $("#fundWalletModal").modal("hide");
            $("#fundingAmount").val('')
            myPortforlio()
          },
        });
      },
      onClose: function () {
        alert("Transaction was not completed, window closed.");
      },
    });
    handler.openIframe();
  }

  function recentContacts() {
    fetch("/portfolio/recent-airtime")
      .then((res) => res.json())
      .then((data) =>
        data.map((i) => {
          i.phone = i.phone;
          return i;
        })
      )
      .then((data) => {
        if (data.length > 0) {
          latestAirtime = data;
          latestAirtimeAction();
        }
      });
  }

  function myPortforlio() {
    $.ajax({
      url: "/portfolio/portfolio",
      success: function (e) {
        portfolio = {
          ...e[0],
          transactions: e[1],
        };
        $(".balance1, .balance2").html("&#8358;" + format(portfolio.wallet));
        $(".fs-balance").html("&#8358;" + format(portfolio.wallet));
        $("#dashTansactions").html("");
        portfolio.transactions.forEach(LatestTransactions);
      },
    });
  }

  function transaction(limit) {
    $.ajax({
      url: "/portfolio/transaction",
      type: "POST",
      data: {
        limit,
      },
      success: function (e) {
        e.forEach(LatestTransactions);
      },
    });
  }

  async function dataPlan() {
    let res = await fetch('/purchase/data-plan')
    let  data = await res.json()
    data.map(plan => {

      lists = lists.filter(list => list.value == plan.network_id ? list.data = [...list.data, plan] : list.data = list.data)
    })
    console.log(lists);
        
  }
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