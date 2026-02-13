<?php

namespace App\Enums;

enum ProductoEstado: string
{
    case TODOS = '';
    case ACTIVO = '1';
    case DESCATALOGADO = '2';

    public function label(): string
    {
        return match($this) {
            self::TODOS => 'Todos',
            self::ACTIVO => 'Activo',
            self::DESCATALOGADO => 'Descatalogado',
        };
    }

    public static function options(): array{
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }

 public static function iconData(?self $estado): array
{
    return match($estado) {
        self::ACTIVO => [
            'component' => 'icon.thumbs-up',
            'class' => 'w-5 h-5 text-green-500',
        ],
        self::DESCATALOGADO => [
            'component' => 'icon.thumbs-down',
            'class' => 'w-5 h-5 text-red-500',
        ],
        default => [
            'component' => 'icon.question-solid-full',
            'class' => 'w-5 h-5 text-black',
        ],
    };
}
}
