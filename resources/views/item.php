
<?= view('menu') ?>

<table>
    <?php foreach ($row as $name => $value) { ?>
        <tr>
            <td><?= $name ?></td>
            <td><?= $value ?></td>
        </tr>
    <?php } ?>
</table>

<?php foreach ($iconTypeList as $typeId => $iconType) { ?>
    <?php if ($row->$iconType)  { ?>
        <img src="/images/<?=  $row->{$iconType . '_path'} ?>">

        <a href="?delete_icon=1&type=<?= $typeId ?>">delete<a>

    <?php } ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

        upload <?= $iconType ?>
        <input name="icon" type="file" multiple>
        <input type="hidden" name="type" value="<?= $typeId ?>">
        <input type="submit" value="upload">
    </form>
<?php } ?>
