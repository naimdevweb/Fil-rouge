<?php

class GenreMapper {
    public static function mapToObject(array $data): Genre {
        if (!isset($data['id'], $data['nom_genre'])) {
            throw new InvalidArgumentException("Les clés nécessaires sont manquantes dans les données fournies.");
        }

        return new Genre(
            $data['id'],
            $data['nom_genre']
        );
    }

    public static function mapToArray(Genre $genre): array {
        return [
            'id' => $genre->getId(),
            'nom_genre' => $genre->getNomGenre()
        ];
    }
}