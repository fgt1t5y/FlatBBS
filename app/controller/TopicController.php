<?php

namespace app\controller;

use app\model\Board;
use app\model\Topic;
use app\service\SearchService;
use app\service\TopicService;
use support\Request;

class TopicController
{
    private $topicBasicFields = [
        'id',
        'title',
        'author_id',
        'board_id',
        'reply_count',
        'created_at'
    ];

    protected SearchService $search;
    protected TopicService $topic;

    public function __construct(SearchService $search, TopicService $topic)
    {
        $this->search = $search;
        $this->topic = $topic;
    }

    public function all(Request $request)
    {
        $last_id = (int) $request->post('last');
        $limit = (int) $request->post('limit');

        $response = $this->topic->all($last_id, $limit, $this->topicBasicFields);

        return $response->toJson();
    }

    public function list(Request $request, string $slug)
    {
        $last_id = (int) $request->post('last');
        $limit = (int) $request->post('limit');

        $response = $this->topic->list($slug, $last_id, $limit, $this->topicBasicFields);

        return $response->toJson();
    }

    public function search(Request $request)
    {
        $keyword = $request->post('q');

        $response = $this->search->search($keyword, Topic::class, 'title');

        if (!$response->isSuccess()) {
            no(STATUS_INTERNAL_ERROR);
        }

        return $response->toJson();
    }
}
