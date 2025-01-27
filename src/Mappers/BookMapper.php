<?php

class BookMapper {
    public static function mapToObject(array $data): Book {
        $requiredKeys = ['id', 'titre', 'description_courte', 'description_longue', 'prix', 'photo_url', 'seller_nom', 'user_prenom', 'etat', 'genre', 'id_seller'];
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $data)) {
                throw new InvalidArgumentException("Les clés nécessaires sont manquantes dans les données fournies.");
            }
        }

        return new Book(
            $data['id'],
            $data['titre'],
            $data['description_courte'],
            $data['description_longue'],
            $data['prix'],
            $data['photo_url'],
            $data['seller_nom'],
            $data['user_prenom'],
            $data['etat'],
            $data['genre'],
            $data['id_seller']
        );
    }

    public static function mapToArray(Book $book): array {
        return [
            'id' => $book->getId(),
            'titre' => $book->getTitre(),
            'description_courte' => $book->getDescriptionCourte(),
            'description_longue' => $book->getDescriptionLongue(),
            'prix' => $book->getPrix(),
            'photo_url' => $book->getPhotoUrl(),
            'seller_nom' => $book->getSellerNom(),
            'user_prenom' => $book->getSellerPrenom(),
            'etat' => $book->getEtat(),
            'genre' => $book->getGenre(),
            'id_seller' => $book->getIdSeller()
        ];
    }
}