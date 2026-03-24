/**
 * TonyTechLab Donate — Admin Repeater Fields
 *
 * Handles add/remove/reorder for repeater rows in admin settings.
 * Also initializes WP color picker widgets.
 */
(function ($) {
    'use strict';

    $(document).ready(function () {
        initRepeaters();
        initParagraphs();
        initColorPickers();
    });

    /* ── Repeater: add / remove / sortable ── */
    function initRepeaters() {
        $('.ttl-repeater').each(function () {
            var $container = $(this);
            var $rows = $container.find('.ttl-repeater__rows');
            var tmpl = $container.find('.ttl-repeater__template').html();
            var nextIndex = $rows.children('.ttl-repeater__row').length;

            /* Add row */
            $container.on('click', '.ttl-repeater__add', function () {
                var html = tmpl.replace(/__INDEX__/g, nextIndex);
                $rows.append(html);
                nextIndex++;
            });

            /* Remove row */
            $container.on('click', '.ttl-repeater__remove', function () {
                var $row = $(this).closest('.ttl-repeater__row');
                if ($rows.children('.ttl-repeater__row').length > 1) {
                    $row.remove();
                    reindexRows($rows, $container.data('option'), $container.data('field'));
                }
            });

            /* Sortable drag reorder */
            if ($.fn.sortable) {
                $rows.sortable({
                    handle: '.ttl-repeater__handle',
                    placeholder: 'ttl-repeater__placeholder',
                    update: function () {
                        reindexRows($rows, $container.data('option'), $container.data('field'));
                    }
                });
            }
        });
    }

    /**
     * Re-index all row input name attributes to sequential 0,1,2...
     */
    function reindexRows($rows, optionName, fieldName) {
        $rows.children('.ttl-repeater__row').each(function (i) {
            $(this).attr('data-index', i);
            $(this).find('[name]').each(function () {
                var name = $(this).attr('name');
                /* Replace [items][N][ or [social_links][N][ with correct index */
                var re = new RegExp('\\[' + fieldName + '\\]\\[\\d+\\]');
                $(this).attr('name', name.replace(re, '[' + fieldName + '][' + i + ']'));
            });
        });
    }

    /* ── Mission paragraphs: add / remove ── */
    function initParagraphs() {
        var $wrap = $('.ttl-paragraphs');
        if (!$wrap.length) return;

        $wrap.on('click', '.ttl-paragraphs__add', function () {
            var idx = $wrap.find('.ttl-paragraphs__item').length;
            var html = '<div class="ttl-paragraphs__item">' +
                '<textarea name="tonytechlab_mission[paragraphs][' + idx + ']" rows="3" class="large-text"></textarea>' +
                '<button type="button" class="button ttl-paragraphs__remove">Remove</button>' +
                '</div>';
            $wrap.find('.ttl-paragraphs__list').append(html);
        });

        $wrap.on('click', '.ttl-paragraphs__remove', function () {
            var $items = $wrap.find('.ttl-paragraphs__item');
            if ($items.length > 1) {
                $(this).closest('.ttl-paragraphs__item').remove();
                /* Re-index */
                $wrap.find('.ttl-paragraphs__item textarea').each(function (i) {
                    $(this).attr('name', 'tonytechlab_mission[paragraphs][' + i + ']');
                });
            }
        });
    }

    /* ── WP Color Picker init ── */
    function initColorPickers() {
        $('.ttl-color-picker').wpColorPicker();
    }
})(jQuery);
