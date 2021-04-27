$(() => {
    target = "#0";
    $(target).hide();
    for (let i = 0; i < 3; i++) {
        if (i == 0) {
            $(target).show();
        } else {
            $(target).clone().attr("id", i).appendTo("#main");
        }
        target = "#"+i;
    }
});