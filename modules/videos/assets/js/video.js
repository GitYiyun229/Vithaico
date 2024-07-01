$(document).ready(function () {
    let videoList = JSON.parse($("#videos").val());
    var currentVideoIndex = 0;
    var videoSlider = $('.video-slider');
    var videos = videoSlider.find('video');
    var isSliding = false; // Biến để kiểm tra xem slider có đang trượt không

    videoSlider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        vertical: true,
        verticalSwiping: true,
        arrows: true,
        prevArrow: '<button class="slick-prev">Previous</button>',
        nextArrow: '<button class="slick-next">Next</button>',
        infinite: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    variableWidth: false
                }
            }
        ]
    });

    videoSlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        isSliding = true;
        var $currentVideo = videoSlider.find('.slick-slide[data-slick-index="' + nextSlide + '"] video');
        // Kiểm tra nếu có video trong slide tiếp theo
        if ($currentVideo.length > 0) {
            $currentVideo[0].muted = false; // Bật tiếng cho video tiếp theo
            $currentVideo[0].play(); // Bắt đầu phát video tiếp theo
        }
    });

    videoSlider.on('afterChange', function (event, slick, currentSlide) {
        isSliding = false;
        // Xác định slide hiện tại
        currentVideoIndex = currentSlide;
        console.log(currentVideoIndex);
        // Load video tiếp theo
        loadNextVideo(currentVideoIndex + 1);
        // Tắt tiếng cho video trước đó nếu không phải là video hiện tại
        unmuteCurrentVideo(currentVideoIndex);
    });

// Tạo sự tương tác giả định từ người dùng trên trang web
    document.addEventListener('DOMContentLoaded', function () {
        // Tạo một nút ẩn và chuyển đổi trang web khi nút này được chạm vào
        var interactionButton = document.createElement('button');
        interactionButton.id = 'interaction-button';
        interactionButton.style.position = 'absolute';
        interactionButton.style.top = '0';
        interactionButton.style.left = '0';
        interactionButton.style.width = '100%';
        interactionButton.style.height = '100%';
        interactionButton.style.opacity = '0';
        interactionButton.style.cursor = 'pointer';
        document.body.appendChild(interactionButton);

        interactionButton.addEventListener('click', function () {
            // Người dùng đã tương tác, chạm vào nút ẩn, bật âm thanh và phát video
            videos.each(function (index, video) {
                video.muted = false;
                video.play();
            });
            // Sau khi tương tác, ẩn nút đi
            interactionButton.style.display = 'none';
        });
    });

    function loadNextVideo(currentVideoIndex) {
        if (currentVideoIndex < videoList.length) {
            let nextVideoUrl = videoList[currentVideoIndex];
            $(`.video-${currentVideoIndex}`).attr("src", nextVideoUrl);
        }
    }

    function unmuteCurrentVideo(currentVideoIndex) {
        if (!isSliding) {
            videos.each(function (index, video) {
                if (index !== currentVideoIndex) {
                    video.muted = true;
                }
            });
        }
    }


    $(document).on('click', '.click_like', function (e) {
        e.preventDefault();
        let video_id = $(this).attr("data-id");
        let like = $(this).attr("data-like");
        let like_new = Number(like) + 1;
        $(this).addClass("liked");
        $(`.text-${video_id}`).html(like_new);
        $.ajax({
            type: "POST",
            url: "/index.php?module=videos&view=home&raw=1&task=like",
            dataType: "html",
            data: { video_id: video_id, like_new: like_new },
            success: function (data) {},
            error: function (XMLHttpRequest, textStatus, errorThrown) {},
        });
    });
});
