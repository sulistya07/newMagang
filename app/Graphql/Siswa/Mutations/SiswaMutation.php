<?php

namespace App\GraphQL\Siswa\Mutations;

use App\Models\Siswa\Siswa;

class SiswaMutation
{
    public function restore($_, array $args)
    {
        $level = Siswa::withTrashed()->findOrFail($args['id_siswa']);
        $level->restore();
        return $level;
    }

    public function forceDelete($_, array $args)
    {
        $level = Siswa::withTrashed()->findOrFail($args['id_siswa']);
        $level->forceDelete();
        return $level;
    }
}
