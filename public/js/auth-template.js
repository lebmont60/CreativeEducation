//Fixed footer on bottom
function setFooter()
{
    var footer = $('footer');
    var offset = footer.offset();
    var windowHeight = $(window).height();

    if((offset.top + footer.height()) < windowHeight)
    {
        footer.css('position', 'absolute');
        footer.css('bottom', '0px');
        footer.css('width', '-webkit-fill-available');
    }
}

$(document).ready(function()
{
    //Calls function on page load
    setFooter();

    //Calls function on page resizing
    $(window).resize(function()
    {
        setFooter();
    });

    //Sidebar open + burger menu icon animation
    $('.burger').click(function()
    {
        var nav = $('nav');
        var burgerTop = $('.burger-top');
        var burgerMiddle = $('.burger-middle');
        var burgerBottom = $('.burger-bottom');
        
        if(nav.hasClass('hidden-nav'))
        {
            burgerTop.addClass('animation-top');
            burgerMiddle.addClass('animation-middle');
            burgerBottom.addClass('animation-bottom');
            nav.removeClass('hidden-nav');
            nav.addClass('visible-nav');
        }
        else
        {
            burgerTop.removeClass('animation-top');
            burgerMiddle.removeClass('animation-middle');
            burgerBottom.removeClass('animation-bottom');
            nav.removeClass('visible-nav');
            nav.addClass('hidden-nav');
        }
    });
});