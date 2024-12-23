<?php

namespace app\service;

use app\model\Topic;
use app\model\Board;
use app\model\User;
use Carbon\Carbon;

class TopicService
{
    public array $topic_detail_columns = ['id', 'board_id', 'author_id', 'like_count', 'title', 'content', 'created_at'];

    public function all(int $last_id, int $limit)
    {
        return Topic::orderByDesc('last_reply_at')
            ->limit(min($limit, 50))
            ->where('id', $last_id === 0 ? '>' : '<', $last_id)
            ->get(['id', 'board_id', 'like_count', 'author_id', 'title', 'text', 'created_at']);
    }

    public function build(string $title, string $text, string $content, Board $board, User $author)
    {
        $topic = new Topic;

        $topic->title = trim($title);
        $topic->text = trim($text);
        $topic->content = $content ?? '<p></p>';
        $topic->board_id = $board->id;
        $topic->author_id = $author->id;
        $topic->last_reply_at = Carbon::now();

        return $topic;
    }

    public function detail(int $topic_id)
    {
        return Topic::find($topic_id, $this->topic_detail_columns);
    }

    public function toggle_like(int $topic_id, int $user_id)
    {
        $topic = Topic::find($topic_id);

        if (!$topic) {
            return null;
        }

        $is_liked = $topic->likes()->where('user_id', $user_id)->exists();

        if ($is_liked) {
            $topic->likes()->detach($user_id);
            $topic->like_count--;
            $topic->save();
        } else {
            $topic->likes()->attach($user_id, ['type' => 1]);
            $topic->like_count++;
            $topic->save();
        }

        return $topic->like_count;
    }
}
