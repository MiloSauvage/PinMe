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
            } catch (error) {
                modalContent.innerHTML = `<p>Erreur lors du chargement du contenu.</p>`;
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
        });
    });
}
