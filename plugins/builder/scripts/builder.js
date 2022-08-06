//*********** Вкладки ***********//

let tabs = document.querySelectorAll('.information_tab');

tabs.forEach((item) => {
   item.onclick = function() {
       document.querySelector('.active').classList.remove('active');
       document.querySelector('.information_show').children[item.getAttribute('data-tab')].classList.add('active');
   } 
});

//*********** Создать формы ***********//

async function createForm() {

    let FormCreate = document.forms['formCreate'];

    let newForm = {
        type: FormCreate.elements.type.value,
        name: FormCreate.elements.name.value,
        inputs: FormCreate.elements.inputs.value
    };

    // Проверка

    let formData = new FormData();
    formData.append('ajaxSettings', 'plugins:builder:checkName');

    formData.append('type', '_forms');
    formData.append('name', newForm.name);

    let data = await fetch('/Ajax.php', {
        method: 'POST',
        body: formData
    });

    let errors = document.querySelector('.formCreate_errors');

    if(await data.text() == 'clear') {

        errors.textContent = '';

        // Создание формы

        let DIV, element, attribute;
        let FormAdd = document.getElementById('form');

        attribute = document.createAttribute('data-name');
        attribute.value = newForm.name;
        FormAdd.setAttributeNode(attribute);

        if(FormAdd.children.length != 0) FormAdd.innerText = '';

        for(let i = 0; i < newForm.inputs; i++) {

            DIV = document.createElement('div');
            FormAdd.appendChild(DIV);

            attribute = document.createAttribute('class');
            attribute.value = "tasks__item";
            DIV.setAttributeNode(attribute);

            element = document.createElement('input');
            DIV.appendChild(element);

            attribute = document.createAttribute('type');
            attribute.value = 'text';
            element.setAttributeNode(attribute);

            attribute = document.createAttribute('placeholder');
            attribute.value = 'Описание поля input';
            element.setAttributeNode(attribute);

            attribute = document.createAttribute('data-type');
            attribute.value = 'input';
            element.setAttributeNode(attribute);

            attribute = document.createAttribute('minlength');
            attribute.value = '3';
            element.setAttributeNode(attribute);

            attribute = document.createAttribute('required');
            element.setAttributeNode(attribute);

            // Кнопка переместить

            element = document.createElement('p');
            DIV.appendChild(element);

            attribute = document.createAttribute('class');
            attribute.value = "moveInput";
            element.setAttributeNode(attribute);

            attribute = document.createAttribute('onmouseover');
            attribute.value = 'setMove(this)';
            element.setAttributeNode(attribute);

            // Кнопка удалить

            element = document.createElement('p');
            DIV.appendChild(element);

            attribute = document.createAttribute('class');
            attribute.value = "deleteInput";
            element.setAttributeNode(attribute);

            attribute = document.createAttribute('onclick');
            attribute.value = 'deleteInput(this)';
            element.setAttributeNode(attribute);
        }

        let formAdd = document.getElementById('formAdd');
        formAdd.style.display = 'flex';

        let elements = formAdd.getElementsByTagName('input');
        if(elements.length != 0) document.querySelector('.addForm').style.display = 'flex';

    } else {
        errors.textContent = 'Имя кнопки уже используется!';
    }
}

// Перетащить поле

function setMove(el) {

    let tasksListElement = document.querySelector(`.tasks__list`);
    let taskElements = tasksListElement.querySelectorAll(`.tasks__item`);

    for(let task of taskElements) task.draggable = true;

    tasksListElement.addEventListener(`dragstart`, (evt) => {	
        evt.target.classList.add(`selected`);
    });

    tasksListElement.addEventListener(`dragend`, (evt) => {
        evt.target.classList.remove(`selected`);
    });

    let getNextElement = (cursorPosition, currentElement) => {

        let currentElementCoord = currentElement.getBoundingClientRect();
        let currentElementCenter = currentElementCoord.y + currentElementCoord.height / 2;

        let nextElement = (cursorPosition < currentElementCenter) ? currentElement : currentElement.nextElementSibling;
        
        return nextElement;
    };

    tasksListElement.addEventListener(`dragover`, (evt) => {

        evt.preventDefault();

        let activeElement = tasksListElement.querySelector(`.selected`);
        let currentElement = evt.target;
        let isMoveable = activeElement !== currentElement && currentElement.classList.contains(`tasks__item`);

        if(!isMoveable) return;

        let nextElement = getNextElement(evt.clientY, currentElement);

        if(nextElement && activeElement === nextElement.previousElementSibling || activeElement === nextElement) return;

        tasksListElement.insertBefore(activeElement, nextElement);
    });

    // Отмена перетаскивания

    el.addEventListener(`mouseout`, () => {
        taskElements.forEach((item) => {
            item.draggable = false;
        });
    });
}

