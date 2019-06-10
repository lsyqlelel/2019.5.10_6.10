<?php foreach($fang as $v):?>
    <html>
    <tr>
        <td><?php echo $v['type']."------" ?></td>
        <td><?php echo $v['term']."------" ?></td>
        <td><?php
             echo "<a href = {$v['website']} >GO</a>";
             echo "<br/>"
             ?>
        </td>
    </tr>
    </html>
<?php endforeach; ?>
<?php echo $link ?>
