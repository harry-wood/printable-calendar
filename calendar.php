<?php
if (!isset($_GET['addmonth'])) {
   //========= Show form ========
   $pageTitle = "Printable calendar";
   $depth = 0;
   include("./include/header.php");
?>
<div id="contentpanel">

<h2>Printable Calendar</h2>

<form method="GET" action="calendar.php">
Month
<select name="addmonth">
  <option value="-1">Last month</option>
  <option value="0" selected>This month</option>
  <option value="1">Next month</option>
  <option value="2">Month after that</option>
</select><br>

Height for week day <input name="height"   type="text" size="5" value="3.7"><br>
Height for weekend  <input name="weheight" type="text" size="5" value="4.5"><br>
<br>
<input type="submit">
</form>
<a href="https://github.com/harry-wood/printable-calendar" style="font-weight:normal; font-size:0.9em;">code on github</a>
<?php
include("./include/footer.php");


} else {
   //=========  Show calendar ========
   $addmonth = isset($_GET['addmonth']) ? $_GET['addmonth'] : 0;
   $height   = isset($_GET['height'])   ? $_GET['height']   : "3.7";
   $weheight = isset($_GET['weheight']) ? $_GET['weheight'] : "4.5";

   if (!is_numeric($addmonth) || !is_numeric($height) || !is_numeric($weheight)) die('not a number');
?>
<html>
<head>
<title>Printable Calendar</title>
<style>
table.monthstrip {
    background: WHITE;
    border: 1px #aaa solid;
    border-collapse: collapse;
    font-size: 0.9em;
    width:100%;
}

table.monthstrip td.date {
    width: 4em;
}

tr.dayMon, tr.dayTue, tr.dayWed, tr.dayThu, tr.dayFri {
    height:<?php echo htmlspecialchars($height); ?>em;
}

tr.daySat, tr.daySun{
    background:#EEEEEE;
    height:<?php echo htmlspecialchars($weheight); ?>em;
}
</style>
</head>
<body>
   <?php
   $ts = mktime(0, 0, 0, date("m"), 1, date("Y")); #First day of current month
   $ts = strtotime("+" . $addmonth . " month", $ts); //add a month to ts
   $endOfMonth = false;

   print "<h3>" . date("F", $ts) . "</h3>";
   print "<table class=\"monthstrip\" border=\"1\">";

   while (!$endOfMonth) {
      print "<tr class=\"day" . date("D", $ts) . "\">";
      print "  <td class=\"date\">" . date("jS D", $ts) . "</td>";
      print "  <td class=\"writingspace\">&nbsp;</td>";
      print "</tr>\n";

      $ts = strtotime("+1 day",$ts); //add a day to the timestamp
      if (date("j", $ts)=="1") $endOfMonth = true;
   }
   print "</table>";
   print "</body>";
   print "</html>";

} //endif
