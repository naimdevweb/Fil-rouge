<?php
class BookRepository{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); 
        }
        public function getBooks(): array {
            $sql = "SELECT livre.id, livre.titre, livre.description_courte, livre.description_longue, livre.prix, livre.photo_url, users.user_nom AS seller_nom, users.user_prenom AS user_prenom, etat AS etat, genre.nom_genre AS genre, livre.id_seller
                    FROM livre
                    INNER JOIN users ON livre.id_seller = users.id
                    INNER JOIN etat ON livre.etat_id = etat.id
                    INNER JOIN genre ON livre.genre_id = genre.id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $bookData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $books = [];
            foreach ($bookData as $data) {
                $books[] = BookMapper::mapToObject($data);
            }
    
            return $books; // Tableau d'objets Book
        }


        public function insertBook($id_seller, $titre, $description_courte, $description_longue, $prix, $etat, $genre, $url_photo): Book {
            $sql = "INSERT INTO livre (id_seller, titre, description_courte, description_longue, prix, etat_id, genre_id, photo_url) 
                    VALUES (:id_seller, :titre, :description_courte, :description_longue, :prix, :etat_id, :genre_id, :photo_url)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id_seller' => $id_seller,
                ':titre' => $titre,
                ':description_courte' => $description_courte,
                ':description_longue' => $description_longue,
                ':prix' => $prix,
                ':etat_id' => $etat,
                ':genre_id' => $genre,
                ':photo_url' => $url_photo,
            ]);
    
            // Récupérer l'ID du livre inséré
            $book_id = $this->db->lastInsertId();
    

// Récupérer les informations du livre inséré
$sql = "SELECT livre.id, livre.titre, livre.description_courte, livre.description_longue, livre.prix, livre.photo_url, users.user_nom AS seller_nom, users.user_prenom AS user_prenom, etat AS etat, genre.nom_genre AS genre, livre.id_seller
FROM livre
INNER JOIN users ON livre.id_seller = users.id
INNER JOIN etat ON livre.etat_id = etat.id
INNER JOIN genre ON livre.genre_id = genre.id
WHERE livre.id = :book_id";
$stmt = $this->db->prepare($sql);
$stmt->execute([':book_id' => $book_id]);
$bookData = $stmt->fetch(PDO::FETCH_ASSOC);

// Retourner l'objet Book
return BookMapper::mapToObject($bookData);
}

      
public function getBookById($id): ?Book {
    $sql = "SELECT livre.id, livre.titre, livre.description_courte, livre.description_longue, livre.prix, livre.photo_url, users.user_nom AS seller_nom, users.user_prenom AS user_prenom, etat AS etat, genre.nom_genre AS genre, livre.id_seller
            FROM livre
            INNER JOIN users ON livre.id_seller = users.id
            INNER JOIN etat ON livre.etat_id = etat.id
            INNER JOIN genre ON livre.genre_id = genre.id
            WHERE livre.id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $bookData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bookData) {
        return BookMapper::mapToObject($bookData);
    } else {
        return null;
    }
}




    

public function getAssociatedBooks($id): array {
    $sql = "SELECT livre.id, livre.titre, livre.description_courte, livre.description_longue, livre.prix, livre.photo_url, users.user_nom AS seller_nom, users.user_prenom AS user_prenom, etat AS etat, genre.nom_genre AS genre, livre.id_seller
            FROM livre
            INNER JOIN users ON livre.id_seller = users.id
            INNER JOIN etat ON livre.etat_id = etat.id
            INNER JOIN genre ON livre.genre_id = genre.id
            WHERE livre.id != :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $bookData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $books = [];
    foreach ($bookData as $data) {
        $books[] = BookMapper::mapToObject($data);
    }

    return $books; // Tableau d'objets Book
}


