$(document).ready(function () {
  // emailSetting();
  // paystackSetting();
  // smeSetting()
  // socialSetting()
  let pathName = location.pathname;
  switch (pathName) {
    case "/admin/settings/seo":
      seoSetting();
      break;
    case "/admin/settings/social":
      socialSetting();
      break;
    case "/admin/settings/site":
      siteSetting();
      break;
    default:
      break;
  }
  // siteSetting()

  //   ****************************** ==================
  //   ================ EMAIL SETTING ==================
  //   ****************************** ==================
  function emailSetting() {
    fetch("/admin/settings/email-setting")
      .then((res) => res.json())
      .then((data) => {
        $('[name="host"]').val(data.smtp_host);
        $('[name="port"]').val(data.smtp_port);
        $('[name="secure"]').val(data.smtp_secure);
        $('[name="username"]').val(data.smtp_username);
        $('[name="password"]').val(data.smtp_password);
        $('[name="from"]').val(data.mail_from);
      });
  }
  $(".email-settings").on("submit", function (e) {
    e.preventDefault();
    let ths = $(this);
    let btn = $(".save-email");

    updateProcess("/admin/settings/update-email", ths, btn);
  });

  //   ****************************** ==================
  //   ============== SOCIAL SETTING =================
  //   ****************************** ==================
  function socialSetting() {
    fetch("/admin/settings/social-setting")
      .then((res) => res.json())
      .then((data) => {
        if (data) {
          $('[name="pinterest_link"]').val(data.pinterest);
          $('[name="twitter_link"]').val(data.twitter);
          $('[name="facebook_link"]').val(data.facebook);
          $('[name="linkedin_link"]').val(data.linkedin);
        }
      });
  }

  $(".social-settings").on("submit", function (e) {
    e.preventDefault();
    let ths = $(this);
    let btn = $(".save-social");
    updateProcess("/admin/settings/update-social", ths, btn);
  });

  //   ****************************** ==================
  //   ============== SEO SETTING =================
  //   ****************************** ==================
  function seoSetting() {
    fetch("/admin/settings/seo-setting")
      .then((res) => res.json())
      .then((data) => {
        $('[name="meta_description"]').text(data.meta_description);
        $('[name="meta_keyword"]').text(data.meta_keyword);
        $('[name="google_analytics"]').text(data.google_analytics);
        $('[name="google_ads"]').text(data.google_ads);
      });
  }

  $(".seo-settings").on("submit", function (e) {
    e.preventDefault();
    let ths = $(this);
    let btn = $(".save-seo");
    updateProcess("/admin/settings/update-seo", ths, btn);
  });

  function updateProcess(url, ths, btn) {
    $.ajax({
      url: url,
      method: "POST",
      data: ths.serialize(),
      dataType: "json",
      cache: false,
      beforeSend: function () {
        btn.prop("disabled", true);
        btn.text("Saving...").addClass("btn-warning");
      },
      success: function (e) {
        btn.prop("disabled", false);
        btn
          .text("Action Saved")
          .removeClass("btn-warning")
          .addClass("btn-success");
        setTimeout(() => {
          btn.text("Save").removeClass("btn-success");
        }, 4000);
        // notification("Changes Saved", "fff", "8dbf42");
      },
      error: function (e) {
        btn.prop("disabled", false);
        btn.text("Error").removeClass("btn-warning").addClass("btn-danger");
        setTimeout(() => {
          btn.text("Save").removeClass("btn-danger");
        }, 4000);
        // notification("Error Occured", "fff", "e7515a");
      },
    });
  }

  //   ****************************** ==================
  //   ============== SITE SETTING =================
  //   ****************************** ==================
  function siteSetting() {
    fetch("/admin/settings/site-setting")
      .then((res) => res.json())
      .then((data) => {
        let { quickLink, ads, gadget } = data;
        $('[name="limit"]').val(quickLink.limit);
        $('[name="catrgory"]').val(quickLink.category);
        $('[name="ss"]').val(ads.sqr);
        $('[name="rlg"]').val(ads.rlg);
        $('[name="rsm"]').val(ads.rsm);
        $('[name="gadgetFoot"]').val(gadget.footer);
        $('[name="gadgetSide"]').val(gadget.side);
        console.log("Loaded", data);
      });
  }
  function preview(elem, file) {
    let reader = new FileReader();
    reader.onload = (e) => {
      $(elem).fadeIn();
      $(elem).attr("src", e.target.result);
    };
    reader.readAsDataURL(file);
  }

  $('[name="icon"]').on("change", function (e) {
    let file = e.target.files[0];
    preview(".icon-preview", file);
  });
  $('[name="logo"]').on("change", function (e) {
    let file = e.target.files[0];
    preview(".logo-preview", file);
  });

  $(".site-settings").on("submit", function (e) {
    e.preventDefault();
    let ths = $(this);
    let btn = $(".save-site");
    updateProcess("/admin/settings/update-site", ths, btn);
    // $.ajax({
    //   url: "/admin/settings/update-site",
    //   method: "POST",
    //   data: new FormData(this),
    //   contentType: false,
    //   processData: false,
    //   cache: false,
    //   beforeSend: function () {
    //     btn.prop("disabled", true).text("Please wait");
    //   },
    //   success: function (e) {
    //     btn.prop("disabled", false);
    //     notification("Changes Saved", "fff", "8dbf42");
    //     ths[0].reset();
    //     siteSetting();
    //   },
    //   error: function (e) {
    //     btn.prop("disabled", false);
    //     notification("Error Occured", "fff", "e7515a");
    //   },
    // });
  });

  // function updateProcess(url, ths, btn){
  //   $.ajax({
  //       url: url,
  //       method: "POST",
  //       data: ths.serialize(),
  //       dataType: "json",
  //       cache: false,
  //       beforeSend: function () {
  //         btn.prop("disabled", true);
  //       },
  //       success: function (e) {
  //         btn.prop("disabled", false);
  //         notification("Changes Saved", "fff", "8dbf42");
  //       },
  //       error: function (e) {
  //         btn.prop("disabled", false);
  //         notification("Error Occured", "fff", "e7515a");
  //       },
  //     });
  // }

  // *****************************************
  //=============Password Reset Form===========
  // *****************************************
  $("#password_form").on("submit", function (e) {
    e.preventDefault();
    let btn = $(".submit_btn");
    let old = $("#old_password").val();
    let npp = $("#new_password").val();
    let cpp = $("#confirm_password").val();

    if (old == "" || npp == "" || cpp == "") {
      alert("Fields cannot be empty");
      // notification('Fields cannot be empty');
    } else {
      if (npp != cpp) {
        alert("Password Mismatch");
        // notification("Password Mismatch")
        return false;
      } else {
        if (old == npp) {
          alert("New password cannot be old password");
          // notification('New password cannot be old password')
        } else {
          $.ajax({
            url: "/admin/settings/password-setting",
            method: "POST",
            data: { old, new: npp },
            dataType: "json",
            beforeSend: function () {
              btn
                .attr("disabled", "disabled")
                .text("Please Wait...")
                .addClass("btn-warning");
            },
            success: function (e) {
              // notification(e, 'fff', '1b55e2')
              btn
                .text("Action saved")
                .addClass("btn-success")
                .removeClass("btn-warning");
              btn.attr("disabled", false);
              $("input#confirm_password").val("");
              $("input#new_password").val("");
              $("input#old_password").val("");
            },
            error: function (e) {
              btn.text("Save").removeClass("btn-warning");
              console.log(e);
              btn.attr("disabled", false);
              alert(e.responseJSON);
              // notification(e.responseJSON)
            },
          });
        }
      }
    }
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
