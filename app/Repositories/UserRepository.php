<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends EloquentRepository implements \App\Contracts\Repositories\UserRepositoryInterface
{
    protected array $allowedFilters = [];

    protected array $allowedSorts = [];

    public function boot(): void
    {
        parent::boot();
    }

    public function model(): string
    {
        return User::class;
    }
    public function suggestedFriends(int $limit = 20)
    {
        $userId = auth()->id();

        $sub = DB::table('friends as f1')
            ->join('friends as f2', 'f1.friend_id', '=', 'f2.friend_id')
            ->where('f1.user_id', $userId)
            ->where('f2.user_id', '<>', $userId)
            ->selectRaw('f2.user_id as candidate_id, COUNT(*) as mutual_count')
            ->groupBy('f2.user_id');

        $alreadyFriends = DB::table('friends')
            ->where('user_id', $userId)
            ->pluck('friend_id');

        $pendingOutgoing = DB::table('friend_requests')
            ->where('user_id', $userId)
            ->whereNull('accepted_at')
            ->pluck('friend_id');

        $pendingIncoming = DB::table('friend_requests')
            ->where('friend_id', $userId)
            ->whereNull('accepted_at')
            ->pluck('user_id');

        return $this->makeModel()->newQuery()
            ->leftJoinSub($sub, 'mf', function ($join) {
                $join->on('users.id', '=', 'mf.candidate_id');
            })
            ->where('users.id', '<>', $userId)
            ->whereNull('users.deleted_at')
            ->whereNotIn('users.id', $alreadyFriends)
            ->whereNotIn('users.id', $pendingOutgoing)
            ->whereNotIn('users.id', $pendingIncoming)
            ->with('profile.avatar')
            ->orderByDesc('mf.mutual_count')
            ->orderByDesc('users.created_at')
            ->select(['users.*', DB::raw('COALESCE(mf.mutual_count, 0) as mutual_friends_count')]);
    }
}
