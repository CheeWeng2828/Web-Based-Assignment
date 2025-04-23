<?php
include '../base.php';

auth();

$id = req('id');

//// Display detail 罢了

$profile = $_db->prepare('SELECT * FROM user WHERE id = ?');
$profile->execute([$id]);
$detail = $profile->fetchAll();

$addr = $_db->prepare('SELECT address FROM user_payment WHERE user_id = ?');
$addr->execute([$id]);
$address = $addr->fetch();

$_title = 'User Detail';
include '../head.php'
?>

<table>
    <?php foreach($detail as $d): ?>

    <tr>
    <th>Name</th>
    <td><?= $d->name?></td>
    </tr>
    
    <tr>
    <th>Name</th>
    <td><?= $d->name?></td>
    </tr>
    
<?php endforeach ?>
</table>

<?php
include '../foot.php';
