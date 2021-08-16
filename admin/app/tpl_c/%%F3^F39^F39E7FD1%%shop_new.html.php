<?php /* Smarty version 2.6.31, created on 2020-07-10 03:35:58
         compiled from shop_new.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'shop_new.html', 33, false),)), $this); ?>
<html>
<head>
<title>ネオシステム ログイン</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/open-fonts@1.1.1/fonts/inter.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@exampledev/new.css@1.1.2/new.min.css">
</head>

<body>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_body_header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<h3>店舗新規登録</h3>

<form action="index.php" method="post">
<input type="hidden" name="flow" value="shop_new">
<input type="hidden" name="type" value="exec">

<p>
	<label>店舗名</label><br>
	<input type="text" name="shop_name" value="">
	<br>

	<label>契約日 YYYY/MM/DD</label><br>
	<input type="text" name="shop_name" value="">
	<br>

	<label>業種</label><br>
	<select name="shop_category">
	<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
		<option><?php echo ((is_array($_tmp=$this->_tpl_vars['c']['shop_category_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</option>
	<?php endforeach; endif; unset($_from); ?>
	</select>
	<br>

	<label>エリア</label><br>
	<select name="shop_category_large">
		<option value="">-----</option>
	<?php $_from = $this->_tpl_vars['area_large']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['a']):
?>
		<option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['a']['area_large_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['a']['area_large_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
エリア</option>
	<?php endforeach; endif; unset($_from); ?>
	</select>
	<select name="shop_category_small">
		<option>池袋</option>
		<option>新宿</option>
		<option>渋谷</option>
	</select>
	<br>

	<label>ログインID</label><br>
	<input type="text" name="login_id" value="">
	<br>

	<label>パスワード</label><br>
	<input type="text" name="password" value="">
	<br>

	<label>契約日 YYYY/MM/DD</label><br>
	<input type="text" name="contract_date" value="">
	<br>

	<label>キャッチコピー</label><br>
	<input type="text" name="catch" value="">
	<br>

	<label>URL</label><br>
	<input type="text" name="url" value="">
	<br>

	<label>電話番号</label><br>
	<input type="text" name="tel" value="">
	<br>

	<label>LINE ID</label><br>
	<input type="text" name="line_id" value="">
	<br>

	<label>詳細</label><br>
	<textarea name="detail"></textarea>
	<br>

	<label>備考メモ</label><br>
	<input type="text" name="seigen" value="">
	<br>

	<label>面接ストップ</label><br>
	<input type="checkbox" name="id_stop" value="1">←面接ストップにする場合はチェック
	<br>

	<label>ラグゼ評価［情報提供料］</label><br>
	<input type="text" name="assess_price" value="">
	<br>

	<label>ラグゼ評価［リピートの場合］</label><br>
	<input type="text" name="assess_repeat" value="">
	<br>

	<label>ラグゼ評価［枝バック］</label><br>
	<input type="text" name="assess_eda_back" value="">
	<br>

	<label>ラグゼ評価［集金日］</label><br>
	<input type="text" name="assess_money" value="">
	<br>

</p>

<p>
	<button>登録</button>
</p>

</form>

</body>
</html>