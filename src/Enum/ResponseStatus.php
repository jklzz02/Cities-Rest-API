<?php

namespace Jklzz02\RestApi\Enum;

enum ResponseStatus: int {
    case SUCCESS = 200;
    case CREATED = 201;
    case NO_CONTENT = 204;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case CONFLICT = 409;
    case INTERNAL_ERROR = 500;
}