
// produtos load more
$(document).ready(function () {
    size_div = $("#myList div").size();
    x=10;
    $('#myList div:lt('+x+')').show();
    $('#loadMore').click(function () {
        x= (x+10 <= size_div) ? x+10 : size_div;
        $('#myList div:lt('+x+')').show();
    });
    $('#showLess').click(function () {
        x=(x-10<0) ? 10 : x-10;
        $('#myList div').not(':lt('+x+')').hide();
    });
});

