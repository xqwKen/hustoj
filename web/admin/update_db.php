<?require("admin-header.php");

if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}?>
<?
$tsql=Array();
$csql=Array();
$tsql[0]="select 1 from topic limit 1";
$csql[0]="
CREATE TABLE `topic` (
  `tid` int(11) NOT NULL auto_increment,
  `title` varbinary(60) NOT NULL,
  `status` int(2) NOT NULL default '0',
  `top_level` int(2) NOT NULL default '0',
  `cid` int(11) default NULL,
  `pid` int(11) NOT NULL,
  `author_id` varchar(20) NOT NULL,
  PRIMARY KEY  (`tid`),
  KEY `cid` (`cid`,`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
$tsql[1]="select 1 from reply limit 1";
$csql[1]="
CREATE TABLE `reply` (
 `rid` int(11) NOT NULL auto_increment,
 `author_id` varchar(20) NOT NULL,
 `time` datetime NOT NULL default '0000-00-00 00:00:00',
 `content` text NOT NULL,
 `topic_id` int(11) NOT NULL,
 `status` int(2) NOT NULL default '0',
 `ip` varchar(30) NOT NULL,
 PRIMARY KEY  (`rid`),
 KEY `author_id` (`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
$tsql[2]="
ALTER TABLE `jol`.`problem` DROP COLUMN `sample_Program`,
 DROP COLUMN `ratio`,
 DROP COLUMN `error`,
 DROP COLUMN `difficulty`,
 DROP COLUMN `submit_user`,
 DROP COLUMN `case_time_limit`;
 ";
$csql[2]="";
$tsql[3]="select 1 from sim limit 1";
$csql[3]="
CREATE TABLE `sim` (
  `s_id` int(11) NOT NULL,
  `sim_s_id` int(11) NULL,
  `sim` int(11) NULL,
  PRIMARY KEY  (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$tsql[4]="select 1 from mail limit 1";
$csql[4]="
CREATE TABLE `mail` (

  `mail_id` int(11) NOT NULL auto_increment,
  `to_user` varchar(20) NOT NULL default '',
  `from_user` varchar(20) NOT NULL default '',
  `title` varchar(200) NOT NULL default '',
  `content` text,
  `new_mail` tinyint(1) NOT NULL default '1',
  `reply` tinyint(4) default '0',
  `in_date` datetime default NULL,
  `defunct` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`mail_id`),
  KEY `uid` (`to_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;";
$tsql[5]="ALTER TABLE `solution` MODIFY COLUMN `user_id` CHAR(20)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	DROP COLUMN `className`,MODIFY COLUMN `ip` CHAR(15)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
$csql[5]="";

$tsql[6]="select langmask from contest limit 1;";
$csql[6]="ALTER TABLE `contest` ADD COLUMN `langmask` TINYINT  NOT NULL DEFAULT 0 COMMENT 'bits for LANG to mask' AFTER `private`;";

$tsql[7]="whatever;";
$csql[7]="optimize table `compileinfo`,`contest` ,`contest_problem` ,`loginlog`,`news`,`privilege`,`problem` ,`solution`,`source_code`,`users`,`topic`,`reply`,`online`,`sim`,`mail`;";

$tsql[8]="select langmask from contest limit 1;";
$csql[8]="ALTER TABLE `contest` MODIFY COLUMN `langmask` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'bits for LANG to mask';";

if(isset($_POST['do'])){
	require_once("../include/check_post_key.php");
	echo "Executing...<br>";
	for($i=0;isset($tsql[$i]);$i++){
		if(!$res=mysql_query($tsql[$i])){
				echo $csql[$i]."<br>";
				mysql_query($csql[$i]);
		}else{
				echo mysql_error()."<br>";
		}
		
	}
}
?>
<b>Update DataBase</b>
	Create New Tables ,drop useless columes.
	<b>Necessary for using plagiarism detection.</b>
	<form action='update_db.php' method=post>
		<?require_once("../include/set_post_key.php");?>
		<input type='hidden' name='do' value='do'>
		<input type=submit value=Update>
	</form>
	
