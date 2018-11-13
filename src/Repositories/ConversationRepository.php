<?php

namespace Launcher\Mercurius\Repositories;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Launcher\Mercurius\Facades\Mercurius;

class ConversationRepository
{
    /**
     * Retrieve a single conversation for two given users.
     *
     * @param int $receiver
     * @param int $offset   Pagination offset
     * @param int $limit    Pagination limit
     * @param int $sender   Optional, default Auth() user
     *
     * @return \Illuminate\Support\Collection
     */
    public function get($receiver, $offset = 0, $limit = 10, $sender = null)
    {
        $sender = is_null($sender) ? Auth::user()->id : $sender;

        $msg = Mercurius::model('message')
            ->select('id', 'message', 'sender_id', 'seen_at', 'created_at')
            ->with('sender:id,slug')
            ->where([
                ['sender_id', $sender],
                ['receiver_id', $receiver],
                ['deleted_by_sender', '=', false],
            ])
            ->orWhere([
                ['sender_id', $receiver],
                ['receiver_id', $sender],
                ['deleted_by_receiver', '=', false],
            ])
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Transform output
        $msg = $msg->map(function ($msg) {
            return [
                'id'         => $msg->id,
                'message'    => $msg->message,
                'sender'     => $msg->sender->slug,
                'seen_at'    => $msg->seen_at,
                'created_at' => date($msg->created_at),
            ];
        });

        if ($offset === 0) {
            $this->makeSeen($receiver, $sender);
        }

        return $msg;
    }

    /**
     * Make a conversation seen.
     *
     * @param int $receiver
     * @param int $sender
     *
     * @return void
     */
    private function makeSeen($receiver, $sender)
    {
        $this->userConversations($receiver, $sender)
             ->update(['seen_at' => Carbon::now()]);
    }

    /**
     * Retrieve all user conversations, grouped by recipient id.
     *
     * @param int $user Default Auth() user
     *
     * @return \Illuminate\Support\Collection
     */
    public function all($user = null)
    {
        $user = is_null($user) ? Auth::user()->id : $user;
        $tbl_users = Mercurius::model('user')->getTable();
        $tbl_messages = Mercurius::model('message')->getTable();
        $slug = config('mercurius.fields.slug');
        $name = config('mercurius.fields.name');
        $name = !is_array($name)
                    ? 'users.'.$name
                    : 'CONCAT(users.'.implode(", ' ', users.", $name).')';

        $sql = implode(' ', array_map('trim', [
            'SELECT',
            '    users.'.$slug.' as slug,',
            '    '.$name.' as user,',
            '    users.'.config('mercurius.fields.avatar').',',
            '    users.is_online,',
            '    sender.'.$slug.' as sender,',
            '    m.message,',
            '    m.seen_at,',
            '    m.created_at',
            'FROM',
            '    '.$tbl_messages.' m,',
            '    '.$tbl_users.' users,',
            '    '.$tbl_users.' sender,',
            '    (',
            '        SELECT MAX(u.id) AS id, u.usr',
            '        FROM',
            '        '.$tbl_users.',',
            '        (',
            '            SELECT receiver_id as usr, MAX(id) AS id FROM '.$tbl_messages,
            '            WHERE deleted_by_sender IS FALSE AND sender_id ='.$user.' GROUP BY usr',
            '            UNION ALL',
            '            SELECT sender_id as usr, MAX(id) as id FROM '.$tbl_messages,
            '            WHERE deleted_by_receiver IS FALSE AND receiver_id ='.$user.' GROUP BY usr',
            '        ) u',
            '        GROUP BY u.usr',
            '    ) mm',
            'WHERE',
            '    users.id = mm.usr',
            '    AND mm.id = m.id',
            '    AND sender.id = m.sender_id',
            'ORDER BY',
            '    m.created_at DESC',
        ]));

        return DB::select(DB::raw($sql));
    }

    /**
     * Retrieves all recipients with active conversations with a given user.
     *
     * @param int $user Default Auth() user
     *
     * @return array
     */
    public function recipients($user = null): array
    {
        $user = is_null($user) ? Auth::user()->id : $user;
        $tbl_users = Mercurius::model('user')->getTable();
        $tbl_messages = Mercurius::model('message')->getTable();

        $sql = implode(' ', array_map('trim', [
            'SELECT DISTINCT',
            '    users.'.config('mercurius.fields.slug').' as slug',
            'FROM '.$tbl_users.' users, ',
            '(',
            '    SELECT receiver_id as id FROM '.$tbl_messages,
            '    WHERE sender_id ='.$user.' AND deleted_by_sender IS FALSE',
            '    UNION ALL',
            '    SELECT sender_id as id FROM '.$tbl_messages,
            '    WHERE receiver_id ='.$user.' AND deleted_by_receiver IS FALSE',
            ') mr',
            'WHERE users.id = mr.id',
        ]));

        return array_pluck(DB::select(DB::raw($sql)), 'slug');
    }

    /**
     * Retrieves total unread messages for a given user.
     *
     * @param int $user Default Auth() user
     *
     * @return int
     */
    public function notifications($user = null)
    {
        try {
            $user = is_null($user) ? Auth::user()->id : $user;

            $res = Mercurius::model('message')
                    ->select('sender_id')
                    ->where('receiver_id', '=', $user)
                    ->whereNull('seen_at')
                    ->count();

            return ['status' => true, 'total' => $res];
        } catch (Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }

    /**
     * Deletes a given conversation between two given users.
     *
     * Note: conversations are permanently removed from the system
     * WHEN REMOVED FROM BOTH USERS: Sender and Receiver.
     *
     * @param int $senderId
     * @param int $receiverId
     *
     * @return \Illuminate\Support\Collection
     */
    public function delete($senderId, $receiverId)
    {
        try {
            // Set messages 'deleted' for the Sender user
            Mercurius::model('message')
                ->where([
                    ['sender_id', $senderId],
                    ['receiver_id', $receiverId],
                ])
                ->update(['deleted_by_sender' => true]);

            Mercurius::model('message')
                ->where([
                    ['sender_id', $receiverId],
                    ['receiver_id', $senderId],
                ])
                ->update(['deleted_by_receiver' => true]);

            // Deletes messages, if removed from both users
            $res = Mercurius::model('message')
                ->where([
                    ['sender_id', $senderId],
                    ['receiver_id', $receiverId],
                    ['deleted_by_sender', '=', true],
                ])
                ->Where([
                    ['sender_id', $receiverId],
                    ['receiver_id', $senderId],
                    ['deleted_by_receiver', '=', true],
                ])
                ->delete();

            return ['status' => true];
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Return User conversation with a given recipient.
     *
     * @param int $recipient
     *
     * @return object
     */
    private function userConversations($sender, $receiver)
    {
        return Mercurius::model('message')
            ->where([
                ['sender_id', $sender],
                ['receiver_id', $receiver],
                ['deleted_by_sender', '=', false],
            ])
            ->orWhere([
                ['sender_id', $receiver],
                ['receiver_id', $sender],
                ['deleted_by_receiver', '=', false],
            ]);
    }
}
