<?php

class Vendeur {
    private int $id;
    private string $nom;
    private string $prenom;
    private string $nom_entreprise;
    private string $adresse_entreprise;
    private ?bool $is_approved;

    public function __construct(int $id, string $nom, string $prenom, string $nom_entreprise, string $adresse_entreprise, ?bool $is_approved) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->nom_entreprise = $nom_entreprise;
        $this->adresse_entreprise = $adresse_entreprise;
        $this->is_approved = $is_approved;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function getNomEntreprise(): string {
        return $this->nom_entreprise;
    }

    public function getAdresseEntreprise(): string {
        return $this->adresse_entreprise;
    }

    public function isApproved(): ?bool {
        return $this->is_approved;
    }
}