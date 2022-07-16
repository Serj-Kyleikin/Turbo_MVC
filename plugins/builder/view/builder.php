<div class="builder">
    <div class="information_menu">
        <h3>Меню конструктора</h3>
        <p data-tab="0" class="information_tab">Создать форму</p>
    </div>
    <div class="information_show">
        <div class="information_content active">
            <form id="formCreate" name="formCreate" method="post" action="javascript:createForm()">
                <div>
                    <div>
                        <label>Тип</label>
                        <select name="type" onChange="selector()">
                        <option value="cabinet">Кнопка в кабинете</option>
                        </select>
                    </div>
                    <div>
                        <label>Имя</label>
                        <input type="text" name="name" minlength="4" required></input>
                    </div>
                    <div>
                        <label>Полей</label>
                        <input type="text" name="inputs"></input>
                    </div>
                </div>
                <div class="formCreate_errors"></div>
                <button class="createForm" type="submit">Создать форму</button>
            </form>
            <form id="formAdd" name="formAdd" method="post" action="javascript:addForm('formAdd')">
                <div id="form" class="tasks__list">
                    
                </div>
                <div class="addElement">
                    <div onclick="addInput('input')">Добавить input</div>
                    <div onclick="addInput('textarea')">Добавить textarea</div>
                    <div onclick="addInput('file')">Добавить file</div>
                </div>
                <button class="addForm" type="submit">Отправить форму</button>
            </form>
        </div>
    </div>
</div>