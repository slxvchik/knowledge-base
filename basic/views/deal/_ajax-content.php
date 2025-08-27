<div>
    <div>id сделки: <?= $deal->id; ?></div>
    <div>Наименование: <?= $deal->name; ?></div>
    <div>Сумма: <?= $deal->sum; ?></div>
    <?php
    if($contacts) {
        foreach($contacts as $contact) {
    ?>
            <div>id сделки: <?= $contact->id; ?> <?= $contact->first_name . ' ' . $contact->second_name; ?></div>
    <?php
        }
    }
    ?>
</div>