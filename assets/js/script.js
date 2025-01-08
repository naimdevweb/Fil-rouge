// Fonction pour afficher ou masquer le formulaire en fonction du choix du rôle
document.getElementById('role').addEventListener('change', function() {
    const role = this.value;
    const professionnelForm = document.getElementById('professionnelForm');

    // Si 'Professionnel' est sélectionné (valeur 2), afficher le formulaire
    if (role === '2') {
        professionnelForm.classList.remove('hidden');
    } else {
        professionnelForm.classList.add('hidden');
    }
});