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
                document.preventDefault();

            });
        });
    });





    function positionAnnotations(img) {
        const imgDisplayWidth = img.clientWidth;
        const imgDisplayHeight = img.clientHeight;

        const imgNaturalWidth = img.naturalWidth;
        const imgNaturalHeight = img.naturalHeight;

        const widthRatio = imgDisplayWidth / imgNaturalWidth;
        const heightRatio = imgDisplayHeight / imgNaturalHeight;

        const imgRect = img.getBoundingClientRect();
        const containerRect = img.parentElement.getBoundingClientRect();

        const imgOffsetLeft = imgRect.left - containerRect.left;
        const imgOffsetTop = imgRect.top - containerRect.top;

        const annotations = document.querySelectorAll(".annotation-marker");

        annotations.forEach(annotation => {
            const annotationWidth = parseFloat(annotation.getAttribute("data-width"));
            const annotationHeight = parseFloat(annotation.getAttribute("data-height"));
            const annotationLeft = parseFloat(annotation.getAttribute("data-pos-x"));
            const annotationTop = parseFloat(annotation.getAttribute("data-pos-y"));

            const newWidth = annotationWidth * widthRatio;
            const newHeight = annotationHeight * heightRatio;

            const newLeft = (annotationLeft * widthRatio) + imgOffsetLeft;
            const newTop = (annotationTop * heightRatio) + imgOffsetTop;

            annotation.style.width = `${newWidth}px`;
            annotation.style.height = `${newHeight}px`;

            annotation.style.transform = "none";
            annotation.style.left = `${newLeft}px`;
            annotation.style.top = `${newTop}px`;
        });
    }
};