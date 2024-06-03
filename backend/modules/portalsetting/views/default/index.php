<?php

$this->title = 'PHP INFO';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'Portal Setting', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

echo phpinfo();
