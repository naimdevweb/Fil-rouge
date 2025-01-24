<?php

class BookMapper {
    public static function mapToObject(array $data): Book {
        if (!isset($data['id'], $data['titre'], $data['description_courte'], $data['description_longue'], $data['prix'], $data['photo_url'], $data['seller_nom'], $data['seller_prenom'])) {
            throw new InvalidArgumentException("Les clés nécessaires sont manquantes dans les données fournies.");
        }

        return new Book(
            $data['id'],
            $data['titre'],
            $data['description_courte'],
            $data['description_longue'],
            $data['prix'],
            $data['photo_url'],
            $data['seller_nom'],
            $data['seller_prenom']
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
            'seller_prenom' => $book->getSellerPrenom()
        ];
    }
}