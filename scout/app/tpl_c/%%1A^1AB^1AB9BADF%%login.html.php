<?php /* Smarty version 2.6.31, created on 2020-07-10 04:54:18
         compiled from login.html */ ?>
<html>
<head>
<title>ネオシステム ログイン</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/open-fonts@1.1.1/fonts/inter.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@exampledev/new.css@1.1.2/new.min.css">
</head>

<body>

<header>
	<h1>ネオシステム</h1>
</header>


<h3>ログイン</h3>

<form action="index.php" method="post">
<input type="hidden" name="flow" value="">
<input type="hidden" name="type" value="login">

<p>
	<label>ID</label><br>
	<input type="text" name="login_id" value="">
</p>
<p>
	<label>パスワード</label><br>
	<input type="password" name="password" value="">
</p>
<p>
	<button>ログイン</button>
</p>

</form>

</body>
</html>