function BoxSlider()
{
    var despl=1005;
    var despl_cal=336;

    $('.box_slider').scrollLeft(0);
    $('.slide_button_right').click(function(){
        var scrolled = $(this).prev().scrollLeft();
        scrolled=scrolled+despl;
        if(scrolled<$(this).prev().prop("scrollWidth"))
        {
            $(this).prev().animate({
                scrollLeft:  scrolled
            });
        }
    });

    $('.slide_button_left').click(function(){
        var scrolled = $(this).next().scrollLeft();
        scrolled=scrolled-despl
        if(scrolled<0) scrolled=0;
        $(this).next().animate({
            scrollLeft:  scrolled
        });
    });
    
    $('.slide_button_right_cal').click(function(){
        var scrolled = $(this).prev().scrollLeft();
        scrolled=scrolled+despl_cal;
        if(scrolled<$(this).prev().prop("scrollWidth"))
        {
            $(this).prev().animate({
                scrollLeft:  scrolled
            });
        }
    });

    $('.slide_button_left_cal').click(function(){
        var scrolled = $(this).next().scrollLeft();
        scrolled=scrolled-despl_cal
        if(scrolled<0) scrolled=0;
        $(this).next().animate({
            scrollLeft:  scrolled
        });
    });
}


function BoxSlider_2()
{
    var despl=996;

    $('.box_slider').scrollLeft(0);
    $('.slide_button_right_2').click(function(){
        var scrolled = $(this).prev().scrollLeft();
        scrolled=scrolled+despl;
        if(scrolled<$(this).prev().prop("scrollWidth"))
        {
            $(this).prev().animate({
                scrollLeft:  scrolled
            });
        }
    });

    $('.slide_button_left_2').click(function(){
        var scrolled = $(this).next().scrollLeft();
        scrolled=scrolled-despl
        if(scrolled<0) scrolled=0;
        $(this).next().animate({
            scrollLeft:  scrolled
        });
    });
}



function minHeight()
{
    if($(window).height()>$('.menu_frame_background').height()+$('.main_frame_background').height()+$('.footer_frame_background').height())
    {
        $('.main_frame_background').height($(window).height()-$('.menu_frame_background').height()-$('.footer_frame_background').height());
    }
}

function minHeight_admin()
{
    if($(window).height()>$('.menu_frame_background').height()+$('.edit_frame_background').height())
    {
        $('.edit_frame_background').height($(window).height()-$('.menu_frame_background').height());
    }
}

function setPopUpSize(body)
{
    var h = $(window).height()-200;
    h += 'px';
    $(body).css('max-height',h);
}

function ResizeButtonsText()
{
    $('.tag_frame').each(function(){
        while($(this).find('h1').width()>$(this).width()-10 || $(this).find('h1').height()>$(this).height()-10)
        {                
            $(this).find('h1').css('font-size',parseInt($(this).find('h1').css('font-size'))-1);
        }
    });
}

function ResizeMenuText()
{
    $('.sub_menu_frame li').each(function(){        
        while($(this).children().width()>$(this).width()-5)
        {                
            $(this).children().css('font-size',parseInt($(this).children().css('font-size'))-1);
        }
    });
}

function BoxText()
{
    $('.box_2').each(function(){            

        var text = $(this).children().text().split(' ');
        var result = "";
        var i = 0;
        for(i=0; i < text.length; i++)
        {
            result += "<span style="+getStyle()+">"+text[i]+"</span>";
            result += " ";
        }
        $(this).children().html(result);
        
        while($(this).children().height()>$(this).height())
        {            
            $(this).children().css('font-size',parseInt($(this).children().css('font-size'))-1);
        }

        $(this).children().css('visibility','visible');
    });
    
    $('.box_3').each(function(){
        while($(this).find('.l1').children().width()>$(this).find('.l1').width())
        {                
            $(this).find('.l1').children().css('font-size',parseInt($(this).find('.l1').children().css('font-size'))-1);
            $(this).find('.l1').css('bottom',parseFloat($(this).find('.l1').css('bottom'))+0.5);
        }
        
        $(this).find('.l1').children().css('visibility','visible');
    });
}

