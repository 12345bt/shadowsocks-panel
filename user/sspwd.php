<?php
require_once './_header.php';
?>

			<div class="page-title">
				
				<div class="title-env">
					<h1 class="title">修改SS密码</h1>
					<p class="description">修改Shadowsocks连接密码, 请妥善保管</p>
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
						<strong>SS密码</strong>
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
                        <label for="field-1" class="control-label">Shadowsocks连接密码：</label>
						<input type="text" class="form-control" id="sspwd" placeholder="Shadowsocks connection password">
					</div>
				</div>
				<div><span><code>注意：修改连接密码后各服务器数据同步可能不及时，可能会导致某些服务节点连接不上，密码错误等。如需立即生效，可以发Ticket到我的邮件 18x@mloli.com 会在第一时间立即同步个服务节点密码</code></span></div><br/>
                <button class="btn btn-info btn-block" id="submit-pwd">确定修改</button>
			</div>
		</div>
    </div>
    <script>
        $(document).ready(function(){
            $("#submit-pwd").click(function(){
                var but = $(this);
                var sspwd = $("#sspwd").val();
                if(sspwd == null || sspwd == '') {
                    /*
                    showToastr("Shadowsocks连接密码不能为空", 0, 2000);
                    return;
                    */
                    var flags = confirm("如果连接密码留空，将再一次随机生成连接密码，请问真的要这么做吗？");
                    if(!flags) {
                        return;
                    }
                }
                but.attr('disabled', 'true').addClass('disabled');
                $.ajax({
                type:"POST",
                url:"/action/m_sspwd",
                data:{
                    'sspwd': sspwd,
                },
                dataType:"json",
                success:function(result){
                	showToastr(result.msg, 0);
                	but.removeAttr('disabled').removeClass('disabled');
                	if(result.sspwd!=null && result.sspwd != '') $("#sspwd").val(result.sspwd);
                },
                error:function(jqXHR){
                	showToastr("发生错误："+jqXHR.status, 0);
                	but.removeAttr('disabled').removeClass('disabled');
                }
            })
            });
        });
        //nickname-new
    </script>
<?php include_once "./footer.php";?>