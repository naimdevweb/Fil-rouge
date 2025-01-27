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


    public function deleteBook($book_id) {
        $sql = "DELETE FROM livre WHERE id = :book_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->execute();
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

}