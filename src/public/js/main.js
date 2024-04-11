/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
$(function () {
  if (location.href.match(/#openModal/)) location = location.href.replace(/#openModal/, "");
  $("input[name='inputFile']").change(function (e) {
    var _this = this;
    e.preventDefault();
    if ($(".input-file-list").children().length > 0) $(".input-file-list div").empty();
    if ($(this).get(0).files.length > 5) {
      alert("Выбрано больше 5 файлов");
      return;
    }
    var formData = new FormData();
    var _loop = function _loop() {
      formData.append("file".concat(i + 1), _this.files[i]);
      var file = _this.files[i];
      var reader = new FileReader();
      reader.readAsDataURL(_this.files[i]);
      reader.onload = function () {
        $(".input-file-list").append("<div><img src=\"".concat(reader.result, "\"><span>").concat(file.name, "</span></div>"));
      };
    };
    for (var i = 0; i < this.files.length; i++) {
      _loop();
    }
    $.ajax({
      type: "POST",
      url: "/api/image/upload",
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      dataType: "html",
      success: function success(response) {
        console.log(response);
        $(".table tbody").append(response);
      }
    });
  });
  $("tbody").on("click", "tr td:not(:last-child)", function (e) {
    e.preventDefault();
    location.href = "/#openModal";
    var id = $(this).parent().children()[0].getAttribute("data-id");
    $.ajax({
      type: "GET",
      url: "/api/images/".concat(id),
      dataType: "json",
      success: function success(response) {
        $(".modal-body").html("<img src=\"".concat(response.src, "\">"));
        $(".modal-title").text("\u041D\u0430\u0437\u0432\u0430\u043D\u0438\u0435 - ".concat(response.name));
      }
    });
  });
  $("tbody").on("click", "tr td svg.zip-icon", function (e) {
    e.preventDefault();
    var id = $(this).closest("tr").children()[0].getAttribute("data-id");
    $.ajax({
      type: "GET",
      url: "/api/createZip/".concat(id),
      dataType: "json",
      success: function success(response) {
        console.log("/api/download/".concat(id), response);
        window.location.href = "/api/download/".concat(id);
      }
    });
  });
  $('tr th:not(:last-child)').click(function (e) {
    e.preventDefault();
    var data = {
      order: $(this).attr("data-order"),
      field: $(this).attr("data-field")
    };
    if ($(this).hasClass("sortByAsc")) {
      $("tr th").removeClass("sortByAsc");
      $("tr th").removeClass("sortByDesc");
      $(this).addClass("sortByDesc");
      $(this).attr("data-order", 'desc');
    } else {
      $("tr th").removeClass("sortByAsc");
      $("tr th").removeClass("sortByDesc");
      $(this).addClass("sortByAsc");
      $(this).attr("data-order", 'asc');
    }
    $.ajax({
      type: "GET",
      url: "/api/images/sort",
      dataType: "html",
      data: data,
      success: function success(response) {
        $(".table tbody").html(response);
      }
    });
  });
});
/******/ })()
;