// Удалить поле

function deleteInput(item) {

    item.parentNode.remove()

    // Кнопка сохранить

    let formAdd = document.getElementById('form');
    let elements = formAdd.getElementsByTagName('input');
    console.log(elements.length )
    if(elements.length == 0) document.querySelector('.addForm').style.display = 'none'
}

// Добавить новое поле

function addInput(type) {

    let FormAdd = document.getElementById('form');
    let DIV, element, attribute;

    DIV = document.createElement('div');
    FormAdd.appendChild(DIV);

    attribute = document.createAttribute('class');
    attribute.value = "tasks__item";
    DIV.setAttributeNode(attribute);

    element = document.createElement('input');
    DIV.appendChild(element);

    attribute = document.createAttribute('type');
    attribute.value = 'text';
    element.setAttributeNode(attribute);

    attribute = document.createAttribute('placeholder');
    attribute.value = 'Описание поля ' + type;
    element.setAttributeNode(attribute);

    attribute = document.createAttribute('draggable');
    attribute.value = "true";
    element.setAttributeNode(attribute);

    attribute = document.createAttribute('data-type');
    attribute.value = type;
    element.setAttributeNode(attribute);

    attribute = document.createAttribute('minlength');
    attribute.value = '3';
    element.setAttributeNode(attribute);

    attribute = document.createAttribute('required');
    element.setAttributeNode(attribute);

    // Кнопка переместить

    element = document.createElement('p');
    DIV.appendChild(element);

    attribute = document.createAttribute('class');
    attribute.value = "moveInput";
    element.setAttributeNode(attribute);

    attribute = document.createAttribute('onmouseover');
    attribute.value = 'setMove(this)';
    element.setAttributeNode(attribute);

    // Кнопка удалить

    element = document.createElement('p');
    DIV.appendChild(element);

    attribute = document.createAttribute('onclick');
    attribute.value = 'deleteInput(this)';
    element.setAttributeNode(attribute);

    attribute = document.createAttribute('class');
    attribute.value = "deleteInput";
    element.setAttributeNode(attribute);

    // Кнопка сохранить

    let formAdd = document.getElementById('formAdd');
    let elements = formAdd.getElementsByTagName('input');
    if(elements.length != 0) document.querySelector('.addForm').style.display = 'flex';
}

//*********** Сохранить форму ***********//

async function addForm(name) {

    let form = document.forms[name];
    let elements = form.getElementsByTagName('input');

    let FormAdd = document.getElementById('form');
    let nameS = FormAdd.getAttribute('data-name');

    let collection = {};
    let map = new Map();

    // Основной блок

    collection.main = {
        div: 'no + main + block',
        data: nameS + ' + block + attribute',
        class: 'special + block + attribute'
    }

    map.set('main', collection.main);

    // Кнопка удалить форму

    collection.button = {
        p: 'no + block + wrapper',
        onclick: `deleteItem(this, ${nameS}) + wrapper + attribute`,
        class: 'delete + wrapper + attribute'
    }

    map.set('button', collection.button);

    // Поля формы

    let type, map_i, field_type;
    let fields = '';

    for(let i = 0; i < elements.length; i++) {

        map_i = `${nameS}_${i}`;
        type = elements[i].getAttribute('data-type');

        if(type == 'file') {
            type = 'input';
            field_type = 'file + field + attribute'
        } else {
            field_type = 'text + field + attribute'
            fields += `${map_i}___${type},`;
        }

        collection[map_i] = {
            div: 'no + block + wrapper',
            label: `${elements[i].value} + wrapper + label`,
            [type]: 'no + wrapper + field',
            type: field_type,
            name: `${map_i} + field + attribute`
        }

        map.set(map_i, collection[map_i]);
    }

    // Граница формы

    collection.border = {
        hr: 'no + block + other'
    }

    map.set('border', collection.border);

    // JSON-преобразователь map

    function mapToObj(maps) {
        return [...maps].reduce((acc, val) => {
            acc[val[0]] = val[1];
            return acc;
        }, {});
    }

    let json = JSON.stringify(mapToObj(map));

    // Загрузка объекта

    let formData = new FormData();

    formData.append('ajaxSettings', 'plugins:builder:addForm');

    formData.append('fields', fields);
    formData.append('name', nameS);
    formData.append('button', json);

    let data = await fetch('/Ajax.php', {
        method: 'POST',
        body: formData
    });

    document.location.href = 'builder';
}