function ExpText()
{
    $('.box_exp_2').each(function(){
        while($(this).find('div:first-child').prop('scrollHeight')>$(this).find('div:first-child').height())
        {                
            $(this).find('div:first-child').css('font-size',parseInt($(this).find('div:first-child').css('font-size'))-1);
        }
        
        $(this).find('div:first-child').css('visibility','visible');
    });
}

function EventText()
{
    $('.content_header').each(function(){
        while($(this).find('h1').width()>600)
        {                
            $(this).find('h1').css('font-size',parseInt($(this).find('h1').css('font-size'))-1);
        }
        
        var text = $(this).find('h1').text().split(' ');
        var result = "";
        var i = 0;
        for(i=0; i < text.length; i++)
        {
            result += "<span style="+getStyle()+">"+text[i]+"</span>";
            result += " ";
        }
        $(this).find('h1').html(result);
        
        $(this).find('h1').css('visibility','visible');
    });
}

function EventText2()
{
    $('.myexp_frame').each(function(){
        
        var text = $(this).find('h1').text().split(' ');
        var result = "";
        var i = 0;
        for(i=0; i < text.length; i++)
        {
            result += "<span style="+getStyle()+">"+text[i]+"</span>";
            result += " ";
        }
        $(this).find('h1').html(result);
        
        $(this).find('h1').css('visibility','visible');
    });
}

function EventText3()
{
    $('.content_frame').each(function(){
        
        var text = $(this).find('h1').text().split(' ');
        var result = "";
        var i = 0;
        for(i=0; i < text.length; i++)
        {
            result += "<span style="+getStyle()+">"+text[i]+"</span>";
            result += " ";
        }
        $(this).find('h1').html(result);
        
        $(this).find('h1').css('visibility','visible');
    });
}

function CatText()
{
    $('.box_cat_2 > .l0').each(function(){
        var text = $(this).text().split(' ');
        var result = "";
        var i = 0;
        for(i=0; i < text.length; i++)
        {
            result += "<span style="+getStyle()+">"+text[i]+"</span>";
            result += " ";
        }
        $(this).html(result);
        
        while($(this).height()>$(this).parent().height())
        {                
            $(this).css('font-size',parseInt($(this).css('font-size'))-1);
        }                
        
        $(this).css('visibility','visible');
    });
    
    $('.box_cat_3').each(function(){
        while($(this).find('div:first-child').height()>$(this).height())
        {                
            $(this).find('div:first-child').css('font-size',parseInt($(this).find('div:first-child').css('font-size'))-1);
        }
        
        $(this).find('div:first-child').css('visibility','visible');
    });
}

function RestText()
{
    $('.box_rest_2 > .l0').each(function(){       
        var text = $(this).text().split(' ');
        var result = "";
        var i = 0;
        for(i=0; i < text.length; i++)
        {
            result += "<span style="+getStyle()+">"+text[i]+"</span>";
            result += " ";
        }
        $(this).html(result);
        
        while($(this).prop("offsetWidth") < $(this).prop("scrollWidth"))
        {                
            $(this).css('font-size',parseInt($(this).css('font-size'))-1);
        }
        
        $(this).css('visibility','visible');
    });
}

function RestText_2()
{
    while($('#mail').prop("offsetWidth") < $('#mail').prop("scrollWidth"))
    {                
        $('#mail').css('font-size',parseInt($('#mail').css('font-size'))-1);
    }
    $('#mail').css('visibility','visible');
}

function getStyle() 
{
    var styleList = ['color:#888888;font-weight:400;', 'color:#5e132b;font-weight:700;'];

    var i = Math.floor((Math.random()*styleList.length));
    return styleList[i];
}

function BoxImgSizer()
{
    $(".box_1 img.box_img").one("load", function() {            
        var w = $(this).width();
        var h = $(this).height();
        var w_ = $(this).parent().width();
        var h_ = $(this).parent().height();
        
        if(w>0)
        {
            if(w/h < w_/h_)
            {
                var hn = w_*(h/w);
                $(this).width(w_);
                $(this).height(hn);
                $(this).css('top',(h_-hn)/2);
            }
            else
            {
                var wn = h_*(w/h);
                $(this).width(wn);
                $(this).height(h_);
                $(this).css('left',(w_-wn)/2);                
            }
            
            $(this).show();
        }        
    }).each(function() {
        if(this.complete) $(this).load();
    });
}

