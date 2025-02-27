<?php

namespace support;

interface VisitableModel
{
    public function getVisitableId(): int;
    public function getVisitableType(): string;
}
