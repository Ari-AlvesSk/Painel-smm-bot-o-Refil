localStorage &&
  "true" == localStorage.getItem("darkMode") &&
  (document.documentElement.setAttribute("data-theme", "dark"),
  $('.dark-mode-toggler input[type="checkbox"]').prop("checked", !0)),
  (function ($) {
    ($.fn.countTo = function (options) {
      options = $.extend({}, $.fn.countTo.defaults, options || {});
      var loops = Math.ceil(options.speed / options.refreshInterval),
        increment = (options.to - options.from) / loops;
      return $(this).each(function () {
        var _this = this,
          loopCount = 0,
          value = options.from,
          interval = setInterval(updateTimer, options.refreshInterval);
        function updateTimer() {
          (value += increment),
            loopCount++,
            $(_this).html(value.toFixed(options.decimals)),
            "function" == typeof options.onUpdate &&
              options.onUpdate.call(_this, value),
            loopCount >= loops &&
              (clearInterval(interval),
              (value = options.to),
              "function" == typeof options.onComplete &&
                options.onComplete.call(_this, value));
        }
      });
    }),
      ($.fn.countTo.defaults = {
        from: 0,
        to: 100,
        speed: 1e3,
        refreshInterval: 100,
        decimals: 0,
        onUpdate: null,
        onComplete: null,
      });
  })(jQuery),
  $(document).ready(function () {
    $("#detailsModal").on("show.bs.modal", function (event) {
      var button = $(event.relatedTarget),
        description = button.parent().find(".d-none").html(),
        title = $(button.parent().parent().find("td")[1]).html(),
        modal = $(this);
      modal.find(".modal-title").text(title),
        modal.find(".modal-body").html(description);
    }),
      $("#sidebarCollapse").on("click", function () {
        $("#sidebar").toggleClass("active");
      }),
      window.Waypoint &&
        ($(".divfadeIn").css("opacity", 0),
        $(".divfadeIn").waypoint(
          function () {
            $(".divfadeIn").addClass("animate__fadeIn");
          },
          { offset: "50%" }
        ),
        $(".divfadeInLeft").css("opacity", 0),
        $(".divfadeIn1").css("opacity", 0),
        $(".divfadeIn1").waypoint(
          function () {
            $(".divfadeIn1").addClass("animate__fadeIn");
          },
          { offset: "90%" }
        ),
        $(".divfadeInLeft1").css("opacity", 0),
        $(".divfadeInLeft").waypoint(
          function () {
            $(".divfadeInLeft").addClass("animate__fadeInLeft");
          },
          { offset: "90%" }
        ),
        $(".divfadeInRight").css("opacity", 0),
        $(".divfadeInRight").waypoint(
          function () {
            $(".divfadeInRight").addClass("animate__fadeInRight"),
              $(".number-customer").countTo({
                from: 50,
                to: 15e3,
                speed: 5e3,
                refreshInterval: 50,
                onComplete: function (value) {
                  console.debug(this);
                },
              }),
              $(".number-order").countTo({
                from: 50,
                to: 25e5,
                speed: 5e3,
                refreshInterval: 50,
                onComplete: function (value) {
                  console.debug(this);
                },
              }),
              $(".number-service").countTo({
                from: 50,
                to: 500,
                speed: 5e3,
                refreshInterval: 50,
                onComplete: function (value) {
                  console.debug(this);
                },
              });
          },
          { offset: "90%" }
        ),
        $(".divfadeInUp").css("opacity", 0),
        $(".divfadeInUp").waypoint(
          function () {
            $(".divfadeInUp").addClass("animate__fadeInUp");
          },
          { offset: "90%" }
        )),
      $(document).on(
        "change",
        '.dark-mode-toggler input[type="checkbox"]',
        function (event) {
          $(this).is(":checked")
            ? (console.log("dark"),
              document.documentElement.setAttribute("data-theme", "dark"),
              localStorage && localStorage.setItem("darkMode", "true"))
            : (console.log("light"),
              document.documentElement.removeAttribute("data-theme"),
              localStorage && localStorage.setItem("darkMode", "false"));
        }
      ),
      $(".collapse").on("show.bs.collapse", function () {
        $(this).parent().find(".card-header").addClass("bordered");
      }),
      $(".collapse").on("hidden.bs.collapse", function () {
        $(this).parent().find(".card-header").removeClass("bordered");
      });
  });
