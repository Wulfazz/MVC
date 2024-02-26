<?php
class Tache {
    private $db;

    public function __construct() {
        // Assurez-vous que la classe Database est bien implémentée pour gérer la connexion
        $this->db = new Database();
    }

    // Récupérer toutes les tâches
    public function getAllTaches() {
        $this->db->query("SELECT * FROM Taches ORDER BY id DESC");
        return $this->db->resultSet();
    }

    // Ajouter une tâche
    public function addTache($description, $priorite) {
        $this->db->query("INSERT INTO Taches (description, priorite) VALUES (:description, :priorite)");
        // Liaison des valeurs
        $this->db->bind(':description', $description);
        $this->db->bind(':priorite', $priorite);

        // Exécution
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Mettre à jour une tâche
    public function updateTache($id, $description, $priorite) {
        $this->db->query("UPDATE Taches SET description = :description, priorite = :priorite WHERE id = :id");
        // Liaison des valeurs
        $this->db->bind(':id', $id);
        $this->db->bind(':description', $description);
        $this->db->bind(':priorite', $priorite);

        // Exécution
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Supprimer une tâche
    public function deleteTache($id) {
        $this->db->query("DELETE FROM Taches WHERE id = :id");
        // Liaison de l'id
        $this->db->bind(':id', $id);

        // Exécution
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
