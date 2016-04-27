<?
$end_points = $this->getReplacement('end_points');
?>
FORMAT: 1A
HOST: https://api.gochipon.net

<a href='./index.html'>戻る</a>

# Group <?= $this->getReplacement('group'); ?>

<?= $this->getReplacement('description'); ?>

<? foreach ($end_points as $end_point) { ?>
## <?= $end_point['title']; ?> [<?= $end_point['http_method']; ?> <?= $end_point['path']; ?>]
```
<?= $end_point['description']; ?>

```

+ Parameters
<? foreach ($end_point['parameters'] as $parameter) { ?>
    + <?= $parameter['name']; ?>: (<?= $parameter['type'] ?>, <?= $parameter['status']; ?>) - <?= $parameter['description'] ?>

<? } ?>

+ Response 200 (application/json)
    + Body
        <?= $end_point['response']; ?>


<? } ?>
