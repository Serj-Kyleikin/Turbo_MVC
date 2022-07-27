<?php

    $static = $page[0]['static'];
    $count = count($static);

    $previous = $page[0]['pagination']['previous'];
    $next = $page[0]['pagination']['next'];
?>

<div>
    <? if($count): for($i = 0; $i < $count; $i++): 

        $post = $static[$i];
    ?>
        <div class="job">
            <p>Требуется: <? echo $post['name']; ?></p>
            <p class="description"><? echo $post['text']; ?></p>
            <hr>
            <div>
                <span>Зарплата:</span><p> <? echo $post['salary']; ?></p>
            </div>
            <div>
                <span>График:</span><p> <? echo $post['worktime']; ?></p>
            </div>
            <hr>
        </div>
    <? endfor; else: ?>
        <p>Новых вакансий нет.</p>
    <? endif; ?>
</div>

<div class="pagination">
    <?php if(isset($previous) and $previous): echo "<a href='/" . $previous . "'>Назад</a>"; endif; ?>
    <?php if(isset($next) and $next): echo "<a href='/" . $next . "'>Вперёд</a>"; endif; ?>
</div>