public function getBooksBySellerId($id_seller): array {
    $sql = "SELECT livre.id, livre.titre, livre.description_courte, livre.description_longue, livre.prix, livre.photo_url, users.user_nom AS seller_nom, users.user_prenom AS user_prenom, etat AS etat, genre.nom_genre AS genre, livre.id_seller
            FROM livre
            INNER JOIN users ON livre.id_seller = users.id
            INNER JOIN etat ON livre.etat_id = etat.id
            INNER JOIN genre ON livre.genre_id = genre.id
            WHERE livre.id_seller = :id_seller";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id_seller' => $id_seller]);
    $bookData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $books = [];
    foreach ($bookData as $data) {
        $books[] = BookMapper::mapToObject($data);
    }

    return $books; // Tableau d'objets Book
}




    public function getFilteredBooks(array $filters): array {
        $sql = "SELECT livre.id, livre.titre, livre.description_courte, livre.description_longue, livre.prix, livre.photo_url, users.user_nom AS seller_nom, users.user_prenom AS user_prenom, etat.etat AS etat, genre.nom_genre AS genre, livre.id_seller
                FROM livre
                INNER JOIN users ON livre.id_seller = users.id
                INNER JOIN etat ON livre.etat_id = etat.id
                INNER JOIN genre ON livre.genre_id = genre.id
                WHERE 1=1";
        $params = [];
    
        if (!empty($filters['prix'])) {
            $sql .= " AND livre.prix <= :prix";
            $params[':prix'] = $filters['prix'];
        }
    
        if (!empty($filters['genre'])) {
            $sql .= " AND genre.nom_genre = :genre";
            $params[':genre'] = $filters['genre'];
        }
    
        if (!empty($filters['etat'])) {
            $sql .= " AND etat.etat = :etat";
            $params[':etat'] = $filters['etat'];
        }
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $bookData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $books = [];
        foreach ($bookData as $data) {
            $books[] = BookMapper::mapToObject($data);
        }
    
        return $books;
    }


    public function getAllGenres(): array {
        $sql = "SELECT id, nom_genre FROM genre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $genreData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $genres = [];
        foreach ($genreData as $data) {
            $genres[] = GenreMapper::mapToObject($data);
        }
    
        return $genres;
    }
    
    public function getAllEtats(): array {
        $sql = "SELECT id, etat FROM etat";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $etatData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $etats = [];
        foreach ($etatData as $data) {
            $etats[] = EtatMapper::mapToObject($data);
        }
    
        return $etats;
    }



    public function searchBooks(string $query): array {
        $sql = "SELECT livre.id, livre.titre, livre.description_courte, livre.description_longue, livre.prix, livre.photo_url, users.user_nom AS seller_nom, users.user_prenom AS user_prenom, etat.etat AS etat, genre.nom_genre AS genre, livre.id_seller
                FROM livre
                INNER JOIN users ON livre.id_seller = users.id
                INNER JOIN etat ON livre.etat_id = etat.id
                INNER JOIN genre ON livre.genre_id = genre.id
                WHERE livre.titre LIKE :query OR livre.description_courte LIKE :query OR livre.description_longue LIKE :query";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':query' => '%' . $query . '%']);
        $bookData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $books = [];
        foreach ($bookData as $data) {
            $books[] = BookMapper::mapToObject($data);
        }
    
        return $books;
    }


    public function addToCart(int $acheteur_id, int $livre_id): void {
        // Récupérer id_seller
        $sql = "SELECT id_seller FROM livre WHERE id = :livre_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':livre_id' => $livre_id]);
        $id_seller = $stmt->fetchAll();
    
        if ($id_seller === false) {
            throw new Exception("Le vendeur pour le livre ID $livre_id n'a pas été trouvé.");
        }
    
        // Insérer dans achat
        $sql = "INSERT INTO achat (acheteur_id, livre_id, vendeur_id) 
                VALUES (:acheteur_id, :livre_id, :id_seller)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':acheteur_id' => $acheteur_id, ':livre_id' => $livre_id, ':id_seller' => $id_seller]);
    }


   public function getCartItems(int $acheteur_id): array {
    $sql = "SELECT livre.id, livre.titre, livre.description_courte, livre.description_longue, livre.prix, livre.photo_url, users.user_nom AS seller_nom, users.user_prenom AS user_prenom, etat.etat AS etat, genre.nom_genre AS genre, livre.id_seller, achat.vendeur_id
            FROM achat
            INNER JOIN livre ON achat.livre_id = livre.id
            INNER JOIN users ON livre.id_seller = users.id
            INNER JOIN etat ON livre.etat_id = etat.id
            INNER JOIN genre ON livre.genre_id = genre.id
            WHERE achat.acheteur_id = :acheteur_id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':acheteur_id' => $acheteur_id]);
    $bookData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $books = [];
    foreach ($bookData as $data) {
        $books[] = BookMapper::mapToObject($data);
    }

    return $books;
}

public function deleteAchat(int $acheteur_id, int $livre_id): void {
    $sql = "DELETE FROM achat WHERE acheteur_id = :acheteur_id AND livre_id = :livre_id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':acheteur_id', $acheteur_id, PDO::PARAM_INT);
    $stmt->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
    $stmt->execute();

}


    public function deleteBook($book_id) {
        $sql = "DELETE FROM livre WHERE id = :book_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->execute();
    }

}