<?php

class UserMapper {
    public static function mapToObject(array $data): User {
        $requiredKeys = ['id', 'user_nom', 'user_prenom', 'user_email', 'user_tel', 'user_mdp', 'role_id'];
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $data)) {
                throw new InvalidArgumentException("Les clés nécessaires sont manquantes dans les données fournies.");
            }
        }

        return new User(
            $data['user_nom'],
            $data['user_prenom'],
            $data['user_email'],
            $data['role_id'],
            $data['user_tel'],
            $data['user_mdp'],
            (int) $data['id']
        );
    }

    public static function mapToArray(User $user): array {
        return [
            'id' => $user->getId(),
            'user_nom' => $user->getNom(),
            'user_prenom' => $user->getPrenom(),
            'user_email' => $user->getEmail(),
            'role_id' => $user->getRoleId(),
            'user_tel' => $user->getTel(),
            'user_mdp' => $user->getPassword()
        ];
    }
}