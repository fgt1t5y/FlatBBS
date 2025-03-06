<?php

// HTTP Status Code
const STATUS_OK = 200;
const STATUS_BAD_REQUEST = 400;
const STATUS_UNAUTHORIZED = 401;
const STATUS_FORBIDDEN = 403;
const STATUS_NOT_FOUND = 404;
const STATUS_INTERNAL_ERROR = 500;

// Group ID
const GROUP_ADMIN = 1;
const GROUP_GUEST = 2;
const GROUP_USER = 100;

putenv('APP_PATH=' . base_path());
