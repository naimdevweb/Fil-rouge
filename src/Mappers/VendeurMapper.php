<?php

class VendeurMapper {
    public static function mapToObject(array $data): Vendeur {
        if (!isset($data['user_id'], $data['nom_entreprise'], $data['adresse_entreprise'])) {
            throw new InvalidArgumentException("Les clés nécessaires sont manquantes dans les données fournies.");
        }

        return new Vendeur(
            (int) $data['user_id'],
            $data['nom_entreprise'],
            $data['adresse_entreprise']
        );
    }

    public static function mapToArray(Vendeur $vendeur): array {
        return [
            'user_id' => $vendeur->getUserId(),
            'nom_entreprise' => $vendeur->getNomEntreprise(),
            'adresse_entreprise' => $vendeur->getAdresseEntreprise()
        ];
    }
}