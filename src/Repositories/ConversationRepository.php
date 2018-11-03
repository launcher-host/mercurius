<?php

namespace Launcher\Mercurius\Repositories;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $_mdl = config('mercurius.models.messages');

        $msg = (new $_mdl())
            ->select('id', 'message', 'sender_id', 'receiver_id', 'created_at')
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
        $mdl_messages = config('mercurius.models.messages');
        $tbl_messages = (new $mdl_messages())->getTable();

        $sql = implode(' ', array_map('trim', [
            'SELECT',
            '    mm.usr as id,',
            '    users.name as user,',
            '    users.avatar,',
            '    users.is_online,',
            '    m.sender_id as sender,',
            '    m.message,',
            '    m.seen_at,',
            '    m.created_at',
            'FROM',
            '    '.$tbl_messages.' m,',
            '    users,',
            '    (',
            '    SELECT MAX(u.id) AS id, u.usr',
            '    FROM',
            '        (',
            '        SELECT receiver_id as usr, MAX(id) AS id FROM '.$tbl_messages,
            '        WHERE deleted_by_sender IS FALSE AND sender_id ='.$user.' GROUP BY usr',
            '        UNION ALL',
            '        SELECT sender_id as usr, MAX(id) as id FROM '.$tbl_messages,
            '        WHERE deleted_by_receiver IS FALSE AND receiver_id ='.$user.' GROUP BY usr',
            '        ) u',
            '    GROUP BY u.usr',
            '    ) mm',
            'WHERE',
            '    users.id = mm.usr',
            '    AND mm.id = m.id',
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
     * @return \Illuminate\Support\Collection
     */
    public function recipients($user = null)
    {
        $user = is_null($user) ? Auth::user()->id : $user;
        $mdl_messages = config('mercurius.models.messages');
        $tbl_messages = (new $mdl_messages())->getTable();

        $_first = DB::table($tbl_messages)
                    ->select('receiver_id as id')
                    ->where([
                        ['sender_id', $user],
                        ['deleted_by_receiver', '=', false],
                    ]);

        return DB::table($tbl_messages)
                 ->select('sender_id as id')
                 ->where([
                     ['receiver_id', $user],
                     ['deleted_by_sender', '=', false],
                 ])
                 ->union($_first)
                 ->get();
    }

    /**
     * Retrieves total unread messages for a given user.
     *
     * @param int $user Default Auth() user
     *
     * @return int
     */
    public static function notifications($user = null)
    {
        try {
            $user = is_null($user) ? Auth::user()->id : $user;
            $_mdl = config('mercurius.models.messages');

            $res = $_mdl::select('sender_id')
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
            $_mdl = config('mercurius.models.messages');

            // Set messages 'deleted' for the Sender user
            (new $_mdl())
                ->where([
                    ['sender_id', $senderId],
                    ['receiver_id', $receiverId],
                ])
                ->update(['deleted_by_sender' => true]);

            (new $_mdl())
                ->where([
                    ['sender_id', $receiverId],
                    ['receiver_id', $senderId],
                ])
                ->update(['deleted_by_receiver' => true]);

            // Deletes messages, if removed from both users
            $res = (new $_mdl())
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
        $_mdl = config('mercurius.models.messages');

        return (new $_mdl())
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
