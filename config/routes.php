<?php

return array(
    'news/([0-9]+)' => 'news/view/$1',
    'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2',
    'news' => 'news/index', //actionIndex in NewController
    'products' => 'product/list', //actionList in ProductController
);