function searchOrders() {
  document.getElementById("history-search").submit();
}
$("#subjectSelect").change(function () {
  var subject = $(this).val();
  "payment" == subject
    ? ($("#orderSelectDiv").hide(),
      $("#paymentSelectDiv").show(),
      $("#anotherSelectDiv").hide())
    : "order" == subject
    ? ($("#orderSelectDiv").show(),
      $("#paymentSelectDiv").hide(),
      $("#anotherSelectDiv").hide())
    : "another" == subject
    ? ($("#anotherSelectDiv").show(),
      $("#orderSelectDiv").hide(),
      $("#paymentSelectDiv").hide())
    : ($("#anotherSelectDiv").hide(),
      $("#orderSelectDiv").hide(),
      $("#paymentSelectDiv").hide());
}),
  $("#ticketSubmit").click(function () {
    var orderID = $("#orderID").val(),
      orderSelect = $("#orderSelect").val(),
      subjectSelect = $("#subjectSelect").val(),
      paymentSelect = $("#paymentSelect").val(),
      anotherInput = $("#anotherInput").val();
    if ("none" == subjectSelect) alert("Konu seÃ§ilmeli");
    else if ("order" != subjectSelect || orderID)
      if ("order" == subjectSelect && "none" == orderSelect)
        alert("Probleminizi seÃ§melisiniz");
      else if ("payment" == subjectSelect && "none" == paymentSelect)
        alert("Probleminizi seÃ§melisiniz");
      else if ("another" != subjectSelect || anotherInput) {
        if ("order" == subjectSelect)
          var subject = "SipariÅŸ: " + orderSelect + " (" + orderID + ")";
        else if ("payment" == subjectSelect)
          var subject = "Ã–deme: " + paymentSelect;
        else if ("another" == subjectSelect) var subject = anotherInput;
        $("#subject").val(subject), $("#ticketsend").submit();
      } else alert("Probleminizi belirtmelisiniz");
    else alert("SipariÅŸ ID girilmeli");
  });
