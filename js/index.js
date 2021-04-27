$(() => {
    target = "#0";
    $(target).hide();
    $("form").hide();
    for (let i = 0; i < 10; i++) {
        if (i == 0) {
            $(target).show();
        } else {
            $(target).clone().attr("id", i).appendTo("#main");
        }
        target = "#"+i;
    }
    $(".fa-bars").on("click", (e) => {
        $("form").slideToggle();
        e.stopPropagation();
    });
    $("form").on("click", (e) => {
        e.stopPropagation();
    });
    $(document).on("click", () => {
        if ($(".fa-bars").is(":visible")) {
            $("form").slideUp();
        }
    });
});


