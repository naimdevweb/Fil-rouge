<?php
class BookRepository{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); 
        }
        public function getBooks(): array {
            $sql = "SELECT livre.id, livre.titre, livre.description_courte, livre.description_longue, livre.prix, livre.photo_url, users.user_nom AS seller_nom, users.user_prenom AS seller_prenom
                    FROM livre
                    INNER JOIN users ON livre.id_seller = users.id"; // Assurez-vous que 'id_seller' est le bon nom de colonne
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
            $sql = "SELECT livre.id, livre.titre, livre.description_courte, livre.description_longue, livre.prix, livre.photo_url, users.user_nom AS seller_nom, users.user_prenom AS seller_prenom
                    FROM livre
                    INNER JOIN users ON livre.id_seller = users.id
                    WHERE livre.id = :book_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':book_id' => $book_id]);
            $bookData = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Retourner l'objet Book
            return BookMapper::mapToObject($bookData);
        }


      
        public function getBookById($id): ?Book {
            $sql = "SELECT l.id, l.photo_url, l.titre, l.description_courte, l.description_longue, l.prix, l.id_seller, l.etat_id, e.etat, g.nom_genre AS genre_nom
                    FROM livre l
                    JOIN etat e ON l.etat_id = e.id
                    JOIN genre g ON l.genre_id = g.id
                    WHERE l.id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $livreData = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$livreData) {
                return null;
            }
    
            return BookMapper::mapToObject($livreData);
        }
    

    

        public function getAssociatedBooks($id): array {
            $sql = "SELECT l.id, l.photo_url, l.titre, l.description_courte, l.description_longue, l.prix, l.id_seller, l.etat_id, e.etat, g.nom_genre AS genre_nom
                    FROM livre l
                    JOIN etat e ON l.etat_id = e.id
                    JOIN genre g ON l.genre_id = g.id
                    WHERE l.id != :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $livreData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $livresAssocies = [];
            foreach ($livreData as $data) {
                $livresAssocies[] = BookMapper::mapToObject($data);
            }
            return $livresAssocies;
        }


        public function getBooksBySellerId($id_seller): array {
            $sql = "SELECT l.id, l.photo_url, l.titre, l.description_courte, l.description_longue, l.prix, l.id_seller, l.etat_id, e.etat, g.nom_genre AS genre_nom
                    FROM livre l
                    JOIN etat e ON l.etat_id = e.id
                    JOIN genre g ON l.genre_id = g.id
                    WHERE l.id_seller = :id_seller";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_seller', $id_seller, PDO::PARAM_INT);
            $stmt->execute();
            $livreData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $livres = [];
            foreach ($livreData as $data) {
                $livres[] = BookMapper::mapToObject($data);
            }
            return $livres;
        }
    


    public function deleteBook($book_id) {
        $sql = "DELETE FROM livre WHERE id = :book_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->execute();
    }

}