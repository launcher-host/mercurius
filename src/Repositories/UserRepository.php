<?php

namespace Launcher\Mercurius\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    /**
     * Perform a search.
     *
     * @param string $query
     * @param int    $limit
     *
     * @return LengthAwarePaginator
     */
    public function search(string $query, int $limit = 6): LengthAwarePaginator
    {
        $userFqcn = config('mercurius.models.user');

        return $userFqcn::where('name', 'LIKE', '%'.$query.'%')
            ->paginate($limit, [
                'id',
                'name',
                'avatar',
                'is_online',
            ]);
    }
}
