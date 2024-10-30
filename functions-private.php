<?php

namespace Cubit_Calculator;

defined('WPINC') || die();

function get_number_sequence_columns(string $sequence_type = GRID_TYPE_PAISLEY, bool $include_last_column = false): array
{
    $valid_sequence_types = [GRID_TYPE_PAISLEY, GRID_TYPE_CHI];

    if (!in_array($sequence_type, $valid_sequence_types)) {
        $sequence_type = GRID_TYPE_PAISLEY;
    }

    $col_defs = [
        [
            'label' => 'Royal Cubit',
            'operator' => 'mul',
            'operand' => 1.0368
        ],
        [
            'super' => 'Inch',
            'label' => '%Slope&deg;',
            'operator' => 'mul',
            'operand' => 20.736
        ],
        [
            'label' => 'Foot (Hz.)',
            'operator' => 'div',
            'operand' => 12.0
        ]
    ];

    switch ($sequence_type) {
        case GRID_TYPE_PAISLEY:
            $col_defs[] = [
                'label' => 'Yard ×8640',
                'operator' => 'div',
                'operand' => 3.0
            ];
            $col_defs[] = [
                'label' => 'Nile',
                'operator' => 'div',
                'operand' => 1728.0
            ];
            $col_defs[] = [
                'super' => 'Meter (cm)',
                'label' => '&deg;C',
                'sub' => '-273 &deg;K',
                'operator' => 'mul',
                'operand' => 1607.5102881 //1607.51029
            ];
            $col_defs[] = [
                'label' => 'Khet',
                'operator' => 'mul',
                'operand' => 0.6
            ];
            $col_defs[] = [
                'super' => 'Akhet (1.2)',
                'label' => 'Halo &times;1.0368',
                'operator' => 'mul',
                'operand' => 2.0
            ];
            $col_defs[] = [
                'label' => 'Nautical Nile',
                'operator' => 'mul',
                'operand' => 0.00045
            ];
            $col_defs[] = [
                'super' => 'Ra (Quantum)',
                'label' => '(+32 &deg;F)',
                'operator' => 'mul',
                'operand' => 1000.0 / 0.3
            ];

            if ($include_last_column) {
                $col_defs[] = [
                    'label' => 'Royal Cubit',
                    'operator' => 'mul',
                    'operand' => 1.0368
                ];

                $col_defs[0]['operator'] = 'copy';
                $col_defs[0]['operand'] = null;
            }

            break;

        case GRID_TYPE_CHI:
            $col_defs[] = [
                'label' => '2Yard',
                'operator' => 'div',
                'operand' => 6.0
            ];
            $col_defs[] = [
                'label' => 'Nile',
                'operator' => 'div',
                'operand' => 864.0
            ];
            $col_defs[] = [
                'super' => 'Meter (cm)',
                'label' => '&deg;C',
                'sub' => '-273 &deg;K',
                'operator' => 'mul',
                'operand' => 1607.5102881 //1607.51029 // 1607.5102881 //1607.51029
            ];

            $col_defs[] = [
                'label' => 'LI',
                'super' => 'Li &times;1.44',
                'operator' => 'mul',
                'operand' => 0.00288 //0.002333333
            ];
            $col_defs[] = [
                'label' => 'ChI',
                'super' => 'Chi &times;1.44',
                'operator' => 'mul',
                'operand' => 1500.0
            ];
            $col_defs[] = [
                'label' => 'Bu (ChI&times;5)',
                'super' => '&quot;Bay&quot; &times;2.88',
                'operator' => 'div',
                'operand' => 5 //10.0
            ];
            $col_defs[] = [
                'label' => 'Hasta',
                'super' => 'Cubit / 1.0368',
                'operator' => 'div', // 'mul',
                'operand' => 1.0 / 2.592
            ];

            if ($include_last_column) {
                $col_defs[] = [
                    'label' => 'Royal Cubit',
                    'operator' => 'mul',
                    'operand' => 0.833333333
                ];

                $col_defs[0]['operator'] = 'copy';
                $col_defs[0]['operand'] = null;
            } else {
                $col_defs[0]['operator'] = 'mul';
                $col_defs[0]['operand'] = 0.833333333;
            }

            break;

        default:
            // Invalid
            break;
    }

    return $col_defs;
}
