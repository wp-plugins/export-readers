<?php header("Content-type: text/css"); ?>
div.s4v_<?php echo $_GET['t']?>
{
	border:none;
	padding:0;
	margin:0;
}
div.s4v_<?php echo $_GET['t']?> fieldset
{
	border:none;
	padding:5px;
	margin:2px;
}
div.s4v_<?php echo $_GET['t']?> fieldset.error
{
	border:1px solid #ff5555;
	background-color:#ffeeee;
	padding:5px;
	margin:2px;
}
div.s4v_<?php echo $_GET['t']?> label.question
{
}
div.s4v_<?php echo $_GET['t']?> label.option
{
}
div.s4v_<?php echo $_GET['t']?> input.radio
{
	padding:0;
	margin:0;
}
div.s4v_<?php echo $_GET['t']?> div.title
{
	font-weight:bold;
	font-size: 8pt;
}
div.s4v_<?php echo $_GET['t']?> th.name,
div.s4v_<?php echo $_GET['t']?> th.bbcode,
div.s4v_<?php echo $_GET['t']?> th.answer,
div.s4v_<?php echo $_GET['t']?> th.options
{
}
div.s4v_<?php echo $_GET['t']?> th.delete,
div.s4v_<?php echo $_GET['t']?> th.status,
div.s4v_<?php echo $_GET['t']?> th.source,
div.s4v_<?php echo $_GET['t']?> th.edit
{
	width:120px;
}
div.s4v_<?php echo $_GET['t']?> th.questions
{
	width:250px;
}
div.s4v_<?php echo $_GET['t']?> th.quick_help,
div.s4v_<?php echo $_GET['t']?> th.type
{
	width:85px;
}
div.s4v_<?php echo $_GET['t']?> input.text,
div.s4v_<?php echo $_GET['t']?> textarea.text
{
	width:98%;
}