<?php
require_once './_header.php';
?>

			<div class="page-title">
				
				<div class="title-env">
					<h1 class="title">用户中心</h1>
					<p class="description">个人资料，用户信息等..</p>
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
						<strong>升级账户</strong>
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
                        <p>用户名：<?php echo $U->GetUserName(); ?></p>
                        <p>套餐：<code> <?php echo $oo->get_plan();?> </code> </p>
                        <p>账户余额：<?php echo $oo->get_money();?>元 </p>
                        <p><a class="btn btn-info" href="javascript:;" id="updatePlan">升级账户等级</a>&nbsp;&nbsp;</p>
					</div>
				</div>
			</div>
		</div>
    </div>
<script>
    $(document).ready(function(){
        $("#updatePlan").click(function(){
            $.ajax({
                type:"GET",
                url:"/action/plan_update",
                dataType:"json",
                success:function(data){
                    if(data.error){
                        showToastr(data.msg, 0);
                    }else{
                        showToastr(data.msg, 0);
                        //刷新页面
                        //window.location.reload();
                    }
                },
                error:function(jqXHR){
                    showToastr("发生错误："+jqXHR.status, 0);
                }
            })
        });
    });
</script>
<?php include_once "./footer.php";?>