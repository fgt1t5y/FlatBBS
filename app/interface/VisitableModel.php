<?php

namespace app\interface;

interface VisitableModel
{
    public function getVisitableId(): int;
    public function getVisitableType(): string;
}
