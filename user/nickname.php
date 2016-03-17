<?php
require_once './_header.php';
?>

			<div class="page-title">
				
				<div class="title-env">
					<h1 class="title">修改昵称</h1>
					<p class="description">修改账户的昵称, 用于展示</p>
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
						<strong>修改昵称</strong>
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
                        <label for="field-1" class="control-label">旧昵称：</label>
						<input type="text" class="form-control disabled" id="nickname-old" placeholder="<?php echo $U->GetUserName(); ?>" value="<?php echo $U->GetUserName(); ?>" disabled="disabled">
						<label for="field-1" class="control-label">新的昵称：</label>
						<input type="text" class="form-control" id="nickname-new" placeholder="<?php echo $U->GetUserName(); ?>">
					</div>
				</div>
                <button class="btn btn-info btn-block" id="submit-nickname">确定修改</button>
			</div>
		</div>
    </div>
    <script>
        $(document).ready(function(){
            $("#submit-nickname").click(function(){
                var nickname = $("#nickname-new").val();
                if(nickname == null || nickname == '') {
                    showToastr("你不填写就想改真的好吗?", 0, 2000);
                    return;
                }
                $(this).attr('disabled',"true");
                $.ajax({
                type:"POST",
                url:"/action/m_nickname",
                data:{nickname:$("#nickname-new").val()},
                dataType:"json",
                success:function(result){
                	showToastr(result.msg, 0);
                	setTimeout(function(){
                	    location.reload();
                	}, 3000);
                },
                error:function(jqXHR){
                	showToastr("发生错误："+jqXHR.status, 0);
                	$(this).removeAttr('disabled');
                }
            })
            });
        });
        //nickname-new
    </script>
<?php include_once "./footer.php";?>