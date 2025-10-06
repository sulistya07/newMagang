<?php

namespace App\GraphQL\Kelas\Mutations;

use App\Models\Kelas\Kelas;

class KelasMutation
{
    public function restore($_, array $args)
    {
        $level = Kelas::withTrashed()->findOrFail($args['id_kelas']);
        $level->restore();
        return $level;
    }

    public function forceDelete($_, array $args)
    {
        $level = Kelas::withTrashed()->findOrFail($args['id_kelas']);
        $level->forceDelete();
        return $level;
    }
}
