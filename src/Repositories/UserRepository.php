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
     * @param string $keyword
     * @param int    $limit
     *
     * @return LengthAwarePaginator
     */
    public function search(string $keyword, int $limit = 6): LengthAwarePaginator
    {
        try {
            // expect a mixed value: string|array
            $names = config('mercurius.fields.name');

            $sqlName = !is_array($names)
                ? $names
                : 'CONCAT('.implode(", ' ',", $names).') as name';

            $rawSelect = implode(', ', [
                $sqlName,
                config('mercurius.fields.slug'),
                config('mercurius.fields.avatar'),
                'is_online',
            ]);

            $users = Mercurius::user()
                ->contacts()
                ->selectRaw($rawSelect)
                ->when(is_array($names), function ($query) use ($names, $keyword) {
                    foreach ($names as $name) {
                        $query->orWhere($name, 'like', "%{$keyword}%");
                    }
                }, function ($query) use ($names, $keyword) {
                    return $query->where($names, 'like', "%{$keyword}%");
                })
                ->paginate($limit);

            return $users;
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get current user settings.
     *
     * @return array
     */
    public function getSettings(): array
    {
        $user = Auth::user();
        $name = config('mercurius.fields.name');
        $name = !is_array($name) ? $name : implode(' ', $user->only($name));

        return [
            'slug'        => $user->{config('mercurius.fields.slug')},
            'name'        => $name,
            'avatar'      => $user->{config('mercurius.fields.avatar')},
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
        $user = Mercurius::user()
            ->where(config('mercurius.fields.slug'), $slug)
            ->first();

        return $user ?: null;
    }
}
