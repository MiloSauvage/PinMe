$(document).ready(function () {
    // Variables pour la sélection d'une zone
    let isSelecting = false;
    let startX, startY;
    let currentColor = "#FF7E5F"; // Couleur par défaut
    const image = $("#annotationImage");
    const selectionBox = $("#selectionBox");
    const annotations = []; // Pour stocker les annotations localement

    // Sélectionner une couleur par défaut au chargement
    $(".color-option").first().addClass("selected");

    // Gestion de la sélection de couleur
    $(".color-option").click(function () {
        $(".color-option").removeClass("selected");
        $(this).addClass("selected");
        currentColor = $(this).data("color");

        // Mettre à jour la couleur du cadre de sélection
        selectionBox.css("border-color", currentColor);
        selectionBox.css("background-color", `${currentColor}33`); // Ajout de transparence
    });

    // Début de la sélection sur l'image
    image.mousedown(function (e) {
        const imageOffset = image.offset();

        // Calcul des coordonnées relatives à l'image
        startX = e.pageX - imageOffset.left;
        startY = e.pageY - imageOffset.top;

        // Limiter les coordonnées à l'intérieur de l'image
        startX = Math.max(0, Math.min(startX, image.width()));
        startY = Math.max(0, Math.min(startY, image.height()));

        // Initialiser la boîte de sélection
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

    // Suivi du mouvement de la souris pendant la sélection
    $(document).mousemove(function (e) {
        if (!isSelecting) return;

        const imageOffset = image.offset();
        let currentX = e.pageX - imageOffset.left;
        let currentY = e.pageY - imageOffset.top;

        // Limiter les coordonnées à l'intérieur de l'image
        currentX = Math.max(0, Math.min(currentX, image.width()));
        currentY = Math.max(0, Math.min(currentY, image.height()));

        // Calcul des dimensions
        const width = Math.abs(currentX - startX);
        const height = Math.abs(currentY - startY);

        // Positionnement du rectangle en fonction de la direction du glissement
        const left = Math.min(startX, currentX);
        const top = Math.min(startY, currentY);

        // Mise à jour de la boîte de sélection
        selectionBox.css({
            left: left + "px",
            top: top + "px",
            width: width + "px",
            height: height + "px"
        });

        // Mise à jour des coordonnées affichées
        $("#selectionX").text(Math.round(left));
        $("#selectionY").text(Math.round(top));
        $("#selectionWidth").text(Math.round(width));
        $("#selectionHeight").text(Math.round(height));
    });

    // Fin de la sélection
    $(document).mouseup(function () {
        if (isSelecting) {
            isSelecting = false;
        }
    });

    // Réinitialiser la sélection
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

    // Sauvegarder l'annotation
    $("#saveAnnotation").click(function () {
        const title = $("#annotationTitle").val().trim();

        // Vérification des données
        if (!title) {
            alert("Veuillez donner un titre à votre annotation.");
            return;
        }

        if (selectionBox.width() <= 10 || selectionBox.height() <= 10) {
            alert("Veuillez sélectionner une zone plus grande sur l'image.");
            return;
        }

        // Créer une nouvelle annotation
        const annotation = {
            x: parseInt($("#selectionX").text()),
            y: parseInt($("#selectionY").text()),
            width: parseInt($("#selectionWidth").text()),
            height: parseInt($("#selectionHeight").text()),
            title: title,
            color: currentColor
        };

        let ratio = 0;
        const img = document.querySelector("#annotationImage");
        const imgWidth = img.naturalWidth;
        const imgWidthContainer = img.clientWidth;
        ratio = imgWidth / imgWidthContainer;

        $.post("./process/create-annotation.php", {
            // valeur du champs img-id de #annotationImage
            image_id: $("#annotationImage").attr("img-id"),
            pos_x: annotation.x * ratio,
            pos_y: annotation.y * ratio,
            width: annotation.width * ratio,
            height: annotation.height * ratio,
            title: annotation.title,
            color: annotation.color
        }).done(function (response) {
            alert("effectué");
            window.location.replace("./index.php");
        }).fail(function (error) {
            console.error("Erreur lors de la sauvegarde de l'annotation :", error);
            alert("Une erreur est survenue lors de la sauvegarde de l'annotation.");
        });
    });

    // Afficher une annotation sur l'image
    function displayAnnotation(annotation) {
        const annotationBox = $("<div>")
            .addClass("annotation-box")
            .css({
                left: annotation.x + "px",
                top: annotation.y + "px",
                width: annotation.width + "px",
                height: annotation.height + "px",
                borderColor: annotation.color,
                backgroundColor: `${annotation.color}33` // Avec transparence
            })
            .attr("data-id", annotation.id);

        const tooltip = $("<div>")
            .addClass("annotation-tooltip")
            .html(`<h4>${annotation.title}</h4><p>${annotation.description}</p>`)
            .css("display", "none");

        // Ajouter au conteneur
        $("#existingAnnotations").append(annotationBox);
        $("#existingAnnotations").append(tooltip);

        // Gestion du survol
        annotationBox.hover(
            function () {
                const box = $(this);
                tooltip.css({
                    left: (box.position().left + box.width() / 2) + "px",
                    top: (box.position().top + box.height() + 10) + "px",
                    display: "block"
                });
            },
            function () {
                tooltip.css("display", "none");
            }
        );
    }

    // Mettre à jour la liste des annotations
    function updateAnnotationsList() {
        const list = $("#annotationsList");

        // Vider la liste actuelle
        list.empty();

        if (annotations.length === 0) {
            list.html('<p class="no-annotations">Aucune annotation n\'existe encore pour cette image.</p>');
            return;
        }

        // Ajouter chaque annotation à la liste
        annotations.forEach(function (annotation) {
            const item = $("<div>")
                .addClass("annotation-item")
                .html(`
                    <div class="annotation-color" style="background-color: ${annotation.color}"></div>
                    <div class="annotation-item-title">${annotation.title}</div>
                    <div class="annotation-actions">
                        <button class="btn-delete" data-id="${annotation.id}">Supprimer</button>
                    </div>
                `);

            list.append(item);
        });

        // Gérer la suppression
        $(".btn-delete").click(function () {
            const id = $(this).data("id");

            // Supprimer l'annotation de la liste
            const index = annotations.findIndex(a => a.id === id);
            if (index !== -1) {
                annotations.splice(index, 1);
            }

            // Supprimer l'affichage sur l'image
            $(`.annotation-box[data-id="${id}"]`).remove();

            // Mettre à jour la liste
            updateAnnotationsList();
        });
    }

    // Initialisation
    updateAnnotationsList();
});