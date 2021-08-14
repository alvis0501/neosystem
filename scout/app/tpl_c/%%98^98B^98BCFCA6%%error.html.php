<?php /* Smarty version 2.6.31, created on 2020-07-10 00:22:54
         compiled from error.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'error.html', 28, false),)), $this); ?>
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
	<h1>ネオシステム管理</h1>
	<nav>
		<a href="https://newcss.net">Home</a> /
		<a href="https://newcss.net/usage/">Usage</a> /
		<a href="https://newcss.net/usage/elements/">Elements</a> /
		<a href="https://newcss.net/themes/">Themes</a> /
		<a href="https://github.com/xz/new.css">GitHub</a> / 
		<a href="https://discord.gg/hhuuC4w">Discord</a>
	</nav>
</header>

<h3>エラー</h3>

<ul>
	<?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
		<li style="color:#f00"><?php echo ((is_array($_tmp=$this->_tpl_vars['e'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</li>
	<?php endforeach; endif; unset($_from); ?>
</ul>

<p><a href="javascript:history.back();">→戻る</a></p>

</body>
</html>