<?php

namespace App\GraphQL\Kelas\Queries;

use App\Models\Kelas\Kelas;

use function Laravel\Prompts\search;

class KelasQuery
{
    public function all($_, array $args)
    {
        $query = Kelas::query();

        //Search by nama_Kelas
        if (!empty($args['search'])) {
            $query->where('nama_kelas', 'like', '%' . $args['search'] . '%');
        }

        $perPage = $args['first'] ?? 10;
        $page = $args['page'] ?? 1;
        $paginator = $query->paginate($perPage, ['*'], 'page', $page);
        return [
            'data' => $paginator->items(),
            'paginatorInfo' => [
                'hasMorePages' => $paginator->hasMorePages(),
                'currentPage' => $paginator->currentPage(),
                'lastPage' => $paginator->lastPage(),
                'perPage' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ];
    }
}
