<?php

namespace App\GraphQL\Siswa\Queries;

use App\Models\Siswa\Siswa;

class SiswaQuery
{
    public function all($_, array $args)
    {
        $query = Siswa::query();

        //Search by nis dan nama
        if (!empty($args['search'])) {
                 $query->where('nis', 'like', '%' . $args[ 'search' ]. '%')
                    ->orWhere('nama', 'like', '%' . $args[ 'search' ] . '%');
            }
        

        $perPage = $args['first'] ?? 10;
        $page = $args['page'] ?? 1;
        $paginator = $query->paginate($perPage, ['*'], 'page', $page);
        return [
            'data' => $paginator->items(),
            'paginatorInfo' => [
                'hasMorePages' => $paginator->hasMorePages(),
                'currentPage' => $paginator->currentPages(),
                'lastPage' => $paginator->lastPages(),
                'perPage' => $paginator->perPages(),
                'total' => $paginator->total(),
            ],
        ];
    }
}
