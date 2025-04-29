document.addEventListener('DOMContentLoaded', function () {
  $(".dropbar .title").click(function () {
    const $dropbar = $(this).closest('.dropbar');
    const $container = $dropbar.find('.dropbar-menu');
    const $list = $container.find('ul');

    if ($container.height() > 0) {
      closeMenu($dropbar, $container, $list, this);
    } else {
      openMenu($dropbar, $container, $list);
    }
  });

  $(".dropbar-menu li").click(function () {
    const $dropbar = $(this).closest('.dropbar');
    const $container = $dropbar.find('.dropbar-menu');
    const $list = $container.find('ul');
    closeMenu($dropbar, $container, $list, this);
  });

  function openMenu($dropbar, $container, $list) {
    $dropbar.removeClass("closed");
    const items = $list.find('li').length;
    $container.css("height", items * 40 + "px"); // 40px por item
  }

  function closeMenu($dropbar, $container, $list, el) {
    $dropbar.addClass("closed").find(".title").text($(el).text());
    $container.css("height", 0);
    $list.css("top", 0);
  }
});
