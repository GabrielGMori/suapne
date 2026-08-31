<?php

namespace App\Support;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class Formatter
{
    public static function format(string $attribute, mixed $value): string
    {
        if ($value === null) {
            return '—';
        }

        return match ($attribute) {
            'cpf' => self::cpf($value),
            'telefone',
            'telefone_pai',
            'telefone_mae',
            'telefone_responsavel' => self::telefone($value),
            'data' => self::datetime($value),
            'data_nascimento' => self::date($value),
            'created_at' => self::datetime($value),
            'updated_at' => self::datetime($value),
            'periodo_inicio' => self::date($value),
            'periodo_fim' => self::date($value),
            'campos' => self::json($value),
            'path' => self::path($value),
            default => (string) $value,
        };
    }

    public static function cpf(?string $value): ?string
    {
        if (!$value) {
            return $value;
        }

        return preg_replace(
            '/(\d{3})(\d{3})(\d{3})(\d{2})/',
            '$1.$2.$3-$4',
            preg_replace('/\D/', '', $value)
        );
    }

    public static function telefone(?string $value): ?string
    {
        if (!$value) {
            return $value;
        }

        $value = preg_replace('/\D/', '', $value);

        return match (strlen($value)) {
            10 => '+55 ' . preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $value),
            11 => '+55 ' . preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $value),
            13 => '+55 ' . preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', substr($value, 2)),
            default => $value,
        };
    }

    public static function date(?string $value): ?string
    {
        if (!$value) {
            return $value;
        }

        return Carbon::parse($value)->format('d/m/Y');
    }

    public static function datetime(?string $value): ?string
    {
        if (!$value) {
            return $value;
        }

        return Carbon::parse($value)->format('d/m/Y \à\s H:i');
    }

    public static function json(?string $value): ?string
    {
        if (!$value) {
            return $value;
        }

        return json_encode(json_decode($value), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public static function path(?string $value): ?string
    {
        if (!$value) {
            return $value;
        }

        return Request::getSchemeAndHttpHost() . '/storage/' . ltrim($value, '/');
    }
}
