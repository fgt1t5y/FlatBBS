<?php

namespace app\service;

use support\Model;

class SearchService
{
    public function search(string $keyword, Model|string $model, string $by, ?array $columns = ['*'])
    {
        if ($keyword == '' || $columns == []) {
            return null;
        }
        $response = response();

        $result = $model::whereRaw("MATCH(`$by`) AGAINST(?)", [$keyword])
            ->get($columns);
        return $response->setData($result)->success();
    }
}
