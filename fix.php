<?php
session_name("fix");session_start();require("inc/base.php");$sql = new sql(conf::get()["sql"]["server"], conf::get()["sql"]["user"], conf::get()["sql"]["pass"], conf::get()["sql"]["db"]);if(!isset($_SESSION["page"])) {	$_SESSION["page"] = 0;} else {	$_SESSION["page"]++;}$books = $sql::get("SELECT id,cat,title FROM lib_books ORDER BY cat DESC, title DESC LIMIT ".($_SESSION["page"]*100).",100");$c = 0;$t = "";$tit = $books[0]["title"];foreach($books as $k => $v) {	if($v["cat"] !== $t) {		$t = $v["cat"];		$c = 0;	}	$q = "UPDATE lib_books SET catindex = '".$c."' WHERE id = ".$v["id"];	$ok = $sql::set($q);	if($v["title"] !== $tit) {		$c++;	}	$tit = $v["title"];}if($_SESSION["page"] < 10) {	header("Location: fix.php");} else {	session_destroy();	echo("Klar!");}?>