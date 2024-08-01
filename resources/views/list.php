
<?= view('menu') ?>

<form>
    <?php foreach ($_GET as $name => $param) { ?>
        <?php if ($name != 'search') { ?>
            <input type="hidden" name="<?= $name ?>" value="<?= $param ?>">
        <?php } ?>
    <?php } ?>

    <input name="search" value="<?= $_GET['search'] ?>">
    <input type="submit" value="поиск">
</form>

<table>
    <tr>
        <th>title</th>
        <th>type</th>
    </tr>
    <?php foreach ($data as $row) { ?>
        <tr>
            <td><a href="/<?= $row->id ?>"><?= $row->title ?></a></td>
            <td><?= $row->type ?></td>
        </tr>
    <?php } ?>
</table>
