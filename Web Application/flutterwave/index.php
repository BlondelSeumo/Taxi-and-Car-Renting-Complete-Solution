<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Rave payment Gateway</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <form action="pay.php" method="POST" name="f1" style="display:none;">

        <label>Email</label>
        <input type="email" name="email" hidden value="<?php echo $_GET['email'];?>">
        <br>
        <label>Amount</label>
        <input type="number" name="amount" hidden value="<?php echo $_GET['amt'];?>">
        <br>
       

        </form>
		 <script type="text/javascript">
            document.f1.submit();
        </script> 
    </body>
</html>