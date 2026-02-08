<?php

namespace App\Traits;

trait TimestampsPortugues
{
    public function getCreatedAtColumn(): string
    {
        return 'data_cadastro';
    }

    public function getUpdatedAtColumn(): string
    {
        return 'data_alteracao';
    }

    public function getDeletedAtColumn(): string
    {
        return 'data_exclusao';
    }
}