var subject = $("#subjectSelect").val();
function icontoText(val) {
  return (val = (val = (val = (val = val.replace(
    "[INS]",
    '<i class="fab fa-instagram"></i>'
  )).replace("[FB]", '<i class="fab fa-facebook"></i>')).replace(
    "[YT]",
    '<i class="fab fa-youtube"></i>'
  )).replace("[TW]", '<i class="fab fa-twitter"></i>')).replace(
    "[PN]",
    '<i class="fab fa-pinterest"></i>'
  );
}
function textToicon(val) {
  return (
    (donus = val),
    (-1 == val.indexOf("Instagram") &&
      -1 == val.indexOf("instagram") &&
      -1 == val.indexOf("Ä°nstagram") &&
      -1 == val.indexOf("Ä°GTV")) ||
      (donus = '<i class="fab fa-instagram"></i> ' + val),
    (-1 == val.indexOf("Youtube") && -1 == val.indexOf("youtube")) ||
      (donus = '<i class="fab fa-youtube"></i> ' + val),
    (-1 == val.indexOf("twitter") && -1 == val.indexOf("Twitter")) ||
      (donus = '<i class="fab fa-twitter"></i> ' + val),
    (-1 == val.indexOf("Facebook") && -1 == val.indexOf("facebook")) ||
      (donus = '<i class="fab fa-facebook"></i> ' + val),
    (-1 == val.indexOf("Spotify") && -1 == val.indexOf("spotify")) ||
      (donus = '<i class="fab fa-spotify"></i> ' + val),
    (-1 == val.indexOf("Google") && -1 == val.indexOf("google")) ||
      (donus = '<i class="fab fa-google-plus"></i> ' + val),
    (-1 == val.indexOf("Pinterest") && -1 == val.indexOf("pinterest")) ||
      (donus = '<i class="fab fa-pinterest"></i> ' + val),
    (-1 == val.indexOf("Twitch") && -1 == val.indexOf("twitch")) ||
      (donus = '<i class="fab fa-twitch"></i> ' + val),
    (-1 == val.indexOf("Twitch") && -1 == val.indexOf("twitch")) ||
      (donus = '<i class="fab fa-twitch"></i> ' + val),
    (-1 == val.indexOf("Snapchat") && -1 == val.indexOf("snapchat")) ||
      (donus = '<i class="fab fa-snapchat"></i> ' + val),
    (-1 == val.indexOf("soundcloud") && -1 == val.indexOf("Soundcloud")) ||
      (donus = '<i class="fab fa-soundcloud"></i> ' + val),
    (-1 == val.indexOf("periscope") && -1 == val.indexOf("Periscope")) ||
      (donus = '<i class="fab fa-periscope"></i> ' + val),
    (-1 == val.indexOf("Telegram") && -1 == val.indexOf("telegram")) ||
      (donus = '<i class="fab fa-telegram"></i> ' + val),
    donus
  );
}
function orderSelect(val) {
  $("#orderform-service").val(val),
    $("#orderform-service").trigger("change"),
    $(".title2").html(
      textToicon($("#orderform-service option[value='" + val + "']").text())
    );
}
function selectCategory(val) {
  $("#orderform-category").val(val),
    $("#orderform-category").trigger("change"),
    $("#categoryTitle").html($("button[data-cat=" + val + "]").html()),
    setTimeout(function () {
      $("#order-drop").html(""),
        $("#orderform-service option").each(function (index) {
          $("#order-drop").append(
            '<button id="categoryItem" class="dropdown-item" type="button" onclick="orderSelect(' +
              $(this).attr("value") +
              ')">' +
              textToicon($(this).text()) +
              "</button>"
          );
        }),
        $("#order-drop button:first").click();
    }, 500);
}
"payment" == subject
  ? ($("#orderSelectDiv").hide(),
    $("#paymentSelectDiv").show(),
    $("#anotherSelectDiv").hide())
  : "order" == subject
  ? ($("#orderSelectDiv").show(),
    $("#paymentSelectDiv").hide(),
    $("#anotherSelectDiv").hide())
  : "another" == subject
  ? ($("#anotherSelectDiv").show(),
    $("#orderSelectDiv").hide(),
    $("#paymentSelectDiv").hide())
  : ($("#anotherSelectDiv").hide(),
    $("#orderSelectDiv").hide(),
    $("#paymentSelectDiv").hide()),
  $(".data-expands").each(function () {
    $(this).click(function () {
      $(this).toggleClass("row-active"),
        $(this).parent().find(".expandable").toggleClass("row-open"),
        $(this).parent().find(".row-toggle").toggleClass("row-toggle-twist");
    });
  }),
  $("#category-drop button").each(function (index) {
    $(this).html(icontoText($(this).text()));
  }),
  $("#category-drop button:first").click(),
  setTimeout(function () {
    $("#order-drop").html(""),
      $("#orderform-service option").each(function (index) {
        $("#order-drop").append(
          '<button id="categoryItem" class="dropdown-item" type="button" onclick="orderSelect(' +
            $(this).attr("value") +
            ')">' +
            textToicon($(this).text()) +
            "</button>"
        );
      }),
      $("#order-drop button:first").click();
  }, 1e3),
  $(".open-pass").on("click", function (event) {
    event.preventDefault(),
      "password" == $(this).parent().find("input").attr("type")
        ? ($(this).parent().find("input").attr("type", "text"),
          $(this).parent().find(".open-pass i").addClass("fa-eye-slash"),
          $(this).parent().find(".open-pass i").removeClass("fa-eye"))
        : "text" == $(this).parent().find("input").attr("type") &&
          ($(this).parent().find("input").attr("type", "password"),
          $(this).parent().find(".open-pass i").removeClass("fa-eye-slash"),
          $(this).parent().find(".open-pass i").addClass("fa-eye"));
  });

if(window.location.href.includes("orders") || window.location.href.includes("subscriptions")) {
    document.querySelector('.container.mb-3').classList.add('container-fluid');
document.querySelector('.container.mb-3').classList.remove('container');
}