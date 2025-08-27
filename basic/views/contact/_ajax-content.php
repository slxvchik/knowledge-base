<div>
    <div>id контакта: <?= $contact->id; ?></div>
    <div>Имя: <?= $contact->first_name; ?></div>
    <div>Фамилия: <?= $contact->second_name; ?></div>
    <?php
    if($deals) {
        foreach($deals as $deal) {
    ?>
            <div>id сделки: <?= $deal->id; ?> <?= $deal->name; ?></div>
    <?php
        }
    }
    ?>
</div>