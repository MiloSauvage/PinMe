// On attend bien la fin du chargement de la page avant d'exécuter le script
window.onload = () => {
    // Récupération de tous les boutons d'ouverture de modal
    const modalButtons = document.querySelectorAll("[data-toggle=modal]");

    modalButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            // On epêche la navigation ( ne peut pas naviger à l'intérieur du href)
            e.preventDefault();
            // On récupère le data-target du bouton cliqué
            const target = button.getAttribute('data-target');
            // On récupère la modal correspondante
            const modal = document.querySelector(target);
            // On affiche la modal
            modal.classList.add('show');
        });
    });

    // Récupération de tous les boutons de fermeture de modal
    const modalClose = modal.querySelectorAll("[data-dismiss=post]");
    modalClose.forEach(button => {
        button.addEventListener('click', (e) => {
            // On empêche la navigation ( ne peut pas naviguer à l'intérieur du href)
            e.preventDefault();
            // On récupère la modal correspondante
            const modal = button.closest('.modal');
            // On cache la modal
            modal.classList.remove('show');
        });
    });
}