<?php

class EtatMapper {
    public static function mapToObject(array $data): Etat {
        if (!isset($data['id'], $data['etat'])) {
            throw new InvalidArgumentException("Les clés nécessaires sont manquantes dans les données fournies.");
        }

        return new Etat(
            $data['id'],
            $data['etat']
        );
    }

    public static function mapToArray(Etat $etat): array {
        return [
            'id' => $etat->getId(),
            'etat' => $etat->getNomEtat()
        ];
    }
}