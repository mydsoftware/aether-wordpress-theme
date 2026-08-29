/**
 * اسکریپت ادمین تم Aether
 */
(function ($) {
  'use strict';

  $(function () {
    // Color picker
    if ($.fn.wpColorPicker) {
      $('.aether-color-picker').wpColorPicker();
    }

    // Tabs
    $('.aether-settings-nav__item').on('click', function () {
      const tab = $(this).data('tab');
      $('.aether-settings-nav__item').removeClass('is-active');
      $(this).addClass('is-active');
      $('.aether-settings-panel').removeClass('is-active');
      $('#tab-' + tab).addClass('is-active');
    });
  });
})(jQuery);
