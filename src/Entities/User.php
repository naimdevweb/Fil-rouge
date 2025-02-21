<?php

class User {
    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $email;
    private int $roleId;
    private string $tel;
    private string $password;
    private ?string $pseudo; // Ajoutez cette ligne si vous avez besoin de la propriété pseudo

    public function __construct(string $nom, string $prenom, string $email, int $roleId, string $tel, string $password, ?int $id = null, ?string $pseudo = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->roleId = $roleId;
        $this->tel = $tel;
        $this->password = $password;
        $this->pseudo = $pseudo; // Initialisez la propriété pseudo
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getEmail(): string { return $this->email; }
    public function getRoleId(): int { return $this->roleId; }
    public function getTel(): string { return $this->tel; }
    public function getPassword(): string { return $this->password; }
    public function getPseudo(): ?string { return $this->pseudo; } // Ajoutez cette méthode si vous avez besoin d'accéder à la propriété pseudo
}