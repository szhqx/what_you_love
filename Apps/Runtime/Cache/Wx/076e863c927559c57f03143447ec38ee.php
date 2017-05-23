<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<head>
    <meta content="text/html" charset="utf-8" http-equiv="content-type"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" charset="utf-8"/>

    <title><?php echo ($shop["shopName"]); ?></title>
    <meta name="description" content="<?php echo ($shop["shopDesc"]); ?>" />
    <meta name="Keywords" content="<?php echo ($shop["shopKeywords"]); ?>" />


    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" charset="utf-8"/>
    <link rel="stylesheet" type="text/css"href="../../../../../wx/shops/s/cubebase-min.css">
    <style>
        article,aside,blockquote,body,button,code,dd,details,div,dl,dt,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,header,hgroup,hr,input,legend,li,menu,nav,ol,p,pre,section,td,textarea,th,ul{margin:0;padding:0}table{border-collapse:collapse;border-spacing:0}
        caption,th{text-align:left}img{border:0}iframe{display:block}li,ol,ul{list-style:none}
        hr{ -moz-box-sizing:content-box;box-sizing:content-box;height:0}
        button,input,select,textarea{font-family:inherit;font-size:100%;vertical-align:middle}
        button:focus,input:focus,select:focus,textarea:focus{outline:0}textarea{overflow:auto;vertical-align:top}
        button,input{line-height:normal}button,input[type=button],input[type=reset],input[type=submit]{cursor:pointer}
        button[disabled],input[disabled]{cursor:default}input[type=checkbox],input[type=radio]{box-sizing:border-box;padding:0}
        article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block}audio,canvas,video{display:inline-block}
        audio:not([controls]){display:none;height:0}a{background:0;text-decoration:none}a:focus{outline:dotted thin}a:active,a:hover{outline:0}
        a:link,a:visited,ins{text-decoration:none}meta.foundation-version{font-family:"/5.2.2/"}meta.foundation-mq-small{font-family:"/only screen/";width:0}
        meta.foundation-mq-medium{font-family:"/only screen and (min-width:40.063em)/";width:40.063em}
        meta.foundation-mq-large{font-family:"/only screen and (min-width:64.063em)/";width:64.063em}
        meta.foundation-mq-xlarge{font-family:"/only screen and (min-width:90.063em)/";width:90.063em}
        meta.foundation-mq-xxlarge{font-family:"/only screen and (min-width:120.063em)/";width:120.063em}
        meta.foundation-data-attribute-namespace{font-family:false}body,html{height:100%}
        *,:after,:before{ -webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}body,html{font-size:100%}
        body{padding:0;margin:0;font-family:"WenQuanYi Micro Hei","Droid Sans Fallback","Microsoft YaHei",Arial,sans-serif;font-weight:400;font-style:normal;line-height:1;position:relative;cursor:default}a:hover{cursor:pointer}img{max-width:100%;height:auto;-ms-interpolation-mode:bicubic}.left{float:left !important}.right{float:right !important}.clearfix:after,.clearfix:before{content:" ";display:table}.clearfix:after{clear:both}.hide{display:none}.antialiased{ -webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}img{display:inline-block;vertical-align:middle}textarea{height:auto;min-height:50px}select{width:100%}.row{width:100%;margin:0 auto;max-width:62.5rem}.row:after,.row:before{content:" ";display:table}.row:after{clear:both}.row.collapse>.column,.row.collapse>.columns{padding-left:0;padding-right:0}.row.collapse .row{margin-left:0;margin-right:0}
        .row .row{width:auto;margin:0 -.375rem;max-width:none}.row .row:after,.row .row:before{content:" ";display:table}
        .row .row:after{clear:both}.row .row.collapse{width:auto;margin:0;max-width:none}
        .row .row.collapse:after,.row .row.collapse:before{content:" ";display:table}.row .row.collapse:after{clear:both}
        .column,.columns{padding-left:.375rem;padding-right:.375rem;width:100%;float:left}@media only screen{.small-push-0{position:relative;left:0;right:auto}
            .small-pull-0{position:relative;right:0;left:auto}.small-push-1{position:relative;left:8.33333%;right:auto}
            .small-pull-1{position:relative;right:8.33333%;left:auto}.small-push-2{position:relative;left:16.66667%;right:auto}
            .small-pull-2{position:relative;right:16.66667%;left:auto}.small-push-3{position:relative;left:25%;right:auto}
            .small-pull-3{position:relative;right:25%;left:auto}.small-push-4{position:relative;left:33.33333%;right:auto}
            .small-pull-4{position:relative;right:33.33333%;left:auto}.small-push-5{position:relative;left:41.66667%;right:auto}
            .small-pull-5{position:relative;right:41.66667%;left:auto}.small-push-6{position:relative;left:50%;right:auto}
            .small-pull-6{position:relative;right:50%;left:auto}.small-push-7{position:relative;left:58.33333%;right:auto}
            .small-pull-7{position:relative;right:58.33333%;left:auto}.small-push-8{position:relative;left:66.66667%;right:auto}
            .small-pull-8{position:relative;right:66.66667%;left:auto}.small-push-9{position:relative;left:75%;right:auto}
            .small-pull-9{position:relative;right:75%;left:auto}.small-push-10{position:relative;left:83.33333%;right:auto}
            .small-pull-10{position:relative;right:83.33333%;left:auto}.small-push-11{position:relative;left:91.66667%;right:auto}
            .small-pull-11{position:relative;right:91.66667%;left:auto}.small-1{width:8.33333%}.small-2{width:16.66667%}.small-3{width:25%}
            .small-4{width:33.33333%}.small-5{width:41.66667%}.small-6{width:50%}.small-7{width:58.33333%}.small-8{width:66.66667%}
            .small-9{width:75%}.small-10{width:83.33333%}.small-11{width:91.66667%}.small-12{width:100%}[class*=column]+[class*=column]:last-child{float:right}
            [class*=column]+[class*=column].end{float:left}.small-offset-0{margin-left:0 !important}.small-offset-1{margin-left:8.33333% !important}
            .small-offset-2{margin-left:16.66667% !important}.small-offset-3{margin-left:25% !important}.small-offset-4{margin-left:33.33333% !important}
            .small-offset-5{margin-left:41.66667% !important}.small-offset-6{margin-left:50% !important}.small-offset-7{margin-left:58.33333% !important}
            .small-offset-8{margin-left:66.66667% !important}.small-offset-9{margin-left:75% !important}.small-offset-10{margin-left:83.33333% !important}
            .small-offset-11{margin-left:91.66667% !important}.small-reset-order{margin-left:0;margin-right:0;left:auto;right:auto;float:left}
            .column.small-centered,.columns.small-centered{margin-left:auto;margin-right:auto;float:none}
            .column.small-uncentered,.columns.small-uncentered{margin-left:0;margin-right:0;float:left !important}
            .column.small-uncentered.opposite,.columns.small-uncentered.opposite{float:right}}[class*=block-grid-]{display:block;padding:0;margin:0 -.375rem}
        [class*=block-grid-]:after,[class*=block-grid-]:before{content:" ";display:table}[class*=block-grid-]:after{clear:both}
        [class*=block-grid-]>li{display:block;height:auto;float:left;padding:0 .375rem}@media only screen{.small-block-grid-1>li{width:100%;list-style:none}
            .small-block-grid-1>li:nth-of-type(n){clear:none}.small-block-grid-1>li:nth-of-type(1n+1){clear:both}.small-block-grid-2>li{width:50%;list-style:none}
            .small-block-grid-2>li:nth-of-type(n){clear:none}.small-block-grid-2>li:nth-of-type(2n+1){clear:both}
            .small-block-grid-3>li{width:33.33333%;list-style:none}.small-block-grid-3>li:nth-of-type(n){clear:none}
            .small-block-grid-3>li:nth-of-type(3n+1){clear:both}.small-block-grid-4>li{width:25%;list-style:none}
            .small-block-grid-4>li:nth-of-type(n){clear:none}.small-block-grid-4>li:nth-of-type(4n+1){clear:both}
            .small-block-grid-5>li{width:20%;list-style:none}.small-block-grid-5>li:nth-of-type(n){clear:none}
            .small-block-grid-5>li:nth-of-type(5n+1){clear:both}.small-block-grid-6>li{width:16.66667%;list-style:none}
            .small-block-grid-6>li:nth-of-type(n){clear:none}.small-block-grid-6>li:nth-of-type(6n+1){clear:both}
            .small-block-grid-7>li{width:14.28571%;list-style:none}.small-block-grid-7>li:nth-of-type(n){clear:none}
            .small-block-grid-7>li:nth-of-type(7n+1){clear:both}.small-block-grid-8>li{width:12.5%;list-style:none}
            .small-block-grid-8>li:nth-of-type(n){clear:none}.small-block-grid-8>li:nth-of-type(8n+1){clear:both}
            .small-block-grid-9>li{width:11.11111%;list-style:none}.small-block-grid-9>li:nth-of-type(n){clear:none}
            .small-block-grid-9>li:nth-of-type(9n+1){clear:both}.small-block-grid-10>li{width:10%;list-style:none}
            .small-block-grid-10>li:nth-of-type(n){clear:none}.small-block-grid-10>li:nth-of-type(10n+1){clear:both}
            .small-block-grid-11>li{width:9.09091%;list-style:none}.small-block-grid-11>li:nth-of-type(n){clear:none}
            .small-block-grid-11>li:nth-of-type(11n+1){clear:both}.small-block-grid-12>li{width:8.33333%;list-style:none}
            .small-block-grid-12>li:nth-of-type(n){clear:none}.small-block-grid-12>li:nth-of-type(12n+1){clear:both}}
        body{background:#f2f1f6;color:#333}
        .base{margin-top:.625rem;margin-bottom:.625rem;background:#fff;border-top:.0625rem solid #c8c7cc;border-bottom:.0625rem solid #c8c7cc}
        .p-img{background:#f1f1f1}.p-info{height:2.375rem;color:#333;font-size:.813rem;line-height:1.188rem}.price{color:#e43743}
        .c-header-toolbar{position:relative;padding-left:.625rem;padding-right:.625rem;background:#fcfcfc;height:2.5rem;border-bottom:1px solid #c8c7cc}
        .c-header-toolbar .search{position:absolute;top:.313rem;left:3rem;right:3rem;overflow:hidden}
        .c-header-toolbar .search input[type="text"]{padding:.375rem 2.813rem .375rem .813rem;width:100%;height:1.875rem;line-height:1.125rem;font-size:.875rem;color:#333;background:#fff;-moz-border-radius:.3rem;-webkit-border-radius:.3rem;border-radius:.3rem;border:1px solid #bfbfbf}.c-header-toolbar .search input[type="text"]:focus{background:#f0f2f5}.c-header-toolbar .search ::-webkit-input-placeholder{color:#999}.c-header-toolbar .search :-moz-placeholder{color:#999}
        .c-header-toolbar .search ::-moz-placeholder{color:#999}.c-header-toolbar .search :-ms-input-placeholder{color:#999}
        .c-header-toolbar .search .icon-search{position:absolute;top:.469rem;right:1rem;display:block;width:.938rem;height:.938rem;
            background-image:url("../../56948fe9N69140cee.png");background-repeat:no-repeat;background-size:100%}.c-header-toolbar .search s{position:absolute;top:.219rem;right:2.75rem;width:1px;height:1.375rem;background:#bfbfbf}.c-header-toolbar .icon-return{position:absolute;top:.688rem;left:1rem;width:.625rem;height:1.188rem;background-image:url("../../56948fe9Nab253976.png");background-repeat:no-repeat;background-size:100%}.c-header-toolbar .icon-nav{position:absolute;top:.813rem;right:.875rem;width:1.25rem;height:1rem;background-image:url("../../56949204N822b1006.png");background-repeat:no-repeat;background-size:100%}.c-logo-opts{margin-bottom:.625rem;height:9.3rem;border-bottom:1px solid #c8c7cc}.c-logo-opts .back-logo{position:relative;height:6.25rem;background-size:100% auto;background-position:center;background-repeat:no-repeat}.c-logo-opts .back-logo .bottom{position:absolute;width:100%;height:2.53125rem;left:0;bottom:0}.c-logo-opts .back-logo .bottom .store-block{display:block;position:relative;margin-right:5.625rem;padding-bottom:.625rem;margin-left:.625rem}.c-logo-opts .back-logo .bottom .store-block img{position:absolute;display:block;width:5.625rem;height:1.875rem;border:1px solid #e0e0e0;top:0;left:0}.c-logo-opts .back-logo .bottom .store-block .store-text{height:1.9375rem;margin-left:5.9375rem}.c-logo-opts .back-logo .bottom .store-block .store-text .store-name{height:.96875rem;font-size:.875rem;color:#fff;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.c-logo-opts .back-logo .bottom .store-block .store-text .store-info{height:.96875rem;font-size:.875rem;color:#e0e0e0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.c-logo-opts .back-logo .bottom .store-block .store-text .store-info .store-type{display:none;float:left;width:2.5625rem;height:.875rem;margin-right:.3125rem;border-radius:3px;background:url(./icon-self.png) no-repeat;background-size:100%}.c-logo-opts .back-logo .bottom .store-block .store-text .store-info.self .store-type{display:block}
        .c-logo-opts .back-logo .bottom .store-follow{position:absolute;width:3.375rem;height:1.5rem;background-image:url("../../5694b5d9N1c6bbcea.png");
            background-size:100%;background-repeat:no-repeat;background-position:center bottom;top:.25rem;right:.5rem}
        .c-logo-opts .back-logo .bottom .store-follow.active{background-position:center top}
        .c-logo-opts .store-tab{position:relative;height:3rem;border-top:1px solid #e0e0e0;background-color:#fff}
        .c-logo-opts .store-tab .tab{display:block;height:100%}
        .c-logo-opts .store-tab .num{height:1.6875rem;font-size:1rem;color:#252525;line-height:1.6875rem;text-align:center}
        .c-logo-opts .store-tab .text{height:1.3125rem;font-size:.6875rem;color:#999;line-height:.9375rem;text-align:center}
        .c-logo-opts .store-tab .share{height:1.6875rem;text-align:center}.c-logo-opts .store-tab .i-share{display:inline-block;width:1.0625rem;height:1.125rem;margin-top:.4375rem;background:url(../../icon-share.png) no-repeat;background-size:100%}.c-logo-opts .store-tab .line{position:absolute;width:1px;height:1.125rem;background-color:#e0e0e0;top:.9375rem}.c-logo-opts .store-tab .line-1{left:25%}.c-logo-opts .store-tab .line-2{left:50%}.c-logo-opts .store-tab .line-3{left:75%}.c-share-wrap{position:absolute;left:0;right:0;bottom:0;border-top:.25rem solid #d84a57;z-index:12;background-color:#eeeef3}.c-share-wrap .share-icon{position:relative;margin-bottom:.625rem;background:#fff;border-bottom:.0625rem solid #c8c7cc}.c-share-wrap .share-icon .share-title{font-size:1rem;padding-top:1.125rem;padding-left:.75rem;padding-bottom:1rem;color:#666}.c-share-wrap .share-icon .divider{position:absolute;top:3.25rem;left:50%;width:.0625rem;height:3.625rem;background:#dfdfdf}.c-share-wrap [class*="block-grid-"]{margin:0}.c-share-wrap [class*="block-grid-"] li{text-align:center;font-size:.75rem;color:#666}.c-share-wrap [class*="block-grid-"] li p{padding-top:.5rem;padding-bottom:.688rem}.c-share-wrap [class*="block-grid-"] a{display:block;width:3.25rem;margin:0 auto}.c-share-wrap .share-cancel{display:block;background:#fff;height:2.4375rem;line-height:2.4375rem;color:#545454;border-top:.0625rem solid #c8c7cc;text-align:center;font-size:.875rem;color:#626263;font-weight:bold}.c-coupon{position:relative;padding-top:.3125rem;padding-bottom:.3125rem;padding-left:0;padding-right:0;min-height:59px}#coupon-slide{min-height:59px;overflow:hidden}.c-coupon .slide-area{min-height:59px;width:1518px}.c-coupon .slide-area .item{position:relative;width:138px;min-height:59px}.c-coupon .coupon{position:relative;display:block;margin-left:10px}.c-coupon .coupon img{display:block;width:100%}.c-coupon .coupon .info{position:absolute;top:55%;left:16%;right:16%;bottom:0;text-align:center}.c-coupon .coupon .info p{margin-top:0;font-size:.75rem;vertical-align:baseline;color:#fff}.c-coupon .coupon .info .price{vertical-align:baseline;color:#fff}.c-coupon .more{position:absolute;top:50%;left:.625rem;display:block;color:#999;font-size:.75rem;line-height:1.125rem;margin-top:-0.563rem;padding-right:.563rem}.c-coupon .more .icon-more{position:absolute;top:.25rem;right:0;display:block;width:.375rem;height:.625rem;background-image:url("../../icon8.png");background-repeat:no-repeat;background-size:100%}.c-coupon .active .mask{display:block;cursor:default}.c-coupon .mask{position:absolute;top:0;right:0;bottom:0;left:0;background:rgba(0,0,0,0.2);display:none}.c-coupon .mask .icon-got{position:absolute;bottom:0;right:0;display:block;width:2.781rem;height:2.75rem;background-image:url("../../icon33.png");background-repeat:no-repeat;background-size:100%}.c-coupon .rollimage-position{display:none}.mask.c-edit-mask-none{display:none !important}.c-full-cut{padding-top:.625rem;padding-bottom:.625rem;padding-left:.625rem;padding-right:.625rem}.c-full-cut .activity-img{display:block;text-align:center}.cw-activity-txt .link{font-size:.875rem;line-height:1.125rem;position:relative;display:block;padding:.6875rem 2.1875rem .6875rem 1.125rem;cursor:default;color:#3e3a39}.cw-activity-txt .link.active .icon-link{display:block}.cw-activity-txt .link .icon-link{position:absolute;top:1rem;right:1.5625rem;display:none;width:.34375rem;height:.625rem;background-image:url('./icon35.png');background-repeat:no-repeat;background-size:100%}.c-rollimage-activity{overflow:hidden;padding:.625rem;background-color:#fff}.c-rollimage-activity .rollimage{position:relative;overflow:hidden;width:100%}.c-rollimage-activity .rollimage .rollimage-img a{display:block;width:100%;height:100%;text-align:center}.c-rollimage-activity .rollimage .rollimage-position{position:absolute;left:50%;bottom:.313rem}.c-rollimage-activity .rollimage .rollimage-position li{width:.375rem;height:.375rem;margin-left:.438rem;background:rgba(0,0,0,0.4);-moz-border-radius:.25rem;-webkit-border-radius:.25rem;border-radius:.25rem}.c-rollimage-activity .rollimage .rollimage-position li:first-child{margin-left:0}.c-rollimage-activity .rollimage .rollimage-position li.active{background:#fff}.cw-activity-single{padding-top:.625rem;padding-bottom:.625rem;padding-left:.625rem;padding-right:.625rem}.cw-activity-single .activity-img{display:block;text-align:center}.c-product-value{padding-top:1rem;padding-left:.625rem;padding-right:.625rem;*zoom:1}.c-product-value:before,.c-product-value:after{display:table;content:""}.c-product-value:after{clear:both}.c-product-value .header{margin-bottom:.688rem;height:1.25rem;line-height:1.25rem;overflow:hidden;font-size:1rem;color:#4c4c4c}.c-product-value [class*="block-grid-"]{margin:0 -0.25rem}.c-product-value [class*="block-grid-"] li{margin-bottom:.625rem;padding:0 .25rem}.c-product-value [class*="block-grid-"] li>a{display:block;padding-bottom:.5rem;border:.0625rem solid #d9d9d9;color:#333}.c-product-value [class*="block-grid-"] .p-img{text-align:center}.c-product-value [class*="block-grid-"] .p-info{margin-top:.1875rem;margin-bottom:.3125rem;margin-left:.625rem;margin-right:.625rem;overflow:hidden;text-shadow:0 1px 0 rgba(255,255,255,0.85)}.c-product-value [class*="block-grid-"] .flag{margin-left:.625rem;*zoom:1}.c-product-value [class*="block-grid-"] .flag:before,.c-product-value [class*="block-grid-"] .flag:after{display:table;content:""}.c-product-value [class*="block-grid-"] .flag:after{clear:both}.c-product-value [class*="block-grid-"] .price{float:left;font-size:.938rem;line-height:1.25rem;height:1.25rem}.c-product-value .more{position:relative;padding-right:.75rem;padding-bottom:.5rem;color:#999;font-size:.938rem;line-height:1.688rem;float:right}.c-product-value .more .icon-more{position:absolute;top:.438rem;right:0;display:block;width:.438rem;height:.75rem;background-image:url("../../icon8.png");background-repeat:no-repeat;background-size:100%}body{background:#f2f1f6;color:#333}.base{margin-top:.625rem;background:#fff;border-top:.0625rem solid #c8c7cc;border-bottom:.0625rem solid #c8c7cc}.p-img{background:#f1f1f1}.p-info{height:2.375rem;color:#333;font-size:.813rem;line-height:1.188rem}.price{color:#e43743}.c-product-all{margin-top:1.438rem;margin-bottom:1.438rem;height:2.5rem}.c-product-all a{display:block;color:#4c4c4c;line-height:2.5rem;font-size:.938rem;text-align:center}.c-product-all a .icon-all{position:relative;top:.16rem;display:inline-block;width:1.063rem;height:1.063rem;background-image:url("../../icon9.png");background-repeat:no-repeat;background-size:100%}.p-vip{float:left;margin-left:.375rem;width:1.063rem;height:1.063rem;background:url("../../vip.png") no-repeat 0 0;background-size:1.063rem 1.063rem}.c-mask .mask{position:fixed;top:0;right:0;bottom:0;left:0;z-index:9;display:none;background:rgba(0,0,0,0.4)}.c-category-list{position:fixed;top:0;right:-17.5rem;bottom:0;z-index:10;padding-top:1.688rem;width:0;overflow:auto;background:#f6f6f6;box-shadow:-1px 0 5px rgba(0,0,0,0.28);-moz-box-shadow:-1px 0 5px rgba(0,0,0,0.28);-webkit-box-shadow:-1px 0 5px rgba(0,0,0,0.28);-webkit-transition:width .3s ease-out;-moz-transition:width .3s ease-out;-o-transition:width .3s ease-out;transition:width .3s ease-out}.c-category-list.category-show-1{width:17.5rem;right:0}.c-category-list .name{color:#424242;font-size:1.25rem;line-height:1.5;text-align:center}.c-category-list .score{padding-top:.375rem;padding-bottom:1.563rem;color:#8c8c8c;font-size:.75rem;line-height:1.5;text-align:center}.c-category-list .score .icon-empty,.c-category-list .score .icon-full{display:inline-block;width:.625rem;height:.5rem;background-image:url(".icon10.png");background-repeat:no-repeat;background-size:100%}.c-category-list .score .icon-full{background-image:url("../../icon11.png")}.c-category-list .score span{margin-left:.2rem}.c-category-list .score-list{position:relative;margin-left:.625rem;margin-right:.625rem;margin-bottom:.688rem;background:#fff}.c-category-list .score-list .divider{position:absolute;top:.625rem;left:33.33%;width:1px;height:2.25rem;background:#dadada}.c-category-list .score-list .divider:last-child{left:66.66%}.c-category-list [class*="block-grid-"]{margin:0;border:1px solid #e1e1e1;-moz-border-radius:.25rem;-webkit-border-radius:.25rem;border-radius:.25rem}.c-category-list [class*="block-grid-"] .key{padding-top:.563rem;text-align:center;color:#424242;font-size:.75rem;line-height:1.25}.c-category-list [class*="block-grid-"] .value{padding-bottom:.25rem;color:#979797;font-size:.813rem;line-height:1.625rem;text-align:center}.c-category-list [class*="block-grid-"] .value .icon-down,.c-category-list [class*="block-grid-"] .value .icon-up{position:relative;top:.281rem;display:inline-block;margin-right:.375rem;width:1.063rem;height:1.063rem;background-image:url("../../icon12.png");background-repeat:no-repeat;background-size:100%}.c-category-list [class*="block-grid-"] .value .icon-up{background-image:url("../../icon13.png")}.c-category-list .category-list.active .header{border-bottom:.0625rem solid #c8c7cc}.c-category-list .category-list.active .header .icon-open{background-image:url("../../icon29.png")}.c-category-list .category-list.active .list{display:block}.c-category-list .category-list:last-child .header{border-bottom:.0625rem solid #c8c7cc}.c-category-list .category-list .header{position:relative;height:2.813rem;line-height:2.813rem;border-top:.0625rem solid #c8c7cc;color:#4c4c4c;font-size:.938rem;padding-left:.938rem}.c-category-list .category-list .header .icon-open{position:absolute;top:1.063rem;right:.625rem;display:block;width:1rem;height:.625rem;background-image:url("../../icon14.png");background-repeat:no-repeat;background-size:100%}.c-category-list .category-list .header a{color:#4c4c4c}.c-category-list .category-list .list{display:none;background:#e6e6e6}.c-category-list .category-list .list li{height:2.5rem;overflow:hidden}.c-category-list .category-list .list li.active a{background:#ccc}.c-category-list .category-list .list li a{display:block;width:100%;padding-left:.938rem;height:100%;color:gray;line-height:2.5rem;font-size:.938rem}
    </style>
    <script type="text/javascript" src="/static/wx/js/jquery.js"></script>
    <script src="/Apps/Wx/View/goods.js?v=222"></script>
    <script type="text/javascript" src="/static/wx/js/common.js"></script>
   </head>
<body class="iframe-body websiteWrapper pageWrapper homePageWrapper portfolioTwoFilterablePageWrapper">
<div id="content_dom" class="pw-panel-container">

    <!--搜索头部-->
    <div class="row c-header-toolbar">
        <div class="small-12">
            <div class="search">
                <!--<form action="#" method="post">-->
                    <!--<input type="text" name="keyword" id="mobile_shop_search" placeholder="搜索店铺内商品" url="#"/>-->
                <!--</form>-->
                <!--<a href="javascript:" class="icon-search mobile_shop_btn J_ping" report-eventid="MOldShop_StartSearch" event_level="3" ></a>-->
                <!--<s></s>-->
                &nbsp;
            </div>
            <a href="javascript:history.back(-1)" class="icon-return"></a>
            <a href="javascript:;" class="icon-nav" hidden></a>
        </div>
    </div>
    <div class="row c-logo-opts">
        <div class="small-12 back-logo" style="background-image: url('/<?php echo ($shop["shopBanner"]); ?>')">
            <div class="small-12 bottom">
                <a class="store-block">
                    <img src="/<?php echo ($shop["shopImg"]); ?>" alt="<?php echo ($shop["shopName"]); ?>"/>
                    <div class="store-text">
                        <div class="store-name"><?php echo ($shop["shopName"]); ?></div>
                        <div class="store-info  self "><?php echo ($shopInfo["onFavoriteCnt"]); ?>人关注</div>
                    </div>
                </a>
                <!--关注加active-->
                <div class="store-follow j-m-follow" onclick="favoriteShops(<?php echo ($shopId); ?>);" id="shopfavoriteshops" f="<?php echo ((isset($favoriteType) && ($favoriteType !== ""))?($favoriteType):'0'); ?>" <?php if($favoriteType != '0'): ?>style="background-position:center top;"<?php endif; ?> ></div>
            </div>
        </div>
        <div class="store-tab">
            <a class="small-3 left tab J_ping" report-eventid="MOldShop_AllProduct" event_level="3">
                <div class="num"><?php echo ($shopInfo["onSaleGoodsCnt"]); ?></div>
                <div class="text">全部商品</div>
            </a>
            <a class="small-3 left tab J_ping" href="javascript:void(0);">
                <div class="num"><?php echo ($shopInfo["weekOrderCnt"]); ?></div>
                <div class="text">周销量</div>
            </a>
            <a href="javascript:void(0);" class="small-3 left tab J_ping" >
                <div class="num"><?php echo ($shopInfo["monthOrderCnt"]); ?></div>
                <div class="text">月销量
                </div>
            </a>
            <a class="small-3 left j-m-share tab J_ping" report-eventid="MOldShop_Share" event_level="3">
                <div class="share">
                    <div class="i-share"></div>
                </div>

            </a>
            <div class="line line-1"></div>
            <div class="line line-2"></div>
            <div class="line line-3"></div>
        </div>
    </div>

    <!--<div class="row c-share-wrap hide">-->
        <!--<div class="small-12">-->
            <!--<div class="share-icon">-->
                <!--<div class="share-title">-->
                    <!--<span>分享到</span>-->
                <!--</div>-->
                <!--<ul class="small-block-grid-2">-->
                    <!--<li>-->
                        <!--<a href="javascript:;" id="qrcode">-->
                            <!--<img src="//static.360buyimg.com/panda_cube/img/img17.png">-->
                        <!--</a>-->
                        <!--<p>二维码</p>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="javascript:;" id="sina" target="_blank">-->
                            <!--<img src="//static.360buyimg.com/panda_cube/img/img18.png">-->
                        <!--</a>-->
                        <!--<p>新浪微博</p>-->
                    <!--</li>-->
                <!--</ul>-->
                <!--<div class="divider"></div>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="small-12">-->
            <!--<a href="javascript:;" class="share-cancel">取消</a>-->
        <!--</div>-->
    <!--</div>-->

    <!--双11四免一活动-->
    <div id="j-full-cut" class="row base c-full-cut" style="display:none;">
    </div>
    <!--<div class="row base cw-activity-txt floor">-->
        <!--<div class="small-12">-->
            <!--&lt;!&ndash;配置活动后加class:active&ndash;&gt;-->
            <!--<a href="javascript:;" class="link J_ping " report-eventid="MOldShop_Activity" event_level="3">-->
                <!--<span>#5月26日16点，惠普大事件！！！#</span>-->
                <!--<i class="icon-link"></i>-->
            <!--</a>-->
        <!--</div>-->
    <!--</div>-->

    <div class="row base c-rollimage-activity">
        <div class="small-12">
            <div class="rollimage" id="jdSlider">
                <div class="rollimage-img">
                    <ul class="clearfix">
                        <?php if(is_array($shop["hotgoods"])): $i = 0; $__LIST__ = $shop["hotgoods"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data-productid="">
                            <a href="<?php echo U('wx/goods/getgoodsdetails',array('goodsId'=>$vo['goodsId']));?>" class="J_ping" report-eventid="MOldShop_Activity" event_level="2">
                                <img src="/<?php echo ($vo["goodsImg"]); ?>" alt=""></a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <div class="rollimage-position">
                    <ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--&lt;!&ndash;单列活动&ndash;&gt;-->
    <!--<div class="row base cw-activity-single">-->
        <!--<div class="small-12">-->
            <!--<a href="shop-show.html" class="activity-img J_ping" report-eventid="MOldShop_Activity" event_level="3" >-->
                <!--<img src="http://img12.360buyimg.com/jshopm/jfs/t2425/148/1867438280/115183/5119d8bd/56834d8fN2c4942be.jpg" alt="" img-size="686,362"/>-->
            <!--</a>-->
        <!--</div>-->
    <!--</div>-->

    <!--&lt;!&ndash;单列活动&ndash;&gt;-->
    <!--<div class="row base cw-activity-single">-->
        <!--<div class="small-12">-->
            <!--<a href="shop-show.html" class="activity-img J_ping" report-eventid="MOldShop_Activity" event_level="3" >-->
                <!--<img src="http://img12.360buyimg.com/jshopm/jfs/t2347/172/1176925627/124461/f4669d89/56834d8fN38980632.jpg" alt="" img-size="686,362"/>-->
            <!--</a>-->
        <!--</div>-->
    <!--</div>-->

    <!--&lt;!&ndash;单列活动&ndash;&gt;-->
    <!--<div class="row base cw-activity-single">-->
        <!--<div class="small-12">-->
            <!--<a href="shop-show.html" class="activity-img J_ping" report-eventid="MOldShop_Activity" event_level="3" >-->
                <!--<img src="http://img11.360buyimg.com/jshopm/jfs/t2773/295/1157085084/100764/7c764fde/57355221N65c805cd.jpg" alt="" img-size="686,362"/>-->
            <!--</a>-->
        <!--</div>-->
    <!--</div>-->

    <!--&lt;!&ndash;单列活动&ndash;&gt;-->
    <!--<div class="row base cw-activity-single">-->
        <!--<div class="small-12">-->
            <!--<a href="shop-show.html" class="activity-img J_ping" report-eventid="MOldShop_Activity" event_level="3" >-->
                <!--<img src="http://img10.360buyimg.com/jshopm/jfs/t2854/345/1143168142/108703/ae7f4720/57355224Ndacec203.jpg" alt="" img-size="686,362"/>-->
            <!--</a>-->
        <!--</div>-->
    <!--</div>-->
    <?php if(is_array($shop['catgoods'])): $i = 0; $__LIST__ = $shop['catgoods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="row base c-product-value">
        <div class="small-12">
            <div class="header clearfix">
                <span><?php echo ($vo["catName"]); ?></span>
            </div>
            <ul class="small-block-grid-2">
                <?php if(is_array($vo['goods'])): $i = 0; $__LIST__ = $vo['goods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><li data-productid="1956794">
                    <a href="<?php echo U('wx/goods/getgoodsdetails',array('goodsId'=>$voo['goodsId']));?>" class="J_ping" report-eventid="MOldShop_ProductProduct" event_level="4">
                        <div class="p-img">
                            <img src="/<?php echo ($voo['goodsThums']); ?>" data-src="/<?php echo ($voo['goodsThums']); ?>" data-row="2" srcset="/<?php echo ($voo['goodsThums']); ?>">
                        </div>
                        <div class="p-info"><?php echo ($voo['goodsName']); ?></div>
                        <div class="flag">
                            <span class="price" jshop="price" jdprice="1956794" jskuprice="1956794"></span>
                        </div>
                    </a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>

    <!--<div class="row base c-product-value">-->
        <!--<div class="small-12">-->
            <!--<div class="header clearfix">-->
                <!--<span>家用台式机</span>-->
            <!--</div>-->
            <!--<ul class="small-block-grid-2">-->
                <!--<li data-productid="1622288">-->
                    <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ProductProduct" event_level="4">-->
                        <!--<div class="p-img">-->
                            <!--<img src="http://img14.360buyimg.com/n2/jfs/t2611/93/459584275/169224/3f9846e1/5714a387N5c7f592a.jpg" data-src="http://img12.360buyimg.com/n2/jfs/t2611/93/459584275/169224/3f9846e1/5714a387N5c7f592a.jpg" data-row="2" srcset="http://img12.360buyimg.com/n2/jfs/t2611/93/459584275/169224/3f9846e1/5714a387N5c7f592a.jpg 320W,http://img10.360buyimg.com/n1/jfs/t2611/93/459584275/169224/3f9846e1/5714a387N5c7f592a.jpg 640W">-->
                        <!--</div>-->
                        <!--<div class="p-info">惠普（HP）550-052cn 台式电脑（i5-4460 4G 500G 2G独显 DVD 键鼠 Win8.1）23英寸显示器</div>-->
                        <!--<div class="flag">-->
                            <!--<span class="price" jshop="price" jdprice="1622288" jskuprice="1622288"></span>-->
                        <!--</div>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li data-productid="1603743">-->
                    <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ProductProduct" event_level="4">-->
                        <!--<div class="p-img">-->
                            <!--<img src="http://img12.360buyimg.com/n2/jfs/t2635/50/456940519/169224/3f9846e1/5714a1a0N5f335bd1.jpg" data-src="http://img14.360buyimg.com/n2/jfs/t2635/50/456940519/169224/3f9846e1/5714a1a0N5f335bd1.jpg" data-row="2" srcset="http://img13.360buyimg.com/n2/jfs/t2635/50/456940519/169224/3f9846e1/5714a1a0N5f335bd1.jpg 320W,http://img12.360buyimg.com/n1/jfs/t2635/50/456940519/169224/3f9846e1/5714a1a0N5f335bd1.jpg 640W">-->
                        <!--</div>-->
                        <!--<div class="p-info">惠普（HP）550-051cn 台式电脑（i5-4460 8G 1T GTX745 4G独显 Win8.1）23英寸显示器</div>-->
                        <!--<div class="flag">-->
                            <!--<span class="price" jshop="price" jdprice="1603743" jskuprice="1603743"></span>-->
                        <!--</div>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li data-productid="1680913">-->
                    <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ProductProduct" event_level="4">-->
                        <!--<div class="p-img">-->
                            <!--<img src="http://img12.360buyimg.com/n2/jfs/t2509/42/411060827/41335/8c3760aa/564aeb32N886ef136.jpg" data-src="http://img12.360buyimg.com/n2/jfs/t2509/42/411060827/41335/8c3760aa/564aeb32N886ef136.jpg" data-row="2" srcset="http://img12.360buyimg.com/n2/jfs/t2509/42/411060827/41335/8c3760aa/564aeb32N886ef136.jpg 320W,http://img11.360buyimg.com/n1/jfs/t2509/42/411060827/41335/8c3760aa/564aeb32N886ef136.jpg 640W">-->
                        <!--</div>-->
                        <!--<div class="p-info">惠普（HP）251-032cn 台式电脑（i3-4170 4G 500G 2G独显 DVD刻录 WiFi 蓝牙 键鼠 win8.1）18.5英寸显示器</div>-->
                        <!--<div class="flag">-->
                            <!--<span class="price" jshop="price" jdprice="1680913" jskuprice="1680913"></span>-->
                        <!--</div>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li data-productid="1603753">-->
                    <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ProductProduct" event_level="4">-->
                        <!--<div class="p-img">-->
                            <!--<img src="http://img12.360buyimg.com/n2/jfs/t2410/59/1648853125/428462/6e3eeaf6/566148ddNc584b1d2.jpg" data-src="http://img13.360buyimg.com/n2/jfs/t2410/59/1648853125/428462/6e3eeaf6/566148ddNc584b1d2.jpg" data-row="2" srcset="http://img11.360buyimg.com/n2/jfs/t2410/59/1648853125/428462/6e3eeaf6/566148ddNc584b1d2.jpg 320W,http://img10.360buyimg.com/n1/jfs/t2410/59/1648853125/428462/6e3eeaf6/566148ddNc584b1d2.jpg 640W">-->
                        <!--</div>-->
                        <!--<div class="p-info">惠普（HP）251-025cn 台式电脑（G3260 4G 500G DVD刻录 WiFi 蓝牙 键鼠 Win8.1）18.5英寸显示器</div>-->
                        <!--<div class="flag">-->
                            <!--<span class="price" jshop="price" jdprice="1603753" jskuprice="1603753"></span>-->
                        <!--</div>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li data-productid="1366143">-->
                    <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ProductProduct" event_level="4">-->
                        <!--<div class="p-img">-->
                            <!--<img src="http://img11.360buyimg.com/n2/jfs/t1189/90/71983277/60866/5cf9b3b3/54f8049cNcfe0e267.jpg" data-src="http://img11.360buyimg.com/n2/jfs/t1189/90/71983277/60866/5cf9b3b3/54f8049cNcfe0e267.jpg" data-row="2" srcset="http://img11.360buyimg.com/n2/jfs/t1189/90/71983277/60866/5cf9b3b3/54f8049cNcfe0e267.jpg 320W,http://img10.360buyimg.com/n1/jfs/t1189/90/71983277/60866/5cf9b3b3/54f8049cNcfe0e267.jpg 640W">-->
                        <!--</div>-->
                        <!--<div class="p-info">惠普（HP）Pavilion Mini 小叮当 300-010cn 台式机主机 （2957U 4G 500G wifi 蓝牙 win8.1）</div>-->
                        <!--<div class="flag">-->
                            <!--<span class="price" jshop="price" jdprice="1366143" jskuprice="1366143"></span>-->
                        <!--</div>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li data-productid="2194706">-->
                    <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ProductProduct" event_level="4">-->
                        <!--<div class="p-img">-->
                            <!--<img src="http://img14.360buyimg.com/n2/jfs/t2077/57/1475920625/48530/6a00bb78/56615ed7N6fb4a08c.jpg" data-src="http://img11.360buyimg.com/n2/jfs/t2077/57/1475920625/48530/6a00bb78/56615ed7N6fb4a08c.jpg" data-row="2" srcset="http://img11.360buyimg.com/n2/jfs/t2077/57/1475920625/48530/6a00bb78/56615ed7N6fb4a08c.jpg 320W,http://img12.360buyimg.com/n1/jfs/t2077/57/1475920625/48530/6a00bb78/56615ed7N6fb4a08c.jpg 640W">-->
                        <!--</div>-->
                        <!--<div class="p-info">惠普（HP）20-e018cn 19.45英寸 一体机（赛扬 4G 500G Win10）白色</div>-->
                        <!--<div class="flag">-->
                            <!--<span class="price" jshop="price" jdprice="2194706" jskuprice="2194706"></span>-->
                        <!--</div>-->
                    <!--</a>-->
                <!--</li>-->
            <!--</ul>-->
        <!--</div>-->
    <!--</div>-->

    <!--&lt;!&ndash;全部商品&ndash;&gt;-->
    <!--<div class="row base c-product-all">-->
        <!--<div class="small-12">-->
            <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_BottomAllProduct" event_level="3" >-->
                <!--<i class="icon-all"></i>-->
                <!--<span>全部商品</span>-->
            <!--</a>-->
        <!--</div>-->
    <!--</div>-->
    <!--&lt;!&ndash;遮罩层&ndash;&gt;-->
    <!--<div class="row c-mask">-->
        <!--<div class="small-12">-->
            <!--<div class="mask"></div>-->
        <!--</div>-->
    <!--</div>-->
    <!--<div class="row c-category-list">-->
        <!--<div class="small-12">-->
            <!--<div class="row collapse">-->
                <!--<div class="small-12">-->
                    <!--&lt;!&ndash;店铺名&ndash;&gt;-->
                    <!--<div class="name">惠普官方旗舰店</div>-->
                    <!--&lt;!&ndash;店铺评分&ndash;&gt;-->
                    <!--<div class="score">-->
                        <!--<i class="icon-full"></i>-->
                        <!--<i class="icon-full"></i>-->
                        <!--<i class="icon-full"></i>-->
                        <!--<i class="icon-full"></i>-->
                        <!--<i class="icon-full"></i>-->
                        <!--<span></span>-->
                    <!--</div>-->
                    <!--&lt;!&ndash;评分详细信息&ndash;&gt;-->
                    <!--<div class="score-list">-->
                        <!--<ul class="small-block-grid-3">-->
                            <!--<li>-->
                                <!--<div class="key">商品评分</div>-->
                                <!--<div class="value"><i class="  icon-down "></i><span></span></div>-->
                            <!--</li>-->
                            <!--<li>-->
                                <!--<div class="key">服务评分</div>-->
                                <!--<div class="value"><i class=" icon-down "></i><span></span></div>-->
                            <!--</li>-->
                            <!--<li>-->
                                <!--<div class="key">时效评分</div>-->
                                <!--<div class="value"><i class=" icon-down "></i><span></span></div>-->
                            <!--</li>-->
                        <!--</ul>-->
                        <!--<div class="divider"></div>-->
                        <!--<div class="divider"></div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
            <!--&lt;!&ndash;分类详情&ndash;&gt;-->
            <!--<div class="category-list">-->
                <!--<div class="header">-->
                    <!--<span>家用笔记本</span>-->
                    <!--<i class="icon-open"></i>                             </div>-->
                <!--<ul class="list">-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">ENVY系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">Pavilion系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">HP系列</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
            <!--<div class="category-list">-->
                <!--<div class="header">-->
                    <!--<span>家用台式机</span>-->
                    <!--<i class="icon-open"></i>                             </div>-->
                <!--<ul class="list">-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">Pavilion 分体机系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">Pavilion一体机系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">HP分体机系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">HP一体机</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
            <!--<div class="category-list">-->
                <!--<div class="header">-->
                    <!--<span>家用显示器</span>-->
                    <!--<i class="icon-open"></i>                             </div>-->
                <!--<ul class="list">-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">ENVY系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="//ok.jd.com/m/list-1000000155-3506056-1-1-10-1.htm" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">Pavilion系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">HP系列</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
            <!--<div class="category-list">-->
                <!--<div class="header">-->
                    <!--<span>商用笔记本</span>-->
                    <!--<i class="icon-open"></i>                             </div>-->
                <!--<ul class="list">-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">超值商用系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">精英商用系列</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
            <!--<div class="category-list">-->
                <!--<div class="header">-->
                    <!--<span>商用台式机</span>-->
                    <!--<i class="icon-open"></i>                             </div>-->
                <!--<ul class="list">-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">超值商用系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">精英系列系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">专业商用系列</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
            <!--<div class="category-list">-->
                <!--<div class="header">-->
                    <!--<span>商用显示器</span>-->
                    <!--<i class="icon-open"></i>                             </div>-->
                <!--<ul class="list">-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">HP Value系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">HP ProDisplay系列</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">HP EliteDisplay系列</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
            <!--<div class="category-list">-->
                <!--<div class="header">-->
                    <!--<span>工作站</span>-->
                    <!--<i class="icon-open"></i>                             </div>-->
                <!--<ul class="list">-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">台式工作站</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">移动工作站</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">一体式工作站</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
            <!--<div class="category-list">-->
                <!--<div class="header">-->
                    <!--<span>电脑配件</span>-->
                    <!--<i class="icon-open"></i>                             </div>-->
                <!--<ul class="list">-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">键盘</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">鼠标</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">耳机</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">音箱</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="shop-show.html" class="J_ping" report-eventid="MOldShop_ClassificationTwo" event_level="3">电脑包</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
</div>
<script src="../../../../../wx/shops/s/mping.min.js"></script>


<link rel="stylesheet" href="/Public/plugins/layer/skin/layerwx.css">
<script src="/static/wx/bx/js/msgalert.js"></script>
<script src="http://cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
<script>
    $(document).ready(function(){
            //加速点击
        FastClick.attach(document.body);
    })
</script>
<!--微信分享-->
<?php if($signPackage != ''): ?><script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        wx.config({
            appId: '<?php echo $signPackage["appId"];?>',
            timestamp:'<?php echo $signPackage["timestamp"];?>',
             nonceStr: '<?php echo $signPackage["nonceStr"];?>',
            signature: '<?php echo $signPackage["signature"];?>',
            jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage']
        });
        wx.ready(function (){
            var word = window.location.href;
            var bbb = word.split(".htm");
            var url =  bbb[0]+"/pid/<?php echo ($WST_USER['userId']); ?>";
            var imgurl = 'http://xihuansha.greenfoodweb.com/Upload/goods/2016-04/570f7318257e3.jpg';
            wx.onMenuShareTimeline({
                title: '分享标题', // 分享标题
                desc: '分享描述', // 分享描述
                link: url, // 分享链接
                imgUrl:imgurl, // 分享图标
                success: function () {
                },
                cancel: function () {
                }
            });
           //获取“分享给朋友”按钮点击状态及自定义分享内容接口
            wx.onMenuShareAppMessage({
                title: '分享标题', // 分享标题
                desc: '分享描述', // 分享描述
                link: url, // 分享链接
                imgUrl:imgurl, // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                },
                cancel: function () {
                }
            });
        });

    </script><?php endif; ?>
</body>
</html>