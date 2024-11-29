<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Example export data enum
 */
final class ExampleExcelExportDataEnum extends Enum
{
    const DATA = [
        [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@doe.com',
            ],
            [
                'id' => 2,
                'name' => 'Smith Doe',
                'email' => 'smith@doe.com',
            ],
            [
                'id' => 3,
                'name' => 'Mike Doe',
                'email' => 'mike@doe.com',
            ],
        ],
        [
            [
                'id' => 1,
                'name' => 'Mark Doe',
                'email' => 'mark@doe.com',
            ],
            [
                'id' => 2,
                'name' => 'Lisa Doe',
                'email' => 'lisa@doe.com',
            ],
            [
                'id' => 3,
                'name' => 'Vibe Doe',
                'email' => 'vibe@doe.com',
            ],
        ],
        [
            [
                'id' => 1,
                'name' => 'Bon Doe',
                'email' => 'bon@doe.com',
            ],
            [
                'id' => 2,
                'name' => 'May Doe',
                'email' => 'may@doe.com',
            ],
            [
                'id' => 3,
                'name' => 'Martin Doe',
                'email' => 'martin@doe.com',
            ],
        ],
    ];
}
