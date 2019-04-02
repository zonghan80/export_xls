<?php
include_once 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ZongHan</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/shop-item.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
	<body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="icon-bar">合圖</span>
                        <span class="icon-bar">抽獎</span>
                        <span class="sr-only">列表</span>
                    </button>
                    <a class="navbar-brand">Program</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="composite_f.php">合圖</a>
                        </li>
                        <li>
                            <a href="lottery_f.php">抽獎</a>
                        </li> 
						<li>
                            <a href="list_f.php">列表</a>
                        </li> 
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="container">

            <div class="row">

                <div class="col-md-3">
                    <p class="lead">Review</p>
                    <div class="list-group">
                        <a href="composite_f.php" class="list-group-item">合圖</a>
                        <a href="lottery_f.php" class="list-group-item">抽獎</a>
                        <a href="list_f.php" class="list-group-item active">列表</a>						
                    </div>
                </div>
		<div class="col-md-9">
					<h4>姓名:<input id="name" type="text" name="name" value="ZongHan" style="margin: 10px 10px; font-size: 25px;"/> </h4>
					<button  type="button" id="go" class="btn btn-success" style="margin: 10px 10px; font-size: 25px;" onclick="clickCount();"/>送出</button>
				</div>
                <div class="col-md-9" id="forlist" style="display:none;border-top-style:dotted;">
					<form id="form1" name="form1" method="post" action="">
                    <!--列表-->
					<div class="col-md-9" id="go_view" style="position: relative;margin-top: 20px;margin-bottom: 20px;" >
					全選:<input type="checkbox" name="clickall" onclick="clickAll(this);" style="margin-right: 20px;"/>
					<input type="button" id="del" onclick="delnode()" value="批量删除" style="margin-right: 20%;"/>
					搜尋顯示名稱:<input type="search" class="light-table-filter" data-table="order-table" placeholder="請輸入關鍵字">

					</div>

                    <table class="order-table" style="margin-top: 80px; width: 100%; max-width: 100%; margin-bottom: 20px;">
                        <thead>
                            <tr>
								<th>勾選</th>
								<th>ID</th>								
                                <th>顯示名稱</th>
								<th>圖片</th>
                                <th>資料填寫時間</th>
                            </tr>
                        </thead>
                        <tbody id="list_total">
							<tr class="success" style="display: none;">
								<td><input type="checkbox" name="select[]" value="" style="display: none;" class="select"/></td>
								<td><input type="hidden" id="count" name="count[]" value="0"><span id="num" name="num[]"></span></td>											
								<td><span id="name_s" name="name_s[]"></span></td>
								<td><img id="img_s" style="width: 200px;" name="img_s[]"></img></td>
								<td><span id="time_s" name="time_s[]"></span></td>
							</tr>
                        </tbody>
                    </table>
					</form>
                </div>



            </div>

        </div>
        <!-- /.container -->

        <div class="container">

            <hr>

            <!-- Footer -->
            <footer>
                <div class="row">
                    <div class="col-lg-12">
                        <p>Copyright &copy; Your Website 2019</p>
                    </div>
                </div>
            </footer>

        </div>
        <!-- /.container -->

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
		
		<script src="js/search.js"></script>
        <script>
			function delnode(){
				var chk=document.getElementsByName('select[]');
				for(var i=chk.length-1;i>=0;i--){
					var mychk=chk[i];
					if(mychk.checked==true){
						mytr=mychk.parentNode.parentNode;
						pnode=mytr.parentNode;
						pnode.removeChild(mytr);
					}
				}
				if(chk.length-1 <=0){
					location.reload();
				}

			}
			function clickAll(chk){
				 var chklist=document.getElementsByName('select[]');

				 for(var i=0;i<chklist.length;i++){
					 chklist[i].checked=chk.checked;
				 }
			}
			function clickCount() {
				var count=document.getElementById("count").value;
				if(document.getElementById("name").value != ''){				
				count++;
				}
				document.getElementById("count").value=count;	
			}
            $(function () {
				
				$('#go').click(function () {
					var name = $('#name').val();
					var count = $('#count').val();
					
					$.ajax({
						url: "list_rand.php", //要連線的php
						data: {
							name: name,
							count: count,
						}, //要傳的欄位id: $_POST['xx']
						type: "POST", //連線方式
						dataType: "json",
						success: function (json) {  //成功後 alert訊息 後重整資料
								if(json.flag){
								$("#forlist").show();

								$(".order-table #list_total").append('<tr><td><input type="checkbox" id="select_item" name="select[]" value=""/></td><td>'+
								json.data.ID+'</td><td>'+json.data.name+'</td><td><img id="img" src="../test/src/'+json.data.pic_src+
								'" style="width: 200px;"></img></td><td>'+json.data.time+'</td></tr>');								
								} else{
								document.getElementById("count").value = document.getElementById("count").value;
								alert(json.data.title);
								}	
						}					
					});
				});
				$('#del').click(function () {
				});	

            });
        </script>		
	</body>			
</html>