<?php

class Genre {
    private int $id;
    private string $nom_genre;

    public function __construct(int $id, string $nom_genre) {
        $this->id = $id;
        $this->nom_genre = $nom_genre;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNomGenre(): string {
        return $this->nom_genre;
    }
}