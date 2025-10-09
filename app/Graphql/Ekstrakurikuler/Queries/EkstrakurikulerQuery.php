<?php

namespace App\Graphql\Ekstrakurikuler\Queries;

use App\Models\Ekstrakurikuler\Ekstrakurikuler;

use function Laravel\Prompts\search;

class EkstrakurikulerQuery
{
    public function all($_, array $args)
    {
        $query = Ekstrakurikuler::query();

        //Search by nama_ekstrakurikuler
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
                'currentPage' => $paginator->currentPages(),
                'lastPage' => $paginator->lastPages(),
                'perPage' => $paginator->perPages(),
                'total' => $paginator->total(),
            ],
        ];
    }
}
