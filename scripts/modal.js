window.onload = () => {
    const modalButtons = document.querySelectorAll("[data-toggle=modal]");

    modalButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const target = button.getAttribute('data-target');
            const id = button.getAttribute('post-id');
            const modal = document.querySelector(target);
            modal.classList.add('show');
            const modalContent = modal.querySelector('.modal-content');

            try {
                const response = await fetch(`utils/post-modal.php?id=${id}`);
                if (!response.ok) throw new Error("Erreur de chargement du contenu");
                const html = await response.text();
                modalContent.innerHTML = html;

                // Wait for image to load before calculating positions
                const img = document.querySelector(".post-image");
                if (img) {
                    // If image is already loaded, position annotations immediately
                    if (img.complete) {
                        positionAnnotations(img);
                    } else {
                        // Otherwise wait for image to load
                        img.onload = () => positionAnnotations(img);
                    }
                }
            } catch (error) {
                modalContent.innerHTML = `
            <div class="error-message">
              Erreur lors du chargement du contenu.
            </div>
          `;
                console.error(error);
            }

            const modalClose = modal.querySelectorAll("[data-dismiss=post]");
            modalClose.forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.remove('show');
                });
            });

            const modalDelete = modal.querySelectorAll("[data-delete=post]");
            modalDelete.forEach(button => {
                button.addEventListener('click', async () => {
                    const response = await fetch(`process/remove-post.php?id=${id}`);
                    location.reload();
                });
            });

            modal.addEventListener('click', () => {
                modal.classList.remove('show');
            });

            modal.children[0].addEventListener('click', (e) => {
                e.stopPropagation();
            });

            const annotationDeleteButtons = modal.querySelectorAll('.annotation-delete-btn');

            annotationDeleteButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    if (e.target && e.target.classList.contains('annotation-delete-btn')) {
                        e.preventDefault(); s

                        const annotationId = e.target.getAttribute('data-annotation-id');
                        deleteAnnotation(annotationId);
                    }
                });
            });


            async function deleteAnnotation(annotationId) {
                try {
                    // Préparation des données pour la requête POST
                    const formData = new FormData();
                    formData.append('id', annotationId);
                    // Envoi de la requête
                    const response = await fetch('process/delete-annotation.php', {
                        method: 'POST',
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error('Erreur lors de la suppression');
                    }

                    const result = await response.json();

                    if (result.success) {
                        // Suppression réussie - on supprime l'élément du DOM
                        const annotationElement = document.querySelector(`.annotation-marker[data-id="${annotationId}"]`);
                        if (annotationElement) {
                            annotationElement.remove();
                        }
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                }
            }

        });
    });

    // Function to position annotations correctly
    function positionAnnotations(img) {
        // Get image's displayed dimensions
        const imgDisplayWidth = img.clientWidth;
        const imgDisplayHeight = img.clientHeight;

        // Get image's natural dimensions
        const imgNaturalWidth = img.naturalWidth;
        const imgNaturalHeight = img.naturalHeight;

        // Calculate width and height ratio
        const widthRatio = imgDisplayWidth / imgNaturalWidth;
        const heightRatio = imgDisplayHeight / imgNaturalHeight;

        // Get the image's position relative to its container
        const imgRect = img.getBoundingClientRect();
        const containerRect = img.parentElement.getBoundingClientRect();

        // Calculate image's position relative to container
        const imgOffsetLeft = imgRect.left - containerRect.left;
        const imgOffsetTop = imgRect.top - containerRect.top;

        // Get all annotation markers
        const annotations = document.querySelectorAll(".annotation-marker");

        annotations.forEach(annotation => {
            // Get annotation data
            const annotationWidth = parseFloat(annotation.getAttribute("data-width"));
            const annotationHeight = parseFloat(annotation.getAttribute("data-height"));
            const annotationLeft = parseFloat(annotation.getAttribute("data-pos-x"));
            const annotationTop = parseFloat(annotation.getAttribute("data-pos-y"));

            // Calculate new dimensions based on ratios
            const newWidth = annotationWidth * widthRatio;
            const newHeight = annotationHeight * heightRatio;

            // Calculate new positions based on ratios and considering image offset
            const newLeft = (annotationLeft * widthRatio) + imgOffsetLeft;
            const newTop = (annotationTop * heightRatio) + imgOffsetTop;

            // Apply new styles
            annotation.style.width = `${newWidth}px`;
            annotation.style.height = `${newHeight}px`;

            // Override the transform property for correct positioning
            annotation.style.transform = "none";
            annotation.style.left = `${newLeft}px`;
            annotation.style.top = `${newTop}px`;
        });
    }
};