$(function () {
    const link_home = $('#link_home').val();
    const link_login = $('#link_login').val();
    const fb = $('#fb').val();
    const ytb = $('#ytb').val();
    const twitter = $('#twitter').val();
    const user = $('#user').val();
    let checked = "<a href='" + link_login + "'><i class='fa fa-user'></i></a>";
    if (user){
        checked = "<a class='login_icon' href='" + link_login + "'><i class='fa fa-user'></i><i class='fa fa-check'></i></a>";
    }
    new Mmenu(
        document.querySelector('#mySidenav'),
        {
            "offCanvas": {
                "position": "left"
            },
            "theme": "light",
            "iconbar": {
                "use": false,
                "top": [
                    "<a href='" + link_home + "'><i class='fa fa-home'></i></a>",
                    checked
                ],
                "bottom": [
                    "<a href='" + fb + "'><i class='fa fa-facebook'></i></a>",
                    "<a href='" + ytb + "'><i class='fa fa-youtube'></i></a>",
                    "<a href='" + twitter + "'><i class='fa fa-twitter'></i></a>"
                ]
            }
        }
    );
});
$(document).ready(function () {
    $('#keyword').keypress(function (e) {
        if (e.which == 13) {
            val1 = $('#keyword').val();
            search = $('#url').val();
            // alert(val1);
            if (val1) {
                link = $('#keyword').attr("data-url");
                link1 = link + search + val1+'.html';
                // alert(link1);
                window.location = link1;
                return false;
            } else {
                alert('Bạn phải nhập từ khóa!');
                return false;
            }
        }
    });
})


