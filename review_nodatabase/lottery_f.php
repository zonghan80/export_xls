<?php
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
                        <span class="sr-only">抽獎</span>
                        <span class="icon-bar">列表</span>						
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
                        <a href="lottery_f.php" class="list-group-item active">抽獎</a>
                        <a href="list_f.php" class="list-group-item">列表</a>							
                    </div>
                </div>

                <div class="col-md-9">				
                    <h4>時間:<input id="time" type="date" value="" style="margin: 10px 10px; font-size: 25px;"/> </h4><br>  
                    <h4>姓名:<input id="name" type="text" name="name" value="ZongHan" style="margin: 10px 10px; font-size: 25px;"/> </h4><br>  <!--欄位預設文字背景-->
                    <!--<input id="phone" type="text" name="phone" placeholder="手機" onkeyup="this.value = this.value.replace(/\D/g, '')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="10" /> 以數字格式09開頭輸入，失敗出現:手機格式錯誤!<br>
                    <input id="email" type="text" name="email" placeholder="E-MAIL" /> 以信箱@XXX.com(.tw)形式輸入，失敗出現:E-MAIL格式不符!<br> -->
                    <button  type="button" id="go" class="btn btn-success" style="margin: 10px 10px; font-size: 25px;"/>抽獎</button><!--不可有任一欄位空白，失敗出現:不可有欄位空白!-->
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
        <script>

			$(function () {
				$('#go').click(function () { //按下按鈕後執行function
				
					var time = $('#time').val();
					var name = $('#name').val();
				
					$that = $(this);
					$.ajax({
						url: "lottery_b.php", //要連線的php      \
						data: {
							time: time,
							name: name
						},
						type: "POST", //連線方式
						dataType: "json",
						success: function (msg) {  //成功後 alert訊息 後重整資料
							alert(msg.data.title);
							if (msg.flag) {
								location.reload();
							}

						}
					});
				});
			});

        </script>
		<script language="JavaScript"> 
			document.getElementById('time').valueAsDate = new Date();
		</script> 
    </body>

</html>