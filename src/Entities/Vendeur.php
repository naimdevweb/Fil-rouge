<?php

class Vendeur {
    private int $user_id;
    private string $nom_entreprise;
    private string $adresse_entreprise;

    public function __construct(int $user_id, string $nom_entreprise, string $adresse_entreprise) {
        $this->user_id = $user_id;
        $this->nom_entreprise = $nom_entreprise;
        $this->adresse_entreprise = $adresse_entreprise;
    }

    public function getUserId(): int {
        return $this->user_id;
    }

    public function getNomEntreprise(): string {
        return $this->nom_entreprise;
    }

    public function getAdresseEntreprise(): string {
        return $this->adresse_entreprise;
    }
}