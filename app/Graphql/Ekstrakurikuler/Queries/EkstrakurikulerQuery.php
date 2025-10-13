<?php

namespace App\GraphQL\Ekstrakurikuler\Queries;

use App\Models\Ekstrakurikuler\Ekstrakurikuler;

class EkstrakurikulerQuery
{
    public function all($_, array $args)
    {
        $query = Ekstrakurikuler::query();

        // Search by nama_ekskul
        if (!empty($args['search'])) {
            $query->where('nama_ekskul', 'like', '%' . $args['search'] . '%');
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
