///

SCHEDULING THE PAGE TO BE RUN
To schedule the page to be run at regular intervals, use the wget download utility to
perform the visit. The wget utility is mainly used for downloading files, so on Linux
you will need to send any output to /dev/null:
foo@bar:~$ wget –-delete-after
http://localhost/auction/processauctions.php
To schedule this to occur at regular intervals, add the following line to a cron
job. First, load the crontab with the following:
foo@bar:~$ crontab –e
To run the command every five minutes, add the following line to the crontab:
*/5 * * * * wget —delete-after
http://localhost/auction/processauctions.php
You can set this in Windows by using the Schedule Tasks option in the Control
Panel. Inside this dialog box, select the program to run and specify the time.
Be sure to change the URL to one that is relevant to your computer.

///
<?php
require(“config.php”);
require(“header.php”);
$itemssql = “SELECT users.username, users.email, items.id,
items.name FROM items, users WHERE dateends < NOW() AND
items.user_id = users.id AND endnotified = 0;”;
$itemsresult = mysql_query($itemssql);
while($itemsrow = mysql_fetch_assoc($itemsresult)) {
    $bidssql = “SELECT bids.amount, users.username,
users.email FROM bids, users WHERE bids.user_id = users.id
    AND item_id = “ . $itemsrow[‘id’] . “ ORDER BY amount
DESC LIMIT 1;”;
$bidsresult = mysql_query($bidssql);
$bidsnumrows = mysql_num_rows($bidsresult);
    $own_owner = $itemsrow[‘username’];
$own_email = $itemsrow[‘email’];
$own_name = $itemsrow[‘name’];if($bidsnumrows == 0) {
        $owner_body=<<<_OWNER_
Hi $own_owner,
Sorry, but your item ‘$own_name’, did not have any bids placed with it.
_OWNER_;
        mail($own_email, “Your item ‘“ . $own_name
        . “‘ did not sell”, $owner_body);
}else {
        echo “item with bids” . $itemsrow[‘id’];
$bidsrow = mysql_fetch_assoc($bidsresult);
$own_highestbid = $bidsrow[‘amount’];
$win_winner = $bidsrow[‘username’];
$win_email = $bidsrow[‘email’];
$owner_body=<<<_OWNER_
Hi $own_owner,
Congratulations! The auction for your item ‘$own_name’,
has completed with a winning bid
of $config_currency$own_highestbid bidded by $win_winner!
Bid details:
Item: $own_name
Amount: $config_currency$own_highestbid
Winning bidder: $win_winner ($win_email)
It is recommended that you contact the winning bidder within 3 days.
_OWNER_;
$winner_body=<<<_WINNER_
Hi $win_winner,
Congratulations! Your bid of $config_currency$own_highestbid for
the item ‘$own_name’ was the highest bid!Bid details:
Item: $own_name
Amount: $config_currency$own_highestbid
Owner: $own_owner ($own_email)
It is recommended that you contact the owner of the item within 3 days.
_WINNER_;
mail($own_email, “Your item ‘“ . $own_name
        . “‘ has sold”, $owner_body);
mail($win_email, “You won item ‘“ . $own_name
        . “‘!”, $winner_body);$updsql = “UPDATE items SET endnotified = 1 WHERE id = “ .
$itemsrow[‘id’];
echo $updsql;
mysql_query($updsql);
}require(“footer.php”);
?>