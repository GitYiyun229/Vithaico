<?php


class VideosControllersHome extends FSControllers
{
    var $module;
    var $view;

    function display()
    {
        // call models
        $model = $this->model;

        $videos = $model->getVideos();
        $urlVideo = json_encode(array_map(function ($video) {
            return URL_ROOT . $video->video;
        }, $videos));
        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }
    function like(){
        $model = $this->model;
        $id = FSInput::get('video_id');
        $like = FSInput::get('like_new');
        $model->_update(["hits"=>$like],"fs_video","id = {$id}", 0);
    }

}

?>
