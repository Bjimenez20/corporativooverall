var $container = $('.dropbar-menu'),
    $list = $('.dropbar-menu ul'),
    listItem = $list.find('li');

$(".dropbar .title").click(function () {
  if( $container.height() > 0) {
    closeMenu(this);
  } else {
    openMenu(this);
  }
});

$(".dropbar-menu li").click(function () {
  closeMenu(this);
});

function closeMenu(el) {
  $(el).closest('.dropbar').toggleClass("closed").find(".title").text($(el).text());
  $container.css("height", 0);
  $list.css( "top", 0 );
}

function openMenu(el) {
  $(el).parent().toggleClass("closed");
  
  $container.css({
    height: 200
  })
  .mousemove(function(e) {
    var heightDiff = $list.height() / $container.height(),
        offset = $container.offset(),
        relativeY = (e.pageY - offset.top),
        top = relativeY*heightDiff > $list.height()-$container.height() ?
              $list.height()-$container.height() : relativeY*heightDiff;

    $list.css("top", -top);
  });
}