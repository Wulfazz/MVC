document.addEventListener('DOMContentLoaded', function() {
    loadTaches(); // Charge initialement toutes les tâches

    // Gestion de l'ajout d'une nouvelle tâche
    document.getElementById('addTacheForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'add');
        addTache(formData);
    });
});

// Charge les tâches depuis le serveur
function loadTaches() {
    fetch('controller/TachesController.php', {
        method: 'POST',
        body: new URLSearchParams({'action': 'getAll'})
    })
    .then(response => response.json())
    .then(data => {
        const tachesList = document.getElementById('tachesList');
        tachesList.innerHTML = '';
        data.forEach(tache => {
            const tacheElement = document.createElement('div');
            tacheElement.innerHTML = `
                <span>${tache.description}</span>
                <button onclick="deleteTache(${tache.id})">Supprimer</button>
                <button onclick="prepareEditTache(${tache.id}, '${tache.description}')">Modifier</button>
            `;
            tachesList.appendChild(tacheElement);
        });
    })
    .catch(error => console.error('Error:', error));
}

// Ajoute une nouvelle tâche
function addTache(formData) {
    fetch('controller/TachesController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            loadTaches(); // Recharge les tâches pour afficher la nouvelle
        }
    })
    .catch(error => console.error('Error:', error));
}

// Supprime une tâche
function deleteTache(id) {
    fetch('controller/TachesController.php', {
        method: 'POST',
        body: new URLSearchParams({'action': 'delete', 'id': id})
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            loadTaches(); // Recharge les tâches après la suppression
        }
    })
    .catch(error => console.error('Error:', error));
}

// Prépare l'édition d'une tâche
function prepareEditTache(id, description) {
    const editFormHTML = `
        <form id="editTacheForm">
            <input type="hidden" name="id" value="${id}">
            <input type="text" name="description" value="${description}">
            <button type="submit">Sauvegarder</button>
        </form>
    `;
    const editDiv = document.getElementById('editTacheDiv');
    editDiv.innerHTML = editFormHTML;

    document.getElementById('editTacheForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'update');
        updateTache(formData);
    });
}

// Modifie une tâche existante
function updateTache(formData) {
    fetch('controller/TachesController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            loadTaches(); // Recharge les tâches pour afficher les modifications
        }
    })
    .catch(error => console.error('Error:', error));
}
