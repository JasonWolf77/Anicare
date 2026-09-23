<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidIdentificationException;

final class Identification
{
    public const TYPE_TRANSPONDEUR = 'transpondeur';
    public const TYPE_TATOUAGE = 'tatouage';

    private const CODE_PAYS_FRANCE = '250';

    private function __construct(
        private readonly string $type,
        private readonly string $numero
    ) {
        $this->validate();
    }

    public static function fromTranspondeur(string $numero): self
    {
        return new self(self::TYPE_TRANSPONDEUR, $numero);
    }

    public static function fromTatouage(string $numero): self
    {
        return new self(self::TYPE_TATOUAGE, strtoupper($numero));
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getNumero(): string
    {
        return $this->numero;
    }

    public function isTranspondeur(): bool
    {
        return $this->type === self::TYPE_TRANSPONDEUR;
    }

    public function isTatouage(): bool
    {
        return $this->type === self::TYPE_TATOUAGE;
    }

    /**
     * Extrait le code pays (uniquement pour transpondeur).
     */
    public function getCodePays(): ?string
    {
        if (!$this->isTranspondeur()) {
            return null;
        }
        return substr($this->numero, 0, 3);
    }

    /**
     * Extrait le code groupe d'espèce (uniquement pour transpondeur).
     */
    public function getCodeEspece(): ?string
    {
        if (!$this->isTranspondeur()) {
            return null;
        }
        return substr($this->numero, 3, 2);
    }

    public function equals(self $other): bool
    {
        return $this->type === $other->type
            && $this->numero === $other->numero;
    }

    private function validate(): void
    {
        match ($this->type) {
            self::TYPE_TRANSPONDEUR => $this->validateTranspondeur(),
            self::TYPE_TATOUAGE    => $this->validateTatouage(),
            default                => throw new InvalidIdentificationException(
                sprintf('Type d\'identification inconnu : %s', $this->type)
            ),
        };
    }

    private function validateTranspondeur(): void
    {
        // Vérification : 15 chiffres exactement
        if (!preg_match('/^\d{15}$/', $this->numero)) {
            throw new InvalidIdentificationException(
                'Le numéro de transpondeur doit contenir exactement 15 chiffres.'
            );
        }

        // Vérification : code pays France = 250
        if (!str_starts_with($this->numero, self::CODE_PAYS_FRANCE)) {
            throw new InvalidIdentificationException(
                'Le code pays du transpondeur doit être 250 (France).'
            );
        }
    }

    private function validateTatouage(): void
    {
        // Format : 3 chiffres + 3 lettres OU 3 lettres + 3 chiffres
        if (!preg_match('/^(\d{3}[A-Z]{3}|[A-Z]{3}\d{3})$/', $this->numero)) {
            throw new InvalidIdentificationException(
                'Le numéro de tatouage doit respecter le format 3 chiffres + 3 lettres ou 3 lettres + 3 chiffres.'
            );
        }
    }

    public function __toString(): string
    {
        return sprintf('%s (%s)', $this->numero, $this->type);
    }
}