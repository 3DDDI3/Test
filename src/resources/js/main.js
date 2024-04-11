$(function () {
    if (location.href.match(/#openModal/)) location = location.href.replace(/#openModal/, "");

    $("input[name='inputFile']").change(function (e) {
        e.preventDefault();

        if ($(".input-file-list").children().length > 0)
            $(".input-file-list div").empty();

        if ($(this).get(0).files.length > 5) {
            alert("Выбрано больше 5 файлов");
            return;
        }
        var formData = new FormData();
        for (let i = 0; i < this.files.length; i++) {
            formData.append(`file${i + 1}`, this.files[i]);
            let file = this.files[i];
            let reader = new FileReader();
            reader.readAsDataURL(this.files[i]);
            reader.onload = function () {
                $(".input-file-list").append(`<div><img src="${reader.result}"><span>${file.name}</span></div>`);
            }
        }

        $.ajax({
            type: "POST",
            url: "/api/image/upload",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            dataType: "html",
            success: function (response) {
                $(".table tbody").append(response);
            }
        });

    });


    $("tbody").on("click", "tr td:not(:last-child)", function (e) {
        e.preventDefault();
        location.href = "/#openModal";
        let id = $(this).parent().children()[0].getAttribute("data-id");

        $.ajax({
            type: "GET",
            url: `/api/images/${id}`,
            dataType: "json",
            success: function (response) {
                $(".modal-body").html(`<img src="${response.src}">`);
                $(".modal-title").text(`Название - ${response.name}`);
            }
        });
    });

    $("tbody").on("click", "tr td svg.zip-icon", function (e) {
        e.preventDefault();
        let id = $(this).closest("tr").children()[0].getAttribute("data-id");

        $.ajax({
            type: "GET",
            url: `/api/createZip/${id}`,
            dataType: "json",
            success: function (response) {
                console.log(`/api/download/${id}`, response);
                window.location.href = `/api/download/${id}`;
            }
        });
    });

    $('tr th:not(:last-child)').click(function (e) {
        e.preventDefault();

        let data = {
            order: $(this).attr("data-order"),
            field: $(this).attr("data-field")
        }

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
            success: function (response) {
                $(".table tbody").html(response);
            }
        });
    });
});

