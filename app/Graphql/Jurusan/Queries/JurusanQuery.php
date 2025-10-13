<?php
namespace App\GraphQL\Jurusan\Queries;

use App\Models\Jurusan\Jurusan;

use function Laravel\Prompts\search;

class JurusanQuery
{
    public function all($_, array $args)
    {
        $query = Jurusan::query();

        //Search by nama_jurusan
        if(!empty($args['search'])){
            $query->where('nama_jurusan', 'like', '%' .$args['search'].'%');
        }

        $perPage = $args['first'] ?? 10;
        $page = $args['page'] ?? 1;
        $paginator = $query->paginate($perPage, ['*'], 'page', $page);
        return [
            'data' => $paginator->items(),
            'paginatorInfo' => [
                'hasMorePages' => $paginator->hasMorePages(),
                'currentPage' => $paginator->currentPages(),
                'lastPage' => $paginator->lastPage(),
                'perPage' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ];
    }
}