function BoxImgSizer2()
{
    $(".img_container img").one("load", function() {            
        var w = $(this).width();
        var h = $(this).height();
        var w_ = $(this).parent().width();
        var h_ = $(this).parent().height();
        
        if(w>0)
        {
            if(w/h < w_/h_)
            {
                var hn = w_*(h/w);
                $(this).width(w_);
                $(this).height(hn);
                $(this).css('top',(h_-hn)/2);
            }
            else
            {
                var wn = h_*(w/h);
                $(this).width(wn);
                $(this).height(h_);
                $(this).css('left',(w_-wn)/2);                
            }
            
            $(this).show();
        }        
    }).each(function() {
        if(this.complete) $(this).load();
    });
}

function ExpImgSizer()
{
    $(".box_exp_1 img").one("load", function() {            
        var w = $(this).width();
        var h = $(this).height();
        var w_ = $(this).parent().width();
        var h_ = $(this).parent().height();
        
        if(w>0)
        {
            if(w/h < w_/h_)
            {
                var hn = w_*(h/w);
                $(this).width(w_);
                $(this).height(hn);
                $(this).css('top',(h_-hn)/2);
            }
            else
            {
                var wn = h_*(w/h);
                $(this).width(wn);
                $(this).height(h_);
                $(this).css('left',(w_-wn)/2);                
            }
            
            $(this).show();
        }        
    }).each(function() {
        if(this.complete) $(this).load();
    });
}

function CatImgSizer()
{
    $(".box_cat_1 img").one("load", function() {            
        var w = $(this).width();
        var h = $(this).height();
        var w_ = $(this).parent().width();
        var h_ = $(this).parent().height();
        
        if(w>0)
        {
            if(w/h < w_/h_)
            {
                var hn = w_*(h/w);
                $(this).width(w_);
                $(this).height(hn);
                $(this).css('top',(h_-hn)/2);
            }
            else
            {
                var wn = h_*(w/h);
                $(this).width(wn);
                $(this).height(h_);
                $(this).css('left',(w_-wn)/2);                
            }
            
            $(this).show();
        }        
    }).each(function() {
        if(this.complete) $(this).load();
    });
    
    $(".box_rest_1 img").one("load", function() {            
        var w = $(this).width();
        var h = $(this).height();
        var w_ = $(this).parent().width();
        var h_ = $(this).parent().height();
        
        if(w>0)
        {
            if(w/h < w_/h_)
            {
                var hn = w_*(h/w);
                $(this).width(w_);
                $(this).height(hn);
                $(this).css('top',(h_-hn)/2);
            }
            else
            {
                var wn = h_*(w/h);
                $(this).width(wn);
                $(this).height(h_);
                $(this).css('left',(w_-wn)/2);                
            }
            
            $(this).show();
        }        
    }).each(function() {
        if(this.complete) $(this).load();
    });
}

function BoxStampSizer()
{
    $(".promo_img").one("load", function() {            
        var w = $(this).width();
        var h = $(this).height();
        
        if(w>h)
        {
            nw = 150 * (w/h);
            $(this).width(nw);
            $(this).height(150);
            $(this).css('left',(150-nw)/2);
        }
        else
        {
            nh = 150 * (h/w);
            $(this).width(150);
            $(this).height(nh);
            $(this).css('top',(150-nh)/2);
        }
        
    }).each(function() {
        if(this.complete) $(this).load();
    });
    
    $('.promo_text').each(function(){
        while($(this).find('h1').width()>$(this).width()-5)
        {                
            $(this).find('h1').css('font-size',parseInt($(this).find('h1').css('font-size'))-1);
        }
    });
}

function controls_position_script()
{   
    if($(window).scrollTop()>250)
    {
        //$('.edit_left').css('padding-top',$(window).scrollTop()-230);
        $('.edit_left').css('position', 'fixed');
        $('.edit_left').css('top', '0');
        //$('.edit_right').css('margin-left', '133px');
    }
    else
    {
        $('.edit_left').css('position', 'absolute');
        //$('.edit_left').css('padding-top',0);
        //$('.edit_right').css('margin-left', '0px');
    }
}