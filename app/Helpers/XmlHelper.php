<?php

namespace App\Helpers;

/**
 * Helper para tratamento de dados XML
 */
class XmlHelper
{
    /**
     * Extrai valor de campo XML que pode vir como array vazio [] ou com dados
     */
    public static function extractFromXml($value): mixed
    {
        if (is_array($value) && empty($value)) {
            return null;
        }

        if (is_string($value) && trim($value) === '') {
            return null;
        }

        return $value;
    }

    /**
     * Extrai string de campo XML, tratando arrays
     */
    public static function extractString($value): ?string
    {
        $extracted = self::extractFromXml($value);

        if (is_array($extracted)) {
            return isset($extracted[0]) && $extracted[0] !== '' ? (string) $extracted[0] : null;
        }

        return is_string($extracted) ? trim($extracted) : null;
    }

    /**
     * Extrai array de campo XML
     */
    public static function extractArray($value): ?array
    {
        $extracted = self::extractFromXml($value);
        return is_array($extracted) && !empty($extracted) ? $extracted : null;
    }

    /**
     * Extrai boolean de campo XML
     */
    public static function extractBoolean($value): bool
    {
        $extracted = self::extractFromXml($value);

        if (is_bool($extracted)) {
            return $extracted;
        }

        if (is_string($extracted)) {
            return in_array(strtolower(trim($extracted)), ['1', 'true', 'yes', 'sim']);
        }

        if (is_numeric($extracted)) {
            return (int) $extracted === 1;
        }

        return false;
    }

    /**
     * Extrai número/float de campo XML
     */
    public static function extractNumber($value): ?float
    {
        $extracted = self::extractFromXml($value);

        if (is_numeric($extracted)) {
            return (float) $extracted;
        }

        if (is_string($extracted)) {
            // Remove formatação brasileira (R$ 1.234,56 -> 1234.56)
            $cleaned = preg_replace('/[R$\s]/', '', $extracted);
            $cleaned = str_replace('.', '', $cleaned); // Remove separador de milhares
            $cleaned = str_replace(',', '.', $cleaned); // Troca vírgula por ponto

            return is_numeric($cleaned) ? (float) $cleaned : null;
        }

        return null;
    }

    /**
     * Extrai inteiro de campo XML
     */
    public static function extractInteger($value): ?int
    {
        $number = self::extractNumber($value);
        return $number !== null ? (int) $number : null;
    }

    /**
     * Extrai data de campo XML
     */
    public static function extractDate($value, string $format = 'd/m/Y H:i:s'): ?string
    {
        $extracted = self::extractString($value);

        if (!$extracted) {
            return null;
        }

        try {
            $date = \DateTime::createFromFormat($format, $extracted);
            return $date ? $date->format('Y-m-d H:i:s') : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Verifica se um valor XML está vazio (array vazio ou string vazia)
     */
    public static function isEmpty($value): bool
    {
        return self::extractFromXml($value) === null;
    }

    /**
     * Extrai primeiro valor de array ou retorna o valor se não for array
     */
    public static function extractFirst($value): mixed
    {
        $extracted = self::extractFromXml($value);

        if (is_array($extracted)) {
            return $extracted[0] ?? null;
        }

        return $extracted;
    }
}
