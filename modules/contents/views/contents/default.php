<?php  	global $tmpl;
$tmpl -> addStylesheet('detail','modules/contents/assets/css');
//$tmpl -> addScript('detail','modules/contents/assets/js');
FSFactory::include_class('fsstring');
$print = FSInput::get('print',0);
$hide = FSInput::get('ccode');
if ($hide == 'cach-thanh-toan-bang-kredivo') {$hide = 'hide';}
?>
<div class="content_detail">
	<div class="wapper-content-page">
		<h1 class='content_title <?php echo $hide; ?>'>
			<span><?php	echo $data -> title; ?></span>
		</h1>
		<!-- end CONTENT NAME-->
		<!-- SUMMARY -->
			<div class="summary"><?php echo $data -> summary; ?></div>
		<div class='description'>
            <?php echo $data->content;?>
		</div>
	</div>
</div>
<?php if ($data->id == 71) { ?>
<style>
    header {
        position: absolute;
        background: #0000007a;
        top: 0;
        width: 103%;
        padding-left: 42%;
        text-align: left;
        padding-top: 5px;
        padding-bottom: 5px;
        z-index: 1;
        margin-left: -1em;
    }
    .breadcrumbs {
        display:none;
    }
    .bottom {
        display:none;
    }
    .content_title {
        display:none;
    }
    #footer {
        display:none;
    }
    .top-header {
        display:none;
    }
    body {
        margin: 0;
        overflow: hidden;
    }
    video {
        width: auto;
        height: 100vh;
    }
    .video {
        display: flex;
        flex-direction: column;
        width: 110%;
        height: 103vh;
        overflow: hidden;
        margin-top: -4em;
        zoom: 1.0;
        margin-left: -1em;
    }

    .item {
        height: 100vh;
        transition: transform 0.3s ease-in-out;
    }
</style>
</head>
<body>
<header>
    <img src="/modules/products/assets/images/didongthongminh.svg" alt="didongthongminh.vn" width="48" height="48" class="img-responsive site-logo-pc img_pc"></header>
<div class="video">
    <div class="item">
        <div class="file">
            <video src="/upload_images/images/Video/Video1.mp4" autoplay muted playsinline>&nbsp;</video>
        </div>
        <div class="title">Đừng chần chừ với iPhone 12 ở 2023</div>
    </div>

    <div class="item">
        <div class="file">
            <video controlslist="nodownload" src="/upload_images/images/Video/Video2.mp4" autoplay muted playsinline>&nbsp;</video>
        </div>
        <div class="title">Realme đỉnh thế này thì Apple vs Samsung ế à ?</div>
    </div>

    <div class="item">
        <div class="file">
            <video controlslist="nodownload" src="/upload_images/images/Video/Video3.mp4"  autoplay muted playsinline>&nbsp;</video>
        </div>
        <div class="title">Bất ngờ xuất hiện AI review Note 12 Turbo quá đỉnh #dreviews</div>
    </div>


    <div class="item">
        <div class="file">
            <video controlslist="nodownload" src="/upload_images/images/Video/Video4.mp4"  autoplay muted playsinline>&nbsp;</video>
        </div>
        <div class="title">Redmi Note 12 Turbo cấu hình thế nào? Review bởi AI xinh đẹp</div>
    </div>

    <div class="item">
        <div class="file">
            <video controlslist="nodownload" src="/upload_images/images/Video/Video5.mp4"  autoplay muted playsinline>&nbsp;</video>
        </div>
        <div class="title">Redmi Note 12 Turbo cấu hình thế nào? Review bởi AI xinh đẹp</div>
    </div>

    <div class="item">
        <div class="file">
            <video controlslist="nodownload" src="/upload_images/images/Video/Video6.mp4"  autoplay muted playsinline>&nbsp;</video>
        </div>
        <div class="title">Redmi Note 12 Turbo cấu hình thế nào? Review bởi AI xinh đẹp/div>
    </div>

    <div class="item">
        <div class="file">
            <video controlslist="nodownload" src="/upload_images/images/Video/Video7.mp4"  autoplay muted playsinline>&nbsp;</video>
        </div>
        <div class="title">Redmi Note 12 Turbo cấu hình thế nào? Review bởi AI xinh đẹp</div>
    </div>

    <div class="item">
        <div class="file">
            <video controlslist="nodownload" src="/upload_images/images/Video/Video8.mp4"  autoplay muted playsinline>&nbsp;</video>
        </div>
        <div class="title">iPhone 3 triệu mạnh như Android 30 triệu</div>
    </div>

    <div class="item">
        <div class="file">
            <video controlslist="nodownload" src="/upload_images/images/Video/Video9.mp4"  autoplay muted playsinline>&nbsp;</video>
        </div>
        <div class="title">Mang quà về cho mẹ thì phải lẹ nè</div>
    </div>

    <div class="item">
        <div class="file">
            <video controlslist="nodownload" src="/upload_images/images/Video/Video10.mp4"  autoplay muted playsinline>&nbsp;</video>
        </div>
        <div class="title">Mang quà về cho mẹ thì phải lẹ nè</div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const videoContainer = document.querySelector(".video");
        const videoItems = document.querySelectorAll(".item > .file > video");
        let currentVideo = 0;
        let touchStartY = 0;
        let touchEndY = 0;

        videoContainer.addEventListener("touchstart", function(event) {
            touchStartY = event.touches[0].clientY;
        });

        videoContainer.addEventListener("touchmove", function(event) {
            touchEndY = event.touches[0].clientY;
            event.preventDefault(); // Prevent default scrolling behavior
        });

        videoContainer.addEventListener("touchend", function() {
            const swipeThreshold = 50;
            const deltaY = touchEndY - touchStartY;

            if (deltaY > swipeThreshold && currentVideo > 0) {
                currentVideo--;
            } else if (deltaY < -swipeThreshold && currentVideo < videoItems.length - 1) {
                currentVideo++;
            }

            updateVideoDisplay();
        });

        function updateVideoDisplay() {
            const videoHeight = videoItems[0].clientHeight;
            const offset = -currentVideo * videoHeight;
            videoItems.forEach((item, index) => {
                if (index === currentVideo) {
                    item.play();
                } else {
                    item.pause();
                    item.currentTime = 0;
                }
            });
            videoItems[currentVideo].play();
            videoItems[currentVideo].muted = false;
            videoItems.forEach(item => {
                item.style.transform = `translateY(${offset}px)`;
            });
        }
    });
</script>



<?php } ?>
