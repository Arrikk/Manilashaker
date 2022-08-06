$(document).ready(function () {
  // *****************************************************
  // =================== Login ====================
  // *****************************************************
  $("#login__form").on("submit", function (e) {
    e.preventDefault();
    let ths = $(this);
    let btn = $('[name="login"]');
    $.ajax({
      url: "/auth/authenticate",
      method: "POST",
      data: ths.serialize(),
      cache: false,
      beforeSend: function () {
        btn.val(
          'Authorizing'
        );
        btn.attr("disabled", "disabled");
      },
      success: function (e) {
        btn.val("Logged in");
        btn.attr("disabled", false);
        window.location = e;
      },
      error: function (e) {
        btn.val("Log me in");
        btn.attr("disabled", false);
        console.log(e);
        if (e.status == 400) {
          $('[class="login-error"]').html(e.responseJSON)
          // notification(e.responseJSON, "fff", "e7515a");
          alert(e.responseJSON)
        }
      },
    });
  });

  // *****************************************************
  // =================== Register ====================
  // *****************************************************
  $("#register__form").on("submit", function (e) {
    e.preventDefault();
    let ths = $(this);
    let btn = $('[class="button register-btn"]');
    if($('#reg_password').val() == $('#password2').val()){
      $.ajax({
        url: "/auth/registerProcess",
        method: "POST",
        data: ths.serialize(),
        cache: false,
        dataType: "json",
        beforeSend: function () {
          btn.val('Please Wait...');
          btn.attr("disabled", "disabled");
        },
        success: function (e) {
          btn.val("Register Now");
          btn.attr("disabled", false);
          // notification("Registered Confirm email", "fff", "#8dbf42");
          window.location = e;
        },
        error: function (e) {
          btn.val("Register Now");
          btn.attr("disabled", false);
          if (e == "timeout") {
            // notification("Connection timeout");
            $('.register-error').html('Connection Timeout')
          } else if (e.status == 400) {
            console.log(e);
            // notification(e.responseText, "fff", "e7515a");
            $('.register-error').html(e.resposeText)
          } else {
            $('.register-error').html(e.responseJSON)
            // notification(e.responseJSON, "fff", "e7515a");
          }
        },
      });
    }else{
      $('.register-error').html('Password Mismatch')
    }
  });

  // *****************************************************
  // =================== Activation ====================
  // *****************************************************
  $("#send__activation").on("click", function () {
    let btn = $(this);
    $.ajax({
      url: "/auth/send-activation",
      dataType: "json",
      timeout: 10000,
      beforeSend: function () {
        btn.html(
          '<div class="spinner-border text-white loader-sm align-self-center"></div> Processing'
        );
        btn.attr("disabled", "disabled");
      },
      success: function (e) {
        btn.html("Check your email");
        btn.attr("disabled", "disabled");
        notification("Activation link sent", "fff", "8dbf42");
      },
      error: function (e, t, d) {
        btn.html("Activate my account");
        btn.attr("disabled", false);

        if (t === "timeout") {
          notification("Network timeout: Try again", "fff", "2196f3");
        } else {
          notification("Unable to send at the moment", "fff", "e7515a");
        }
      },
    });
  });

  // *****************************************************
  // ============= Send Password Reset=============
  // *****************************************************
  $("#forgot__password").on("submit", function (e) {
    e.preventDefault();
    let data = $(this).serialize();
    let btn = $('[type="submit"]');
    if ($("#reset_email").val() == "") {
      notification("Email is required", "fff", "e7515a");
    } else {
      $.ajax({
        url: "/auth/send-reset",
        method: "POST",
        data: data,
        dataType: "json",
        timeout: 10000,
        beforeSend: function () {
          btn.html(
            '<div class="spinner-border text-white loader-sm align-self-center"></div> Processing'
          );
          btn.attr("disabled", "disabled");
        },
        success: function (e) {
          btn.html("Check your email");
          btn.attr("disabled", "disabled");
          notification(e, "fff", "8dbf42");
        },
        error: function (e, t, s) {
          btn.html("Remember");
          btn.attr("disabled", false);

          if (t === "timeout") {
            notification("Network timeout: Try again", "fff", "2196f3");
          } else if (e.status == 400) {
            notification(e.responseJSON, "fff", "e7515a");
          } else {
            notification(
              "We couldn't send an activation code.. ",
              "fff",
              "e7515a"
            );
          }
        },
      });
    }
  });
  // *****************************************************
  // ============= Send Password Reset=============
  // *****************************************************
  $("#reset__form").on("submit", function (e) {
    e.preventDefault();
    let data = $(this).serialize();
    let btn = $('[type="submit"]');
    if ($("#reset_password").val() == "") {
      notification("Password is required", "fff", "e7515a");
    } else {
      $.ajax({
        url: "/auth/reset-password",
        method: "POST",
        data: data,
        dataType: "json",
        timeout: 10000,
        beforeSend: function () {
          btn.html(
            '<div class="spinner-border text-white loader-sm align-self-center"></div> Processing'
          );
          btn.attr("disabled", "disabled");
        },
        success: function (e) {
          btn.html("Proceed to login");
          btn.attr("disabled", "disabled");
          notification(e, "fff", "8dbf42");
          setTimeout(() => {
            window.location = "/login";
          }, 2000);
        },
        error: function (e, t, s) {
          btn.html("Reset");
          btn.attr("disabled", false);

          if (t === "timeout") {
            notification("Network timeout: Try again", "fff", "2196f3");
          } else if (e.status == 400) {
            notification(e.responseJSON, "fff", "e7515a");
          } else {
            notification("Reset Failed", "fff", "e7515a");
          }
        },
      });
    }
  });

  // *****************************************************
  // =================== Login ADMIN ====================
  // *****************************************************
  $("#login__admin").on("submit", function (e) {
    e.preventDefault();
    let ths = $(this);
    let btn = $('[type="submit"]');
    $.ajax({
      url: "/admin/auth/login-admin",
      method: "POST",
      data: ths.serialize(),
      cache: false,
      beforeSend: function () {
        btn.html(
          '<div class="spinner-border text-white loader-sm align-self-center"></div> Authorizing'
        );
        btn.attr("disabled", "disabled");
      },
      success: function (e) {
        btn.html("Logged in");
        btn.attr("disabled", false);
        window.location = '/admin/post/all';
      },
      error: function (e) {
        btn.html("Log me in");
        btn.attr("disabled", false);
        console.log(e);
        if (e.status == 400) {
          notification(e.responseJSON, "fff", "e7515a");
        }
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
});
// Primary #1b55e2
// Info #2196f3
// Success #8dbf42
// Danger #e7515a
