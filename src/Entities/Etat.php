<?php

class Etat {
    private int $id;
    private string $etat;

    public function __construct(int $id, string $etat) {
        $this->id = $id;
        $this->etat = $etat;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNomEtat(): string {
        return $this->etat;
    }
}