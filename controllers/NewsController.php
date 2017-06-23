<?php
include_once ROOT.'/models/News.php';
class NewsController
{
    public function actionIndex()
    {

        $newsList=News::getNewsList();
        var_dump($newsList);
        return true;
    }

    public function actionView($id)
    {

        $newsItem=News::getNewsItemById($id);
        var_dump($newsItem);
        return true;
    }
}