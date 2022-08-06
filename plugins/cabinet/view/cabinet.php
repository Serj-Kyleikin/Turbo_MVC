<?php

    $static = $page[0]['static'];
    $countPages = count($static['pages']);
    $countVacancys = count($static['vacancys']);

    $icons = $this->icons['page'];
?>

<div class="cabinet">
    <div class="information_menu">
        <h3>Меню администратора</h3>
        <p data-tab="0" class="information_tab">
            <img loading="lazy" width="16" height="16" src="<?=$icons['pages']; ?>">
            <span>Страницы</span>
        </p>
        <p data-tab="1" class="information_tab">
        <img loading="lazy" width="16" height="16" src="<?=$icons['jobs']; ?>">
            <span>Вакансии</span>
        </p>
    </div>
    <div class="information_show">
        <div class="information_content active">
            <form name="SettingsPages" method="post" action="javascript:updateInfo('SettingsPages')">
                <div>
                    <? for($i=0; $i<$countPages; $i++): 
                        
                        $page = $static['pages'][$i]; ?>

                        <h3><? echo $page['title']; ?></h3>
                        <div>
                            <label>meta (title)</label>
                            <textarea required type="text" name="<? echo $page['name']; ?>_name"><? echo $page['title']; ?></textarea>
                        </div>
                        <div>
                            <label>meta (description)</label>
                            <textarea required type="text" name="<? echo $page['name']; ?>_description"><? echo $page['description']; ?></textarea>
                        </div>
                        <div>
                            <label>h1</label>
                            <textarea type="text" name="<? echo $page['name']; ?>_title"><? echo $page['h1']; ?></textarea>
                        </div>
                        <div>
                            <label>Аннотация</label>
                            <textarea type="text" name="<? echo $page['name']; ?>_annotation"><? echo $page['annotation']; ?></textarea>
                        </div>
                    <? endfor; ?>
                </div>
                <button name="submit" type="submit">Сохранить тэги</button>
            </form>
        </div>
        <div class="information_content">
            <form name="Job" method="post" action="javascript:formInfo('Job')">
                <div class="specials jobs">

                    <? if(isset($static['vacancys'][0])): for($i=0; $i<$countVacancys; $i++): 
                        
                        $vacancy = $static['vacancys'][$i]; ?>

                        <div class="job special" data-job="<? echo $vacancy['id']; ?>">
                            <p class="delete" onclick="deleteItem(this, 'job')"></p>
                            <h3><? echo $vacancy['name']; ?></h3>
                            <div>
                                <label>Вакансия</label>
                                <input required type="text" name="job_name" value="<? echo $vacancy['name']; ?>">
                            </div>
                            <div>
                                <label>Описание</label>
                                <textarea required type="text" name="job_text"><? echo $vacancy['text']; ?></textarea>
                            </div>
                            <div>
                                <label>Зарплата</label>
                                <input required type="text" name="job_salary" value="<? echo $vacancy['salary']; ?>">
                            </div>
                            <div>
                                <label>График</label>
                                <input required type="text" name="job_worktime" value="<? echo $vacancy['worktime']; ?>">
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