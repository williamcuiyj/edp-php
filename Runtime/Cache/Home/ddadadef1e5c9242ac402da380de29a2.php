<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
    <meta name="apple-mobile-web-app-cable" content="yes"/><!-- 删除苹果默认的工具栏和菜单栏 -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/><!-- 设置苹果的工具栏颜色 -->
    <meta name="viewport" content="width=device-width,initial-scale-1,user-scalable=no"/>
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/Public/static/edp/css/myStyle.css">
</head>
<body>
<section class="personal-container">
    <header class="personal-container-header">
        <div class="personal-container-avatar">
            <img src="/Public/static/edp/imgs/avatar.jpg" alt="avatar">
        </div>
        <div class="personal-title">
            <div class="personal-name"><?php echo ($edpuser["real_name"]); ?></div><div class="personal-level"><?php echo ($edpuser["user_type"]); ?></div>
        </div>
        <div class="personal-number">
            <?php echo ($edpuser["mobile"]); ?>
        </div>
    </header>
    <section class="personal-detail">
        <section class="personal-detail-item">
            <div class="personal-detail-item-contant">
                <div class="personal-detail-name">邮 箱 ：</div>
                <div class="personal-detail-contant" id="email"><?php echo ($edpuser["email"]); ?></div>
            </div>
            <div class="personal-detail-item-contant">
                <div class="personal-detail-name">QQ 号 ：</div>
                <div class="personal-detail-contant" id="qq"><?php echo ($edpuser["qq"]); ?></div>
            </div>
        </section>
        <section class="personal-detail-item">
            <div class="personal-detail-item-contant">
                <div class="personal-detail-name">身份证：</div>
                <div class="personal-detail-contant" id="card"><?php echo ($edpuser["id_number"]); ?></div>
            </div>
            <div class="personal-detail-item-contant">
                <div class="personal-detail-name">单 位：</div>
                <div class="personal-detail-contant" id="company"><?php echo ($edpuser["company"]); ?></div>
            </div>
            <div class="personal-detail-item-contant">
                <div class="personal-detail-name">职 务：</div>
                <div class="personal-detail-contant" id="company_title"><?php echo ($edpuser["company_title"]); ?></div>
            </div>
            <div class="personal-detail-item-contant">
                <div class="personal-detail-name">工作地址：</div>
                <div class="personal-detail-contant" id="company_addr"><?php echo ($edpuser["company_addr"]); ?></div>
            </div>
            <div class="personal-detail-item-contant">
                <div class="personal-detail-name">办公电话：</div>
                <div class="personal-detail-contant" id="company_phone"><?php echo ($edpuser["company_phone"]); ?></div>
            </div>
        </section>
        <section class="personal-detail-item">
            <div class="personal-detail-item-contant">
                <div class="personal-detail-name">学 历：</div>
                <div class="personal-detail-contant" id="degree"><?php echo ($edpuser["degree"]); ?></div>
            </div>
            <div class="personal-detail-item-contant">
                <div class="personal-detail-name">毕业学校：</div>
                <div class="personal-detail-contant" id="school"><?php echo ($edpuser["school"]); ?></div>
            </div>
            <div class="personal-detail-item-contant">
                <div class="personal-detail-name">毕业时间：</div>
                <div class="personal-detail-contant" id="finish_school"><?php echo ($edpuser["finish_school"]); ?></div>
            </div>
        </section>
    </section>
</section>
<input type="button" value="编辑" class="personal-done" id="personal-edit">
<input type="button" value="完成" class="personal-done" id="personal-done">
<script type="text/javascript" src="/Public/static/edp/js/jquery-3.1.1.min.js"></script>
<script>
    var isIDCard1=/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/;
    var isIDCard2=/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/;
    var isQQ=/^\d[1-9]{5,10}$/;
    var isEmail=/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    var isMobile=/^1(3|4|5|7|8)\d{9}$/;
    var test01=0,test02=0,test03=0,test04=0;
    var inputLength=$(".personal-detail-contant").length-1;

    $('#personal-edit').click(function () {
        $(this).css('display','none');
        $("#personal-done").css('display','block');
        $('.personal-detail-contant').attr('contenteditable','true');
        $('.personal-detail-contant').css('outline','1px solid rgba(0,0,0,.1)');
//            window.location.href="<?php echo U('Edp/logout');?>";
    });
    $('#personal-done').click(function () {
        $(".personal-detail-contant").each(function (i,n) {
            if(!$(n).text()){
                alert($(n).prev().text()+' 不能为空');
                test01=0;
                return false;
            }else {

                if(i == inputLength){
                    test01=1;
                    past();
                }
            }

        });
        function past() {
            if(isIDCard1.test($("#card").text()) || isIDCard2.test($("#card").text())){
                test02=1;
            }else {
                alert("请填写正确的身份证号");
                test02=0;
                return false;
            }
            if(!isQQ.test($("#qq").text())){
                alert('请输入正确的qq号');
                test03=0;
                return false;
            }else {
                test03=1;
            }
            if(!isEmail.test($('#email').text())){
                alert('请输入正确的邮箱');
                test04=0;
                return false;
            }else {
                test04=1;
            }
        }

//==============通过表单验证=============
        if(test04 && test03 && test02 && test01){
            $.ajax({
                type: "POST",
                url: "<?php echo U('Edp/editprofile');?>",
                dataType: 'json',
                async: false,
                data: {
                    email:$("#email").html(),
                    qq:$("#qq").html(),
                    id_number:$("#card").html(),
                    company:$("#company").html(),
                    company_title:$("#company_title").html(),
                    company_addr:$("#company_addr").html(),
                    company_phone:$("#company_phone").html(),
                    degree:$("#degree").html(),
                    school:$("#school").html(),
                    finish_school:$("#finish_school").html()
                },
                success: function(data){
                    if(data['status'] == 1){
                        $(this).css('display','none');
                        $("#personal-edit").css('display','block');
                        $('.personal-detail-contant').attr('contenteditable','false');
                        $('.personal-detail-contant').css('outline','none');
                    }
                    if(data['status'] == 0){
                        alert(data['info']);
                    }
                },
                error:function (data) {
                    alert('ajax错误!');
                }
            });

        }
    })
</script>
</body>
</html>