<?php

namespace App\GraphQL\Ekstrakurikuler\Mutations;

use App\Models\Ekstrakurikuler\Ekstrakurikuler;

class EkstrakurikulerMutation
{
    public function update($_, array $args)
    {
        $level = Ekstrakurikuler::withTrashed()->findOrFail($args['id_ekskul']);
        $level->restore();
        return $level;
    }

    public function restore($_, array $args)
    {
        $level = Ekstrakurikuler::withTrashed()->findOrFail($args['id_ekskul']);
        $level->restore();
        return $level;
    }

    public function forceDelete($_, array $args)
    {
        $level = Ekstrakurikuler::withTrashed()->findOrFail($args['id_ekskul']);
        $level->forceDelete();
        return $level;
    }
}
