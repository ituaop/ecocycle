<?php

namespace Src\Recycling\CollectionPoint\Domain\ValueObjects;

use InvalidArgumentException;

/**
 * Lista de categorías aceptadas por un punto de recogida.
 * Almacenada como JSON en BBDD, representada como array en dominio.
 */
class CollectionPointAcceptedCategories
{
    private const VALID = ['PLASTIC','GLASS','PAPER','METAL','ORGANIC','ELECTRONIC','OTHER'];

    /** @var string[] */
    private array $value;

    /**
     * @param string[]|string $categories  Array de categorías o JSON string
     */
    public function __construct(array|string $categories)
    {
        if (is_string($categories)) {
            $decoded = json_decode($categories, true);
            if (!is_array($decoded)) {
                throw new InvalidArgumentException("Las categorías aceptadas deben ser un array JSON válido.");
            }
            $categories = $decoded;
        }

        foreach ($categories as $cat) {
            if (!in_array(strtoupper($cat), self::VALID, true)) {
                throw new InvalidArgumentException("La categoría <{$cat}> no es válida.");
            }
        }

        $this->value = array_values(array_unique(array_map('strtoupper', $categories)));
    }

    /** @return string[] */
    public function value(): array { return $this->value; }

    public function toJson(): string { return json_encode($this->value); }

    public function accepts(string $category): bool
    {
        return in_array(strtoupper($category), $this->value, true);
    }

    public function __toString(): string { return $this->toJson(); }
}
