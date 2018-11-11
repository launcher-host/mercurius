<?php

namespace Launcher\Mercurius\Repositories;

use Launcher\Mercurius\Events\MessageSent;
use Launcher\Mercurius\Facades\Mercurius;

class MessageRepository
{
    /**
     * Send a message.
     *
     * Message is broadcast to WebSocket using Pusher.
     *
     * @param int    $senderId
     * @param int    $receiverId
     * @param string $message
     *
     * @return \Illuminate\Support\Collection
     */
    public function send(int $senderId, int $receiverId, string $message)
    {
        try {
            $msg = Mercurius::model('message');

            $msg->sender_id = $senderId;
            $msg->receiver_id = $receiverId;
            $msg->message = $message;

            $msg->save();

            broadcast(new MessageSent($msg->receiver, $msg->sender, $msg))->toOthers();

            $out = [
                'id'         => $msg->id,
                'message'    => $msg->message,
                'sender'     => $msg->sender->slug,
                'seen_at'    => $msg->seen_at,
                'created_at' => date($msg->created_at),
            ];

            return $out;
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Delete a message.
     *
     * Messages are permanently removed from the system when removed from
     * both users: Sender and Receiver.
     *
     * @param \Launcher\Mercurius\Models\Message $message
     * @param int                                $user
     *
     * @return \Illuminate\Support\Collection
     */
    public function delete($msg, $user)
    {
        try {
            if (!in_array($user, [$msg->sender_id, $msg->receiver_id])) {
                return ['status' => false, 'message' => 'Unauthorized'];
            }

            // Set message 'deleted' for the current user only
            if ($msg->sender_id == $user) {
                $msg->deleted_by_sender = true;
            } else {
                $msg->deleted_by_receiver = true;
            }

            // If message is marked deleted for both users (sender and receiver)
            // we remove the message from the database.
            if ($msg->deleted_by_sender === true && $msg->deleted_by_receiver === true) {
                $msg->delete();
            } else {
                $msg->save();
            }

            return ['status' => true];
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
