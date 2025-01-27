<?php

class UserRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); 
    }

    public function getAllUsers(): array {
        $sql = "SELECT id, user_nom, user_prenom, user_email, user_tel, user_mdp, role_id FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($userData as $data) {
            $users[] = UserMapper::mapToObject($data);
        }

        return $users; // Tableau d'objets User
    }

    public function getAllUsersExceptAdmin(): array {
        $sql = "SELECT * FROM users WHERE role_id != 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $users = [];
        foreach ($userData as $data) {
            $users[] = UserMapper::mapToObject($data);
        }
    
        return $users;
    }

    

    public function getRoleNameById($role_id): string {
        switch ($role_id) {
            case 2:
                return 'Professionnel';
            case 3:
                return 'Client';
            default:
                return 'Inconnu';
        }
    }

    


    public function userExists($email, $nom): ?User {
        $sql = "SELECT * FROM users WHERE user_email = :email OR user_nom = :nom";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':nom' => $nom
        ]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$userData) {
            return null;
        }
    
        return UserMapper::mapToObject($userData);
    }

    
    public function getUserById($user_id) {
        $sql = "SELECT * FROM users WHERE id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   


   public function updateUser($user_id, $user_nom, $user_prenom, $user_email, $user_tel, $user_password): bool {
        $sql = "UPDATE users SET user_nom = :user_nom, user_prenom = :user_prenom, user_email = :user_email, user_tel = :user_tel, user_mdp = :user_mdp WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_nom' => $user_nom,
            ':user_prenom' => $user_prenom,
            ':user_email' => $user_email,
            ':user_tel' => $user_tel,
            ':user_mdp' => $user_password,
            ':id' => $user_id
        ]);

        return $stmt->rowCount() > 0;
    }


    
    public function updateUserPassword($user_id, $hashed_password) {
        $sql_update_password = "UPDATE users SET user_mdp = :user_mdp WHERE id = :id";
        $stmt_update_password = $this->db->prepare($sql_update_password);
        $stmt_update_password->execute([
           ':user_mdp' => $hashed_password,
           ':id' => $user_id,
        ]);
    }

    

    public function Create(User $user): void {
        $sql = "INSERT INTO users (user_email, user_nom, user_prenom, user_tel, user_mdp, role_id) 
                VALUES (:user_email, :user_nom, :user_prenom, :user_tel, :user_mdp, :role_id)";
        $stmt = $this->db->prepare($sql);
        $params = UserMapper::mapToArray($user);
        $stmt->execute([
            ':user_email' => $params['user_email'],
            ':user_nom' => $params['user_nom'],
            ':user_prenom' => $params['user_prenom'],
            ':user_tel' => $params['user_tel'],
            ':user_mdp' => $params['user_mdp'],
            ':role_id' => $params['role_id']
        ]);
    }

    public function getLastInsertId(): int {
        return $this->db->lastInsertId();
    }
    

    public function insertVendeur(Vendeur $vendeur): void {
        $sql = "INSERT INTO vendeur (user_id, adresse_entreprise, nom_entreprise) VALUES (:user_id, :adresse_entreprise, :nom_entreprise)";
        $stmt = $this->db->prepare($sql);
        $params = VendeurMapper::mapToArray($vendeur);
        $stmt->execute([
            ':user_id' => $params['user_id'],
            ':adresse_entreprise' => $params['adresse_entreprise'],
            ':nom_entreprise' => $params['nom_entreprise']
        ]);
    }


    public function getVendeurByUserId($user_id): ?Vendeur {
        $sql = "SELECT v.user_id, u.user_nom, u.user_prenom, v.nom_entreprise, v.adresse_entreprise, v.is_approved 
                FROM vendeur v
                INNER JOIN users u ON v.user_id = u.id
                WHERE v.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $vendeurData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$vendeurData) {
            return null;
        }

        return VendeurMapper::mapToObject($vendeurData);
    }


    public function getVendeurs(): array {
       
        $sql = "SELECT v.user_id, u.user_nom, u.user_prenom, v.nom_entreprise, v.adresse_entreprise ,v.is_approved
                FROM vendeur v
                INNER JOIN users u ON v.user_id = u.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $vendeurData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $vendeurs = [];
        foreach ($vendeurData as $data) {
          
            error_log("Données récupérées pour un vendeur: " . print_r($data, true));
            $vendeurs[] = VendeurMapper::mapToObject($data);
        }

        return $vendeurs;
    }

    
    public function validerVendeur($id) {
        $sql = "UPDATE vendeur SET is_approved = TRUE WHERE user_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function refuserVendeur($id) {
        $sql = "UPDATE vendeur SET is_approved = FALSE WHERE user_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getVendeursTraites(): array {
        $sql = "SELECT v.user_id, u.user_nom, u.user_prenom, v.nom_entreprise, v.adresse_entreprise, v.is_approved 
                FROM vendeur v
                INNER JOIN users u ON v.user_id = u.id
                WHERE v.is_approved IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $vendeurData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $vendeurs = [];
        foreach ($vendeurData as $data) {
            $vendeurs[] = VendeurMapper::mapToObject($data);
        }
    
        return $vendeurs;
    }

    public function getVendeursEnAttente(): array {
        $sql = "SELECT v.user_id, u.user_nom, u.user_prenom, v.nom_entreprise, v.adresse_entreprise, v.is_approved 
                FROM vendeur v
                INNER JOIN users u ON v.user_id = u.id
                WHERE v.is_approved IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $vendeurData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $vendeurs = [];
        foreach ($vendeurData as $data) {
            $vendeurs[] = VendeurMapper::mapToObject($data);
        }
    
        return $vendeurs;
    }


    public function updateUserRole($user_id, $role_id): void {
        $sql = "UPDATE users SET role_id = :role_id WHERE id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    

    
   
   public function getUserData(int $user_id): ?User {
    $sql = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        return null;
    }

    return UserMapper::mapToObject($userData);
}
    
    public function getUserBooks($seller_id) {
        $stmt = $this->db->prepare("SELECT * FROM livre WHERE id_seller = :id_seller");
        $stmt->execute(['id_seller' => $seller_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail(string $email): ?User {
        $sql = "SELECT * FROM users WHERE user_email = :user_email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_email' => $email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$userData) {
            return null;
        }

        return UserMapper::mapToObject($userData);
    }


    public function deleteUser($id) {
        // Commencer une transaction
        $this->db->beginTransaction();
    
        try {
            // Vérifier si l'utilisateur est un vendeur
            $sql = "SELECT role_id FROM users WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([":id" => $id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user && $user['role_id'] == 2) { 
                $sql = "DELETE FROM vendeur WHERE user_id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([":id" => $id]);
            }
    
           
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([":id" => $id]);
    
            // Valider la transaction
            $this->db->commit();
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->db->rollBack();
            throw $e;
        }
    }
}