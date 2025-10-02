<?php

namespace App\GraphQL\Jurusan\Mutations;

use App\Models\Jurusan\Jurusan;

class JurusanMutation
{
    public function restore($_, array $args)
    {
            $level = Jurusan::withTrashed()->findOrFail($args['id_jurusan']);
            $level->restore();
            return $level;
    }

    public function forceDelete($_, array $args)
    {
        $level = Jurusan::withTrashed()->findOrFail($args['id_jurusan']);
        $level->forceDelete();
        return $level;
    }
}


