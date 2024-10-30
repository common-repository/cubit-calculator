<?php

namespace Cubit_Calculator;

defined('WPINC') || die();

function do_shortcode_number_grid($atts)
{
    $html = '';

    if (is_admin() || wp_doing_ajax()) {
        // Don't do anything.
    } else {
        $args = shortcode_atts(
            [
                'headings' => DEFAULT_SHOW_HEADINGS,
                'last_col' => DEFAULT_SHOW_LAST_COLUMN,
                'rows' => DEFAULT_ROW_COUNT,
                'animate' => DEFAULT_ENABLE_ANIMATIONS,
                'decimals' => DEFAULT_NUMBER_OF_DECIMALS,
                'caption' => sprintf(
                    '%s: <a href="https://cubit-calculator.one/">https://cubit-calculator.one</a>', // Maybe make this filterable?
                    __('For more information', 'cubit-calculator')
                ),
                'step' => DEFAULT_INCDEC_STEP,
                'sharing' => DEFAULT_ENABLE_SHARING,
                'copycsv' => DEFAULT_ENABLE_COPY_CSV,
                'type' => GRID_TYPE_PAISLEY
            ],
            $atts
        );

        $args['headings'] = (bool) filter_var($args['headings'], FILTER_VALIDATE_BOOLEAN);
        $args['last_col'] = (bool) filter_var($args['last_col'], FILTER_VALIDATE_BOOLEAN);
        $args['animate'] = (bool) filter_var($args['animate'], FILTER_VALIDATE_BOOLEAN);
        $args['rows'] = intval($args['rows']);
        $args['decimals'] = intval($args['decimals']);
        $args['caption'] = (string) apply_filters('tvbcc_table_caption', $args['caption']);
        $args['step'] = floatval($args['step']);
        $args['sharing'] = (bool) filter_var($args['sharing'], FILTER_VALIDATE_BOOLEAN);
        $args['copycsv'] = (bool) filter_var($args['copycsv'], FILTER_VALIDATE_BOOLEAN);

        // Sanity check
        if ($args['decimals'] < 1) {
            $args['decimals'] = 1;
        }
        if ($args['decimals'] > 20) {
            $args['decimals'] = 20;
        }
        if ($args['step'] < 0.0) {
            $args['step'] - DEFAULT_INCDEC_STEP;
        }

        global $wvbcc_have_number_grid_assets_been_enqueued;
        if (is_null($wvbcc_have_number_grid_assets_been_enqueued)) {
            $handle = 'cubit-calc';

            wp_enqueue_style($handle, CUBIT_CALC_ASSETS_URL . 'number-grid.css', null, CUBIT_CALC_VERSION);

            wp_enqueue_script($handle, CUBIT_CALC_ASSETS_URL . 'number-grid.js', null, CUBIT_CALC_VERSION, true);

            $wvbcc_have_number_grid_assets_been_enqueued = true;

            do_action('cubt_calc_enqueued_table_assets');
        }

        // Get the column definitions for our number sequence.
        $col_defs = get_number_sequence_columns($args['type'], $args['last_col']);

        $col_count = count($col_defs);
        for ($col_index = 0; $col_index < $col_count; ++$col_index) {
            if (!array_key_exists('super', $col_defs[$col_index])) {
                $col_defs[$col_index]['super'] = '';
            }

            if (!array_key_exists('sub', $col_defs[$col_index])) {
                $col_defs[$col_index]['sub'] = '';
            }
        }

        $col_defs_frontend = $col_defs;
        $col_count = count($col_defs_frontend);
        for ($col_index = 0; $col_index < $col_count; ++$col_index) {
            unset($col_defs_frontend[$col_index]['label']);
            unset($col_defs_frontend[$col_index]['super']);
            unset($col_defs_frontend[$col_index]['sub']);
        }

        $frontend_params = [
            'animate' => (bool) $args['animate'],
            'animDelay' => (int) ANIMATION_DELAY,
            'showHeadings' => (bool) $args['headings'],
            'areLastAndFirstTheSame' => (bool) $args['last_col'],
            'rowCount' => intval($args['rows']),
            'colCount' => count($col_defs),
            'colMetas' => $col_defs_frontend,
            'decimals' => intval($args['decimals']),
            'csvAddHeadings' => true,
            'type' => $args['type'],
            'labels' => [
                'copiedLink' => __('Copied URL', 'cubit-caclulator'),
                'copiedCsv' => __('Copied CSV', 'cubit-caclulator')
            ]
        ];

        if (!ENABLE_TIDY_DECIMALS) {
            // ...
        } elseif ($frontend_params['decimals'] > 4) {
            $frontend_params['truncateZerosThreshold'] = $frontend_params['decimals'] - 2;
        } elseif ($frontend_params['decimals'] > 2) {
            $frontend_params['truncateZerosThreshold'] = $frontend_params['decimals'] - 1;
        } else {
            // ...
        }

        $html .= sprintf('<figure data-tvbcc-number-grid="%s">', esc_attr(json_encode($frontend_params)));

        $html .= '<table>';

        $col_index = 0;
        $col_count = count($col_defs);
        $last_col_index = $col_count - 1;

        if ($frontend_params['showHeadings']) {
            $html .= '<thead>';
            $html .= '<tr>';

            while ($col_index <= $last_col_index) {
                $inner_html = '';

                if (!empty($col_defs[$col_index]['super'])) {
                    $inner_html .= '<div class="col-super">';
                    $inner_html .= $col_defs[$col_index]['super'];
                    $inner_html .= '</div>'; // .col-super
                }

                $inner_html .= '<div class="col-title">';
                $inner_html .= $col_defs[$col_index]['label'];
                $inner_html .= '</div>'; // .col-title

                if (!empty($col_defs[$col_index]['sub'])) {
                    $inner_html .= '<div class="col-sub">';
                    $inner_html .= $col_defs[$col_index]['sub'];
                    $inner_html .= '</div>'; // .col-sub
                }

                $html .= sprintf(
                    '<th data-col-idx="%d">%s</th>', // ...
                    $col_index,
                    $inner_html
                );

                ++$col_index;
            }

            $html .= '</tr>';
            $html .= '</thead>';
        }

        $html .= '<tbody>';
        $row_index = 0;
        while ($row_index < $frontend_params['rowCount']) {
            $html .= sprintf('<tr data-row-idx="%d">', $row_index);

            $col_index = 0;
            while ($col_index <= $last_col_index) {
                $html .= sprintf('<td data-col-idx="%d"><input type="number" value="" step="%.2f" /></td>', $col_index, $args['step']);

                ++$col_index;
            }

            $html .= '</tr>';
            ++$row_index;
        }
        $html .= '</tbody>';

        $html .= '</table>';

        $sharing_html = '';
        if ($args['sharing']) {
            $sharing_inner_html = sprintf(
                '<span class="button-icon">%s</span><span>%s</span>', //..
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M326.6 185.4c59.7 59.8 58.9 155.7 .4 214.6-.1 .1-.2 .3-.4 .4l-67.2 67.2c-59.3 59.3-155.7 59.3-215 0-59.3-59.3-59.3-155.7 0-215l37.1-37.1c9.8-9.8 26.8-3.3 27.3 10.6 .6 17.7 3.8 35.5 9.7 52.7 2 5.8 .6 12.3-3.8 16.6l-13.1 13.1c-28 28-28.9 73.7-1.2 102 28 28.6 74.1 28.7 102.3 .5l67.2-67.2c28.2-28.2 28.1-73.8 0-101.8-3.7-3.7-7.4-6.6-10.3-8.6a16 16 0 0 1 -6.9-12.6c-.4-10.6 3.3-21.5 11.7-29.8l21.1-21.1c5.5-5.5 14.2-6.2 20.6-1.7a152.5 152.5 0 0 1 20.5 17.2zM467.5 44.4c-59.3-59.3-155.7-59.3-215 0l-67.2 67.2c-.1 .1-.3 .3-.4 .4-58.6 58.9-59.4 154.8 .4 214.6a152.5 152.5 0 0 0 20.5 17.2c6.4 4.5 15.1 3.8 20.6-1.7l21.1-21.1c8.4-8.4 12.1-19.2 11.7-29.8a16 16 0 0 0 -6.9-12.6c-2.9-2-6.6-4.9-10.3-8.6-28.1-28.1-28.2-73.6 0-101.8l67.2-67.2c28.2-28.2 74.3-28.1 102.3 .5 27.8 28.3 26.9 73.9-1.2 102l-13.1 13.1c-4.4 4.4-5.8 10.8-3.8 16.6 5.9 17.2 9 35 9.7 52.7 .5 13.9 17.5 20.4 27.3 10.6l37.1-37.1c59.3-59.3 59.3-155.7 0-215z"/></svg>',
                esc_html__('Share as link', 'cubit-calculator')
            );

            $sharing_inner_html = (string) apply_filters('tvbcc_share_button_html', $sharing_inner_html);

            if (!empty($sharing_inner_html)) {
                $sharing_html .= sprintf(
                    '<button disabled class="button share-number-grid">%s</button>', // ...
                    $sharing_inner_html
                );
            }
        }

        if ($args['copycsv']) {
            $sharing_inner_html = sprintf(
                '<span class="button-icon">%s</span><span>%s</span>', //..
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M320 448v40c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V120c0-13.3 10.7-24 24-24h72v296c0 30.9 25.1 56 56 56h168zm0-344V0H152c-13.3 0-24 10.7-24 24v368c0 13.3 10.7 24 24 24h272c13.3 0 24-10.7 24-24V128H344c-13.2 0-24-10.8-24-24zm121-31L375 7A24 24 0 0 0 358.1 0H352v96h96v-6.1a24 24 0 0 0 -7-17z"/></svg>',
                esc_html__('Copy as CSV', 'cubit-calculator')
            );

            $sharing_inner_html = (string) apply_filters('tvbcc_copycsv_button_html', $sharing_inner_html);

            if (!empty($sharing_inner_html)) {
                $sharing_html .= sprintf(
                    '<button disabled class="button copycsv-number-grid">%s</button>', // ...
                    $sharing_inner_html
                );
            }
        }

        if (!empty($args['caption']) || !empty($sharing_html)) {
            $html .= sprintf(
                '<figcaption>%s<span class="caption-text">%s</span></figcaption>', // ...
                $sharing_html,
                wp_kses_post($args['caption'])
            );
        }

        $html .= '</figure>'; // [data-tvbcc-number-grid]
    }

    return $html;
}
add_shortcode('cubit_number_grid', '\\Cubit_Calculator\\do_shortcode_number_grid');
