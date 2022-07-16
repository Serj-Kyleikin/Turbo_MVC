<?php

$vacancys = $page['content'];
$countVacancys = count($vacancys);

?>

<div>
    <? if(isset($vacancys)): ?>
        <? for($i=0; $i<$countVacancys; $i++): ?>
            <div class="job">
                <p>Требуется: <? echo $vacancys[$i]['name']; ?></p>
                <p class="description"><? echo $vacancys[$i]['text']; ?></p>
                <hr>
                <div>
                    <span>Зарплата:</span><p> <? echo $vacancys[$i]['salary']; ?></p>
                </div>
                <div>
                    <span>График:</span><p> <? echo $vacancys[$i]['worktime']; ?></p>
                </div>
                <hr>
            </div>
        <? endfor; ?>
    <? else: ?>
        <p>Новых вакансий нет.</p>
    <? endif; ?>
</div> 
