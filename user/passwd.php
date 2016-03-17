<?php
require_once './_header.php';
?>

			<div class="page-title">
				
				<div class="title-env">
					<h1 class="title">修改密码</h1>
					<p class="description">修改网站登陆密码, 请妥善保管</p>
				</div>
				
				<div class="breadcrumb-env">
					<ol class="breadcrumb bc-1">
						<li>
							<a href="/member"><i class="fa-home"></i>主页</a>
						</li>
						<li>
							<a href="javascript:;">我的信息</a>
						</li>
						<li class="active">
						<strong>修改密码</strong>
						</li>
					</ol>
				</div>
			</div>
	<div class="row">
	    <div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-angle-right"></i>
				</div>
				<div class="panel-body">
                    <div class="form-group">
                        <label for="field-1" class="control-label">旧密码：</label>
						<input type="password" class="form-control" id="nowpwd" placeholder="旧密码">
						<label for="field-2" class="control-label">新密码：</label>
						<input type="password" class="form-control" id="pwd" placeholder="新密码">
						<label for="field-3" class="control-label">确认新密码：</label>
						<input type="password" class="form-control" id="repwd" placeholder="再次输入新密码">
					</div>
				</div>
                <button class="btn btn-info btn-block" id="submit-pwd">确定修改</button>
			</div>
		</div>
    </div>
    <script>
        $(document).ready(function(){
            $("#submit-pwd").click(function(){
                var but = $(this);
                var nowpwd = $("#nowpwd").val();
                var pwd = $("#pwd").val();
                var repwd = $("#repwd").val();
                if(nowpwd == null || nowpwd == '') {
                    showToastr("旧密码不能为空", 0, 2000);
                    return;
                }
                if(pwd == null || pwd == '' || repwd ==null || repwd =='') {
                    showToastr("新密码不能为空", 0, 2000);
                    return;
                }
                if(pwd != repwd && pwd != null && repwd != null) {
                    showToastr("两次密码不一致", 0, 2000);
                    return;
                }
                but.attr('disabled', 'true').addClass('disabled');
                $.ajax({
                type:"POST",
                url:"/action/m_passwd",
                data:{
                    'nowpwd': nowpwd,
                    'pwd': pwd,
                    'repwd': repwd
                },
                dataType:"json",
                success:function(result){
                    but.removeAttr('disabled').removeClass('disabled');
                	showToastr(result.msg, 0,5000);
                },
                error:function(jqXHR){
                    but.removeAttr('disabled').removeClass('disabled');
                	showToastr("发生错误："+jqXHR.status, 0);
                }
            })
            });
        });
        //nickname-new
    </script>
<?php include_once "./footer.php";?>