<?php

namespace Launcher\Mercurius\Repositories;

use Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Launcher\Mercurius\Facades\Mercurius;

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
        return Mercurius::user()
            ->where('name', 'LIKE', '%'.$query.'%')
            ->paginate($limit, [
                'slug',
                'name',
                'avatar',
                'is_online',
            ]);
    }

    /**
     * Get current user settings.
     *
     * @return array
     */
    public function getSettings(): array
    {
        $user = Auth::user();

        return [
            'slug'        => $user->slug,
            'name'        => $user->name,
            'avatar'      => $user->avatar,
            'is_online'   => (bool) $user->is_online,
            'be_notified' => (bool) $user->be_notified,
            'dark_mode'   => true,  // This is saved at LocalStorage
        ];
    }

    /**
     * Find User for a given slug.
     *
     * @param string $slug
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function find(string $slug)
    {
        $user = Mercurius::user()->where('slug', $slug)->first();

        return $user ?: null;
    }
}
