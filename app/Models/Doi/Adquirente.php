<?php

namespace App\Models\Doi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adquirente extends Model
{
    use HasFactory, SoftDeletes;
    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
    const DELETED_AT = 'data_exclusao';

    protected $table = 'doi_adquirente';
    protected $fillable = [
        'doi_id',
        'data',
    ];
    protected $casts = [
        'data' => 'json',
    ];
}
