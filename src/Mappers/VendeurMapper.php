<?php

class VendeurMapper {
    public static function mapToObject(array $data): Vendeur {
        // Ajoutez des messages de débogage
        error_log("Données fournies à VendeurMapper::mapToObject: " . print_r($data, true));

        if (!isset($data['user_id'], $data['user_nom'], $data['user_prenom'], $data['nom_entreprise'], $data['adresse_entreprise'])) {
            throw new InvalidArgumentException("Les clés nécessaires sont manquantes dans les données fournies.");
        }

        // Gérer les valeurs NULL pour is_approved
        $isApproved = isset($data['is_approved']) ? (bool) $data['is_approved'] : null;

        return new Vendeur(
            (int) $data['user_id'],
            $data['user_nom'],
            $data['user_prenom'],
            $data['nom_entreprise'],
            $data['adresse_entreprise'],
            $isApproved
        );
    }

    public static function mapToArray(Vendeur $vendeur): array {
        return [
            'user_id' => $vendeur->getId(),
            'user_nom' => $vendeur->getNom(),
            'user_prenom' => $vendeur->getPrenom(),
            'nom_entreprise' => $vendeur->getNomEntreprise(),
            'adresse_entreprise' => $vendeur->getAdresseEntreprise(),
            'is_approved' => $vendeur->isApproved()
        ];
    }
}