(function ($) {
  "use strict";

  $(document).ready(function () {
    var $menuItems = $('.js-item-menu');
    var subMenuIndex = -1;

    $menuItems.each(function (index) {
      $(this).on('click', function (e) {
        e.preventDefault();
        $('.js-right-sidebar').removeClass("show-sidebar");

        if (subMenuIndex === index) {
          $(this).toggleClass('show-dropdown');
          subMenuIndex = -1;
        } else {
          $menuItems.removeClass('show-dropdown');
          $(this).addClass('show-dropdown');
          subMenuIndex = index;
        }
      });
    });

    $(".js-item-menu, .js-dropdown").on('click', function (e) {
      e.stopPropagation();
    });

    $("body, html").on("click", function () {
      $menuItems.removeClass("show-dropdown");
      subMenuIndex = -1;
    });
  });
})(jQuery);