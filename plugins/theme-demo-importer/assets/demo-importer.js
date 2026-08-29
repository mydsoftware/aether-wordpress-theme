(function ($) {
  'use strict';
  $(function () {
    $('.aether-import-demo').prop('disabled', false).each(function () {
      var $b = $(this);
      if ($b.data('label')) $b.text($b.data('label'));
    });
    $(document).on('click', '.aether-import-demo', function (e) {
      e.preventDefault();
      var $btn = $(this);
      var demoId = $btn.data('demo');
      if (!demoId) return;
      if (window.aetherDemo && aetherDemo.i18n.confirm && !window.confirm(aetherDemo.i18n.confirm)) return;
      $btn.prop('disabled', true);
      runImport(demoId, 'init', $btn);
    });
  });
  function runImport(demoId, step, $btn) {
    var $st = $btn.siblings('.aether-import-status');
    if (!$st.length) { $btn.after('<p class="aether-import-status" style="margin-top:8px;font-size:13px;"></p>'); $st = $btn.siblings('.aether-import-status'); }
    $st.text(aetherDemo.i18n.importing);
    $btn.text(aetherDemo.i18n.importing);
    $.post(aetherDemo.ajaxUrl, { action: 'aether_import_demo', nonce: aetherDemo.nonce, demo_id: demoId, step: step })
      .done(function (res) {
        if (!res.success) {
          $st.css('color', '#b91c1c').text((res.data && res.data.message) || aetherDemo.i18n.error);
          $btn.prop('disabled', false).text('تلاش مجدد');
          return;
        }
        var data = res.data;
        $st.css('color', '#065f46').text(data.message + ' (' + data.progress + '%)');
        if (data.done || !data.next) {
          $st.text(aetherDemo.i18n.success);
          $btn.text('وارد شد ✓').prop('disabled', true);
          return;
        }
        setTimeout(function () { runImport(demoId, data.next, $btn); }, 400);
      })
      .fail(function () {
        $st.css('color', '#b91c1c').text(aetherDemo.i18n.error);
        $btn.prop('disabled', false).text('تلاش مجدد');
      });
  }
})(jQuery);
