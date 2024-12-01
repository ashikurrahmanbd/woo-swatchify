<?php

namespace PXLS\Swatchify;

class Admin{

    function __construct(){

        new Admin\Menu();

        new Assets\EnqueueAssets();

        new Admin\SwatchTypes();

        new Admin\SwatchTermField();

        
    }



}