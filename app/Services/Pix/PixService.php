<?php

namespace App\Services\Pix;

use App\Models\Pix;

class PixService
{
    public function criar(array $dados): Pix
    {
        return Pix::create($dados);
    }

    public function buscarPeloId(int $id): ?Pix
    {
        return Pix::find($id);
    }

    public function atualizar(int $id, array $dados): ?Pix
    {
        $pix = $this->buscarPeloId($id);
        if ($pix) {
            $pix->update($dados);
            return $pix;
        }
        return null;
    }

    public function deletar(int $id): bool
    {
        $pix = $this->buscarPeloId($id);
        if ($pix) {
            $pix->delete();
            return true;
        }
        return false;
    }
}
