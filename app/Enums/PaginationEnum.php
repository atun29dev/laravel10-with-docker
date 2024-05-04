<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Pagination enum
 */
final class PaginationEnum extends Enum
{
    const LIMIT_DEFAULT = 10;
    const PAGE_DEFAULT = 1;
}
