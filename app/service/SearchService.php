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

        $keyword = preg_replace('/[^\p{L}\p{N}\p{M}_]+/u', ' ', $keyword);
        $builder = $model::whereFullText($by, $keyword, ['mode' => 'boolean']);

        return $builder->get($columns);
    }
}
