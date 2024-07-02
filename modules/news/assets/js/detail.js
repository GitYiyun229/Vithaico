$(document).ready(function () {
    $("#toc").toc({content: ".description", headings: "h1,h2,h3,h4"});
    $(".button-select").click(function() {
        $('.fa-angle-down').toggleClass('active');
        $('.title-toc .title').addClass('display');
        $('.mr-1').toggleClass('active');
        $('.list-toc').slideToggle();
    });
    // $(document).on('click',function(event){
    //     if($(event.target).closest('.button-select').length < 0) {
    //         $('.list-toc').slideToggle();
    //     }
    // })
    $(window).scroll(function(){
        var scroll = $(window).scrollTop();
       
        if (scroll >= 700) {
            $("#left1").addClass("fixtoc");
            $('.fa-angle-down').removeClass('active');
            $('.tablecontent').removeClass('none');
            $(".fa-angle-down").addClass("none");
            $(".mr-1").addClass("none");
            
        }
        if (scroll < 700) {
            $("#left1").removeClass("fixtoc");
            $('.tablecontent').addClass('none');
            $('.fa-angle-down').removeClass('none');
            $(".mr-1").removeClass("none");
        }
    });

    $('#toc a').on('click',function (e) {
        e.preventDefault();
        let target = $(this).attr('href');
        target = target.replace(/\./g,'\\.');
        $('html, body').animate({
            'scrollTop': $(target).offset().top - 60
        }, 800);
    });

    $(".send-comment-news").click(function() {
        if (checkFormsubmit2())
            $("#comments-news").submit()
    });
    let news_id;
    let comment_id;
    let link;

    $(".reply").click(replyComment);

    $(document).on('click', `.send-comment-news`, saveReply);

    $('.like-link').click(function () {
        let _this = this;
        let id = $(this).attr('data-id');
        let check = $(this).attr('data-check');
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/index.php?module=news&view=news&raw=1&task=add_point',
            data: "id=" + id + "&check=" + check,
            success: function (data) {
                $(_this).attr('data-check',data.check);
                $(_this).find('b').html(data.point);
            }
        });
    })
    
});

function replyComment() {
    news_id = $("#news_id").val();
    comment_id = $(this).attr('data-id');
    link = $("#link").val();
    let form_comment =
        `
<form class="frmCmt frmReply" id="reply-form-${comment_id}" action="index.php?module=news&view=news&task=save_comment&id=${news_id}&comment_id=${comment_id}" method="post">
    <div class="input-cmt">
       <textarea id="content-${comment_id}" class="form-control" placeholder="Cảm nghĩ của bạn" name="content"></textarea>
    </div>
    <div class="input-cmt input-cmt50">
       <input id="fullname-${comment_id}" name="fullname" class="form-control" type="text" placeholder="Họ và tên" />
    </div>
    <div class="input-cmt input-cmt50">
       <input id="email-${comment_id}" name="email" class="form-control" type="text" placeholder="Email của bạn" />
    </div>
    <div class="input-cmt input-last">
       <a class="send-comment-news remove-link">Gửi bình luận</a>
       <input type="hidden" name="link" value="${link}">
    </div>
</form>
`
    $(this).parent().after(form_comment);
    $(this).css("pointer-events", "none");
}

function saveReply() {
    if (checkFormsubmit3())
        $(`#reply-form-${comment_id}`).submit()
}

function checkFormsubmit3() {

    $('label.label_error').prev().remove();
    $('label.label_error').remove();

    if (!notEmpty(`fullname-${comment_id}`, "Bạn chưa nhập họ tên")) {
        return false;
    }
    if (!notEmpty(`email-${comment_id}`, "Bạn chưa nhập email")) {
        return false;
    }
    if (!emailValidator(`email-${comment_id}`, "Email chưa đúng định dạng")) {
        return false;
    }
    if (!notEmpty(`content-${comment_id}`, "Bạn chưa nhập nội dung bình luận")) {
        return false;
    }

    else {

    }
    return true;
}

function checkFormsubmit2() {

    $('label.label_error').prev().remove();
    $('label.label_error').remove();
    if (!notEmpty("content", "Bạn chưa nhập nội dung bình luận")) {
        return false;
    }

    if (!notEmpty("fullname", "Bạn chưa nhập họ tên")) {
        return false;
    }

    if (!notEmpty("email", "Bạn chưa nhập email")) {
        return false;
    }
    if (!emailValidator("email", "Email chưa đúng định dạng")) {
        return false;
    }


    else {

    }
    return true;
}