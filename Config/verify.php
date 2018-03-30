<?php
return array(
            'fontSize'    =>    32,    // 验证码字体大小
            'length'      =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
            'useImgBg'    =>     false,  // 开启验证码背景图片功能 随机使用 ThinkPHP/Library/Think/Verify/bgs 目录下面的图片
            'codeSet'     => '0123456789',  // 设置验证码字符为纯数字
            'useCurve'    =>    false   //是否使用混淆曲线
        );