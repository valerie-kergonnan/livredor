<?php

function hello_index(){
    $data = ['message' => "hello world"];
    load_view_with_layout('hello/index', $data);
}