<?php
// Assurez-vous d'inclure vos fichiers modèle ici
require_once '../model/Database.php'; // Pour la connexion à la base de données
require_once '../model/Tache.php'; // Le modèle spécifique pour les tâches

class TachesController {
    private $tache;

    public function __construct() {
        $this->tache = new Tache();
    }

    // Récupérer toutes les tâches
    public function getAllTaches() {
        $taches = $this->tache->getAllTaches();
        echo json_encode($taches);
    }

    // Ajouter une nouvelle tâche
    public function addTache($description, $priorite) {
        $result = $this->tache->addTache($description, $priorite);
        echo json_encode(['success' => $result]);
    }

    // Modifier une tâche existante
    public function updateTache($id, $description, $priorite) {
        $result = $this->tache->updateTache($id, $description, $priorite);
        echo json_encode(['success' => $result]);
    }

    // Supprimer une tâche
    public function deleteTache($id) {
        $result = $this->tache->deleteTache($id);
        echo json_encode(['success' => $result]);
    }
}

// Traitement des requêtes AJAX
if(isset($_POST['action'])) {
    $controller = new TachesController();

    switch($_POST['action']) {
        case 'getAll':
            $controller->getAllTaches();
            break;
        case 'add':
            if(isset($_POST['description']) && isset($_POST['priorite'])) {
                $controller->addTache($_POST['description'], $_POST['priorite']);
            }
            break;
        case 'update':
            if(isset($_POST['id']) && isset($_POST['description']) && isset($_POST['priorite'])) {
                $controller->updateTache($_POST['id'], $_POST['description'], $_POST['priorite']);
            }
            break;
        case 'delete':
            if(isset($_POST['id'])) {
                $controller->deleteTache($_POST['id']);
            }
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Action non reconnue']);
            break;
    }
} else {
    // Réponse par défaut si aucune action n'est spécifiée
    echo json_encode(['success' => false, 'message' => 'Aucune action spécifiée']);
}
?>
