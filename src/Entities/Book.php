<?php

class Book {
    private int $id;
    private string $titre;
    private string $description_courte;
    private string $description_longue;
    private float $prix;
    private string $photo_url;
    private string $seller_nom;
    private string $seller_prenom;

    public function __construct(int $id, string $titre, string $description_courte, string $description_longue, float $prix, string $photo_url, string $seller_nom, string $seller_prenom) {
        $this->id = $id;
        $this->titre = $titre;
        $this->description_courte = $description_courte;
        $this->description_longue = $description_longue;
        $this->prix = $prix;
        $this->photo_url = $photo_url;
        $this->seller_nom = $seller_nom;
        $this->seller_prenom = $seller_prenom;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getDescriptionCourte(): string {
        return $this->description_courte;
    }

    public function getDescriptionLongue(): string {
        return $this->description_longue;
    }

    public function getPrix(): float {
        return $this->prix;
    }

    public function getPhotoUrl(): string {
        return $this->photo_url;
    }

    public function getSellerNom(): string {
        return $this->seller_nom;
    }

    public function getSellerPrenom(): string {
        return $this->seller_prenom;
    }
}