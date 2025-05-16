$(document).ready(function () {
    let isSelecting = false;
    let startX, startY;
    let currentColor = "#FF7E5F";
    const image = $("#annotationImage");
    const selectionBox = $("#selectionBox");

    $(".color-option").first().addClass("selected");

    $(".color-option").click(function () {
        $(".color-option").removeClass("selected");
        $(this).addClass("selected");
        currentColor = $(this).data("color");
        selectionBox.css({
            borderColor: currentColor,
            backgroundColor: `${currentColor}33`
        });
    });

    image.mousedown(function (e) {
        const imageOffset = image.offset();
        startX = Math.max(0, Math.min(e.pageX - imageOffset.left, image.width()));
        startY = Math.max(0, Math.min(e.pageY - imageOffset.top, image.height()));
        selectionBox.css({
            left: startX + "px",
            top: startY + "px",
            width: 0,
            height: 0,
            display: "block",
            borderColor: currentColor,
            backgroundColor: `${currentColor}33`
        });
        isSelecting = true;
    });

    $(document).mousemove(function (e) {
        if (!isSelecting) return;
        const imageOffset = image.offset();
        let currentX = Math.max(0, Math.min(e.pageX - imageOffset.left, image.width()));
        let currentY = Math.max(0, Math.min(e.pageY - imageOffset.top, image.height()));
        const width = Math.abs(currentX - startX);
        const height = Math.abs(currentY - startY);
        const left = Math.min(startX, currentX);
        const top = Math.min(startY, currentY);
        selectionBox.css({
            left: left + "px",
            top: top + "px",
            width: width + "px",
            height: height + "px"
        });
        $("#selectionX").text(Math.round(left));
        $("#selectionY").text(Math.round(top));
        $("#selectionWidth").text(Math.round(width));
        $("#selectionHeight").text(Math.round(height));
    });

    $(document).mouseup(function () {
        if (isSelecting) isSelecting = false;
    });

    $("#resetSelection").click(function () {
        selectionBox.css({
            display: "none",
            width: 0,
            height: 0
        });
        $("#selectionX").text("0");
        $("#selectionY").text("0");
        $("#selectionWidth").text("0");
        $("#selectionHeight").text("0");
        $("#annotationTitle").val("");
    });

    $("#saveAnnotation").click(function () {
        const title = $("#annotationTitle").val().trim();
        if (!title) {
            alert("Veuillez donner un titre à votre annotation.");
            return;
        }
        if (selectionBox.width() <= 10 || selectionBox.height() <= 10) {
            alert("Veuillez sélectionner une zone plus grande sur l'image.");
            return;
        }
        const annotation = {
            x: parseInt($("#selectionX").text()),
            y: parseInt($("#selectionY").text()),
            width: parseInt($("#selectionWidth").text()),
            height: parseInt($("#selectionHeight").text()),
            title: title,
            color: currentColor
        };
        const img = document.querySelector("#annotationImage");
        const ratio = img.naturalWidth / img.clientWidth;
        $.post("./process/create-annotation.php", {
            image_id: $("#annotationImage").attr("img-id"),
            pos_x: annotation.x * ratio,
            pos_y: annotation.y * ratio,
            width: annotation.width * ratio,
            height: annotation.height * ratio,
            title: annotation.title,
            color: annotation.color
        }).done(function () {
            window.location.replace("./index.php");
        }).fail(function (error) {
            console.error("Erreur lors de la sauvegarde de l'annotation :", error);
            alert("Une erreur est survenue lors de la sauvegarde de l'annotation.");
        });
    });
});
