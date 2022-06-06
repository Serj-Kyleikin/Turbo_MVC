<?php

$pages = $page['content']['pages'];
$countPages = count($pages);

$vacancys = $page['content']['vacancys'];
$countVacancys = count($vacancys);

?>

<div class="cabinet">
    <div class="information_menu">
        <p>Меню администратора</p>    
        <ul class="information_tabs">
            <li data-tab="0" class="information_tab"><a>Страницы</a></li>
            <li data-tab="1" class="information_tab"><a>Вакансии</a></li>
        </ul> 
    </div>
    <div class="information_show">
        <div class="information_content active">
            <form name="SettingsPages" method="post" action="javascript:updateInfo('SettingsPages')">
                <div>
                    <? for($i=0; $i<$countPages; $i++): ?>
                        <h3><? echo $pages[$i]['title']; ?></h3>
                        <div>
                            <label>meta (title)</label>
                            <textarea type="text" name="<? echo $pages[$i]['name']; ?>_name"><? echo $pages[$i]['title']; ?></textarea>
                        </div>
                        <div>
                            <label>meta (description)</label>
                            <textarea type="text" name="<? echo $pages[$i]['name']; ?>_description"><? echo $pages[$i]['description']; ?></textarea>
                        </div>
                        <div>
                            <label>h1</label>
                            <textarea type="text" name="<? echo $pages[$i]['name']; ?>_title"><? echo $pages[$i]['h1']; ?></textarea>
                        </div>
                        <div>
                            <label>Аннотация</label>
                            <textarea type="text" name="<? echo $pages[$i]['name']; ?>_annotation"><? echo $pages[$i]['annotation']; ?></textarea>
                        </div>
                    <? endfor; ?>
                </div>
                <button name="submit" type="submit">Сохранить тэги</button>
            </form>
        </div>
        <div class="information_content">
            <form name="Job" method="post" action="javascript:formInfo('Job')">
                <div class="specials jobs">
                    <? if(isset($vacancys)): ?>
                        <? for($i=0; $i<$countVacancys; $i++): ?>
                            <div class="job special" data-job="<? echo $vacancys[$i]['id']; ?>">
                                <p class="delete" onclick="deleteItem(this, 'job')"></p>
                                <h3><? echo $vacancys[$i]['name']; ?></h3>
                                <div>
                                    <label>Вакансия</label>
                                    <input type="text" name="job_name" value="<? echo $vacancys[$i]['name']; ?>">
                                </div>
                                <div>
                                    <label>Описание</label>
                                    <textarea type="text" name="job_text"><? echo $vacancys[$i]['text']; ?></textarea>
                                </div>
                                <div>
                                    <label>Зарплата</label>
                                    <input type="text" name="job_salary" value="<? echo $vacancys[$i]['salary']; ?>">
                                </div>
                                <div>
                                    <label>График</label>
                                    <input type="text" name="job_worktime" value="<? echo $vacancys[$i]['worktime']; ?>">
                                </div>
                                <hr>
                            </div>
                        <? endfor; ?>
                    <? else: ?>
                        <p>Список вакансий пуст!</p>
                    <? endif; ?>
                </div>
                <p class="create_form" onclick="getButton('jobs')">Добавить новую вакансию</p>
                <button name="submit" type="submit">Сохранить вакансии</button>
            </form>
        </div>
    </div>
</div>