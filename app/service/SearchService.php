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

        $builder = $model::whereFullText($by, $keyword);

        return $builder->get($columns);
    }
}
